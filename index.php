<?php
# Settings
error_reporting(E_ALL);
define('DRUGCMS_PLUGIN_REPO', 1);
define('ROOT_DIR', str_replace('\\', '/', dirname(__FILE__)) . '/');
define('CLASSES_DIR', ROOT_DIR . 'classes/');
define('PLUGINS_DIR', ROOT_DIR . 'plugins/');

# Includes
@include_once(CLASSES_DIR . 'class.plugininfo.php');

# Functions
function getAvailablePlugins($sFilter = '') {
    # First list all plugin folders
    $aPlugins = array();
    if ($dh = opendir(PLUGINS_DIR)) {
        while (($sEntry = readdir($dh)) !== false) {
            if ((is_dir(PLUGINS_DIR . $sEntry)) && (substr($sEntry, 0, 1) != '.')) {
                $aPlugins[$sEntry] = array();
            }
        }
        closedir($dh);
    }
    
    # Then get the plugin info's from their plugin.xml files
    $oPlugin = new PluginInfo();
    foreach ($aPlugins as $key => $value) {
        $oPlugin->pluginName($key);
        
        # If a filter is specified, filter out the plugins without those tags
        if (strlen($sFilter)) {
            if ($oPlugin->checkTags($sFilter)) {
                $aPlugins[$key] = $oPlugin->getInfo();
            }
            else {
                unset($aPlugins[$key]);
            }
        }
        else {
            $aPlugins[$key] = $oPlugin->getInfo();
        }
    }
    return $aPlugins;
}
function safeStringEscape($string) { 
    $escapeCount = 0;
    $targetString = '';
    for($offset = 0; $offset < strlen($string); $offset ++) {
        switch ($c = $string{$offset}) {
            case "'":
                if ($escapeCount % 2 == 0) {
                    $targetString .= "\\";
                }
                $escapeCount = 0;
                $targetString .= $c;
                break;
            case '"':
                if ($escapeCount % 2 == 0) {
                    $targetString .= "\\";
                }
                $escapeCount = 0;
                $targetString .= $c;
                break;
            case '\\':
                $escapeCount ++ ;
                $targetString .= $c;
                break;
            default:
                $escapeCount = 0;
                $targetString .= $c;
        }
    }
    return $targetString;
}

# Execution
if (isset($_REQUEST['Action'])) {
    $sAction = safeStringEscape($_REQUEST['Action']);
}
else {
    $sAction = '';
}
if (isset($_REQUEST['Plugin'])) {
    $sPlugin = safeStringEscape($_REQUEST['Plugin']);
}
else {
    $sPlugin = '';
}
switch ($sAction) {
    case 'Files':
        $oPlugin = new PluginInfo($sPlugin);
        echo json_encode($oPlugin->getFoldersAndFilesList(), true);
        #echo '<pre>'; var_dump(json_decode(json_encode($oPlugin->getFoldersAndFilesList(), true))); echo '</pre>';
        break;
    case 'GetFile':
        if (isset($_REQUEST['File'])) {
            $sFile = safeStringEscape($_REQUEST['File']);
            $oPlugin = new PluginInfo($sPlugin);
            $oPlugin->getFile($sFile);
        }
        break;
    case 'GetZip':
        $oPlugin = new PluginInfo($sPlugin);
        $oPlugin->getZipFile();
    case 'List':
    default:
        if (isset($_REQUEST['Filter'])) {
            $sFilter = safeStringEscape($_REQUEST['Filter']);
        }
        else {
            $sFilter = '';
        }
        $aPlugins = getAvailablePlugins($sFilter);
        echo json_encode($aPlugins);
#        echo '<pre>'; var_dump(json_decode($sOutput, true)); echo '</pre>';
        #echo '<pre>'; var_dump(json_decode(json_encode($aPlugins), true)); echo '</pre>';
        break;
}
?>