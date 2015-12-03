<?php
/**
 * Project:
 * drugCMS Plugin Repository
 *
 * Description:
 * drugCMS Plugin class
 *
 * Requirements:
 * PHP 5.4
 * 
 *
 * @package    drugCMS Plugin Repository
 * @version    1.0.0
 * @author     René Mansveld
 * @copyright  Spider IT Deutschland
 * @license    MIT
 * @link       http://www.spider-it.de
 * @link       http://www.drugcms.org
 *
 * {@internal 
 *   created 2015-11-21
 * }}
 */

if (!defined('DRUGCMS_PLUGIN_REPO')) {
    die('Illegal call');
}

define('FNM_CASEFOLD', 16);

class PluginInfo {
    
    protected $name = '';
    
    protected $info = '';
    
    public function __construct($pluginName = '') {
        $this->pluginName($pluginName);
    }
    
    public function pluginName($pluginName) {
        $this->name = $pluginName;
        $this->_loadPluginInfo();
    }
    
    public function checkTags($sFilter) {
        $aTags = array();
        foreach ($this->info->general->tags->tag as $tag) {
            $aTags[] = strtolower((string) $tag);
        }
        $aFilter = explode(',', $sFilter);
        foreach ($aFilter as $sTag) {
            if (in_array(strtolower($sTag), $aTags)) {
                return true;
            }
        }
        return false;
    }
    
    public function getInfo() {
        if ($this->info != '') {
            $aDescriptions = array();
            if (count((array) $this->info->general->descriptions)) {
                foreach ($this->info->general->descriptions->description as $desc) {
                    $aDescriptions[(string) $desc['lang']] = (string) $desc;
                }
            }
            $aTags = array();
            if (count((array) $this->info->general->tags)) {
                foreach ($this->info->general->tags->tag as $tag) {
                    $aTags[] = (string) $tag;
                }
            }
            $aDependencies = array();
            if (count((array) $this->info->dependencies)) {
                foreach ($this->info->dependencies->plugin as $dep) {
                    $aDependencies[] = array('Name' => (string) $dep->name, 'Version' => (string) $dep->version);
                }
            }
            return array('Name' => (string) $this->info->general->name, 'Description' => $aDescriptions, 'Tags' => $aTags, 'Author' => (string) $this->info->general->author, 'Version' => (string) $this->info->general->version, 'Copyright' => (string) $this->info->general->copyright, 'Requirements' => array('php' => (string) $this->info->requirements->php, 'drugcms' => (string) $this->info->requirements->drugcms), 'Dependencies' => $aDependencies);
        }
        else {
            return false;
        }
    }
    
    public function getFoldersAndFilesList() {
        return $this->_getFoldersAndFilesRecursively(PLUGINS_DIR . $this->name);
    }
    
    public function getFile($sFile) {
        if (is_file(PLUGINS_DIR . $this->name . '/' . $sFile)) {
            # Send the file
            $total = filesize(PLUGINS_DIR . $this->name . '/' . $sFile);
            header('Cache-control: private');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . $total);
            header('Content-Disposition: filename="' . basename($sFile) . '"');
            flush();
            $fp = fopen(PLUGINS_DIR . $this->name . '/' . $sFile, 'r');
            $current = 0;
            while ($current < $total) {
                print fread($fp, 4096);
                flush();
                $current += 4096;
            }
            fclose($fp);
            return true;
        }
        else {
            return false;
        }
    }
    
    public function getZipFile() {
        if ((is_file(PLUGINS_DIR . $this->name . '/plugin.zip')) && (filemtime(PLUGINS_DIR . $this->name . '/plugin.zip') < filemtime(PLUGINS_DIR . $this->name . '/plugin.xml'))) {
            # Zip is there, but older than xml, delete it
            unlink(PLUGINS_DIR . $this->name . '/plugin.zip');
        }
        if (!is_file(PLUGINS_DIR . $this->name . '/plugin.zip')) {
            if (class_exists('ZipArchive')) {
                # Zip the entire package
                $zip = new ZipArchive();
                if ($zip->open(PLUGINS_DIR . $this->name . '/plugin.zip', ZipArchive::CREATE) === true) {
                    $aFiles = $this->_getFoldersAndFilesRecursively(PLUGINS_DIR . $this->name);
                    for ($i = 0, $n = count($aFiles); $i < $n; $i ++) {
                        if (is_dir(PLUGINS_DIR . $this->name . '/' . $aFiles[$i])) {
                            $zip->addFromString($aFiles[$i] . 'index.php', '<?php die("Illegal Call"); ?>');
                        }
                        else {
                            $zip->addFile(PLUGINS_DIR . $this->name . '/' . $aFiles[$i], '' . $aFiles[$i]);
                        }
                    }
                }
                $zip->close();
            }
        }
        if (is_file(PLUGINS_DIR . $this->name . '/plugin.zip')) {
            # Send the zip file
            $total = filesize(PLUGINS_DIR . $this->name . '/plugin.zip');
            header('Cache-control: private');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . $total);
            header('Content-Disposition: filename="' . $this->name . '.zip"');
            flush();
            $fp = fopen(PLUGINS_DIR . $this->name . '/plugin.zip', 'r');
            $current = 0;
            while ($current < $total) {
                print fread($fp, 4096);
                flush();
                $current += 4096;
            }
            fclose($fp);
            return true;
        }
        else {
            return false;
        }
    }
    
    protected function _loadPluginInfo() {
        if (strlen($this->name)) {
            $this->info = simplexml_load_file(PLUGINS_DIR . $this->name . '/plugin.xml');
        }
        else {
            $this->info = '';
        }
    }
    
    protected function _getFoldersAndFilesRecursively($sDir, $sRootDir = '') {
        $aDirs = array();
        $aFiles = array();
        if (substr($sDir, -1) != '/') {
            $sDir .= '/';
        }
        if (strlen($sRootDir) == 0) {
            $sRootDir = $sDir;
        }
        if (is_dir($sDir)) {
            if ($oDir = opendir($sDir)) {
                while (($sFile = readdir($oDir)) !== false) {
                    if (is_dir($sDir . $sFile)) {
                        if (($sFile != '.') && ($sFile != '..')) {
                            $aDirs[] = $sFile;
                        }
                    }
                    elseif (($sDir != $sRootDir) || ($sFile != 'plugin.zip')) {
                        $aFiles[] = str_replace($sRootDir, '', $sDir) . $sFile;
                    }
                }
                closedir($oDir);
            }
        }
        sort($aFiles, SORT_STRING);
        sort($aDirs, SORT_STRING);
        for ($i = 0, $n = count($aDirs); $i < $n; $i ++) {
            $aFiles[] = str_replace($sRootDir, '', $sDir) . $aDirs[$i] . '/';
            $aFiles = array_merge($aFiles, $this->_getFoldersAndFilesRecursively($sDir . $aDirs[$i], $sRootDir));
        }
        return $aFiles;
    }
}
?>