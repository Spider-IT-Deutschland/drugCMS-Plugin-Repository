drugCMS Plugin Repository 1.0.0
Lizenz:        MIT
Copyright:     (c) 2015, Spider IT Deutschland
Information:   http://www.drugcms.org

<take care>
WARNUNG: Versionen, die mit alpha oder beta markiert sind,
sind definitiv nicht für den produktiven Einsatz gedacht.
alpha Versionen und GIT Snapshots enthalten nahezu immer Bugs!
</take care>

Keine Haftung und Gewährleistung für mittelbare und unmittelbare
Schäden. Weitere Infos finden Sie in der MIT-Lizenz.

<take care>
WARNING: Please do not use versions marked as alpha or beta
for productive systems - never. alpha versions or git snapshots
contain bugs - in most cases!
</take care>

No Warranty - take a look at the MIT licence.

-------------------------------------------------------------------


Inhaltsverzeichnis / Table of Contents:

I:       Deutsche Version README

1) Voraussetzungen Installation
2) Installation
3) Voraussetzungen Upgrade
4) Upgrade
5) Handbuch


II:      English version README

1) Installation requirements
2) Installation
3) Upgrade requirements
4) Upgrade
5) Manual (only available in german)



-------------------------------------------------------------------
-------------------------------------------------------------------
I:       Deutsche Version README
-------------------------------------------------------------------
1) Voraussetzungen für die Installation
-------------------------------------------------------------------

- PHP5
- Webserver Apache ab Version 2, IIS oder andere (Empfehlung: Apache)

  drugCMS Plugin Repository ist plattformunabhängig.

  Wichtig: Bitte deaktivieren Sie sämtliche Firewalls wie Zone Alarm
  und Norton Internet Security. Diese Anwendungen verhindern u. U.
  die ordnungsgemäße Funktionsweise von drugCMS Plugin Repository.
  

-------------------------------------------------------------------
2) Installation
-------------------------------------------------------------------

1.
Entpacken Sie die ZIP-Datei der entsprechenden Version in einen 
Ordner Ihres Webservers (unter Apache: schauen Sie in der 
Konfigurationsdatei httpd.conf nach, in den meisten Fällen ist 
es der Ordner oder ein Unterordner in "htdocs/").

Beim Entpacken (und ggf. beim Hochladen via FTP) muss die Groß-
und Kleinschreibung der Ordner und Dateien erhalten bleiben. Empfehlung 
für die Übertragung via FTP: FileZilla (http://filezilla.sourceforge.net). 

2. 
Setzen sie die Zugriffsrechte der nachfolgenden Ordner: 

plugins/ 

auf rwxrwxrwx. (z.B.: chmod 0777 plugins/) 

3.
Legen Sie Ihre Plugins, welche Sie für die Nutzung des Repositories
vorbereitet haben, in diesem Ordner ab.

4.
Korrigieren Sie ggf. die Zugriffsrechte je Plugin-Hauptordner auf
rwxrwxrwx. (z.B.: chmod 0777 plugins/sitShop/).


-------------------------------------------------------------------
-------------------------------------------------------------------


-------------------------------------------------------------------
-------------------------------------------------------------------
II:       English Version README
-------------------------------------------------------------------
1) Installation requirements
-------------------------------------------------------------------

- PHP5
- Webserver Apache Version 2, IIS or others (Recommendation: Apache)

  drugCMS Plugin Repository is OS independent.
           
  Important: Please deactivate all firewalls like Zone Alarm and
  Norton Internet Security. Those applications may prevent proper
  functioning of drugCMS Plugin Repository.

-------------------------------------------------------------------
2) Installation
-------------------------------------------------------------------


1.
Unzip the distribution .ZIP into a folder of your webserver (Apache: 
the "DocumentRoot" is defined in the file 'httpd.conf'. Usually it is 
located in the directory 'htdocs/')

Please use an FTP tool that doesn't change the capitalization. Our
recommendation: FileZilla (http://filezilla.sourceforge.net). 

2. 
Change the access rights for the following folders:

plugins/

to rwxrwxrwx. (e.g. chmod 0777 plugins/) 

3.
Place your plugins, which are prepared for use in the drugCMS Plugin
Repository, in this folder.

4.
Correct the access rights for each plugins's main folder to
rwxrwxrwx. (e.g. chmod 0777 plugins/sitShop/). 


-------------------------------------------------------------------
-------------------------------------------------------------------


Alle Informationen zu Gewährleistung, Garantie und
Lizenzbestimmungen finden Sie unter www.drugCMS.org.

All information about warranty, guarantee and licence is
provided on www.drugCMS.org.

Stadtoldendorf, 2015-12-03
Ihr drugCMS-Team / Your drugCMS-Team


License:

drugCMS Plugin Repository is written and distributed under the MIT License 
which means that its source code is freely-distributed and available to the 
general public.

