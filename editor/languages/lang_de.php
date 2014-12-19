<?php

/*
do not write single quote ' into language text or if really needed escape like this: \'
*/

	$LangTexts = array(
		'save' => 'Speichern',
		'cancel' => 'Abbrechen',
		'ok' => 'OK',
		'wait' => 'Bitte warten!',
		'help' => 'Hilfe!',
		'continue' => 'Weiter',
		'language' => 'Sprache:',

		'empty_editable' => 'Klicken Sie hier, um Inhalte einzugeben',

		'username' => 'Benutzername',
		'password' => 'Passwort',
		 'start' => 'Start!',
		'rememberme' => 'Zugangsdaten merken!',
		'forgotpass' => 'Passwort vergessen?',
		'login' => 'Einloggen',

		'register_fields_not_filled' => 'Einige Felder wurden nicht ausgef&uuml;llt:',
		'register_nousername' => 'Benutzername nicht angegeben.',
		'register_email' => 'Ihre E-mail Adresse',
		'register_noemail' => 'E-mail nicht angegeben.',
		'register_nopassword' => 'Passwort nicht angegeben.',
		'register_passwordnomatch' => 'Passwort und Passwort Wiederholung stimmen nicht &uuml;berein.',
		'register_retypepassword' => 'Passwort wiederholen',
		'register_why' => 'Warum ist dies notwendig?',

		'create_account' => 'Nutzerzugang anlegen!',

		'changepass_title' => 'Passwort &auml;ndern',
		'changepass_directions' => 'Ein neues Passwort wurde erzeugt und an Ihre E-mail Adresse geschickt.<br/><br/>Schauen Sie in Ihren Posteingang.<br/> Um sich einzuloggen klicken Sie OK.',
		'changepass_directions2' => 'Eine E-Mail mit der Best&auml;tigung f&uuml;r ein neues Passwort wurde an Ihre E-mail Adresse geschickt. <br/><br/> Schauen Sie in Ihren Posteingang um das <br/>Password zu best&auml;tigen!',
		'changepass_fail' => 'Passwort Best&auml;tigung fehlgeschlagen<br/><br/>Dieser Fehler kann entstehen, wenn jemand bereits eine Passwort&auml;nderung angefordert hat.',


		'module_scripter_title' => 'Script hinzuf&uuml;gen',
		'module_scripter_description' => 'Hiermit k&ouml;nnen Sie Scripte und anderen Quellcode hinzuf&uuml;gen.',
		'module_scripter_optview1' => 'Html welches auf einer &ouml;ffentlichen Seite angezeigt wird:',
		'module_scripter_optview2' => 'Html welches in Zimplit angezeigt wird:',
		'module_scripter_error1' => 'Das Script Modul kann die Datei nicht erzeugen',

		'module_googlesearch_title' => 'Google Suche',
		'module_googlesearch_description' => '<span style="font-size: 18px;">Google Suche.</span> Hiermit k&ouml;nnen Sie ein Google Suchfeld hinzuf&uuml;gen, dass den Inhalt Ihrer Webseite durchsucht.',
		'module_googlesearch_optview' => 'Website Adresse f&uuml;r die Suche:',
		'module_googlesearch_notify1' => 'Um das Google Suchfeld hinzuzuf&uuml;gen, speichern Sie die Seite.',

		'menu_save_tooltip' => 'Seite speichern',
		'menu_newpage_tooltip' => 'Neue Seite',
		'menu_undo_tooltip' => 'Abbrechen',
		'menu_redo_tooltip' => 'Wiederherstellen',
		'menu_bold_tooltip' => 'Fett',
		'menu_italic_tooltip' => 'Kursiv',
		'menu_underline_tooltip' => 'Unterstrichen',
		'menu_fontsize_tooltip' => 'Text formatieren',
		'menu_link_tooltip' => 'Link hinz&uuml;f&uuml;gen',
		'menu_image_tooltip' => 'Bild hinzuf&uuml;gen',
		'menu_add_tooltip' => 'Element zur Seite hinzuf&uuml;gen',
		'menu_settings_tooltip' => 'Einstellungen',

		'properties_image_title' => 'Bild hinzuf&uuml;gen',
		'properties_image_description' => '<span style="font-size: 18px;">Bild </span> Hier k&ouml;nnen Sie ein Bild hochladen. W&auml;hlen Sie die Bildausrichtung und ggf. die "klick und vergr&ouml;&szlig;ern" Option. Die "klick und vergr&ouml;&szlig;ern" Option erstellt ein klickbares Thumbnail des Bildes. <a href="http://www.zimplit.org/faq_and_docs.html#06" target="_blank">Mehr dazu</a> ',
		'properties_image_clickandzoom' => 'klick und vergr&ouml;&szlig;ern',

		'properties_newpage_title' => 'Neue Seite',
		'properties_newpage_description' => '<span style="font-size: 18px;">Kopieren </span>Geben Sie einen Namen f&uuml;r die neue Seite an und w&auml;hlen Sie eine existierende Seite als Kopiervorlage. <a href="http://www.zimplit.org/faq_and_docs.html#01" target="_blank">Mehr dazu</a>',
		'properties_newpage_pagename' => 'Seitenname',
		'properties_newpage_pagetocopy' => 'Seite, die kopiert werden soll',

		'properties_menustructure_title' => 'Men&uuml; Struktur',
		'properties_menustructure_description' => '<span style="font-size: 18px;">Struktur </span> Klicken Sie auf den Namen der Seite, die Sie bearbeiten oder umbenennen m&ouml;chten. <a href="http://www.zimplit.org/faq_and_docs.html#10" target="_blank">Mehr dazu</a>',
		'properties_menustructure_askname' => 'Neuen Namen eingeben',
		'properties_menustructure_rename' => 'Seite umbenennen',
		'properties_menustructure_edit' => 'Seite editieren',

		'properties_fontsize_normal' => 'Normal',
		'properties_fontsize_h1' => '&Uuml;berschrift 1',
		'properties_fontsize_h2' => '&Uuml;berschrift 2',
		'properties_fontsize_h3' => '&Uuml;berschrift 3',

		'properties_source_title' => 'Quelltext editieren',

		'properties_firefoxpaste_title' => 'F&uuml;gen Sie Ihren Text hier ein',
		'properties_firefoxpaste_paste' => 'Einf&uuml;gen',

		'properties_settings_filemanager' => 'Dateimanager',
		'properties_settings_picprops' => 'Standard Bild Einstellungen',
		'properties_settings_changetemplate' => 'Template &auml;ndern',
		'properties_settings_deletepage' => 'Seite l&ouml;schen',
		'properties_settings_pagesource' => 'Seiten Quelltext',
		'properties_settings_menustruc' => 'Men&uuml; Struktur anzeigen',
		'properties_settings_addmainmenu' => 'Hauptmen&uuml; hinzuf&uuml;gen',
		'properties_settings_addsubmenu' => 'Submen&uuml; zu dieser Seite hinzuf&uuml;gen',

		'properties_imagesettings_title' => 'Bilder Einstellungen',
		'properties_imagesettings_description' => '<span style="font-size: 18px;">Bild </span>  Einstellungen',
		'properties_imagesettings_smallimage' => 'Standardgr&ouml;&szlig;e f&uuml;r kleines Bild (Thumbnail)',
		'properties_imagesettings_largeimage' => 'Standardgr&ouml;&szlig;e f&uuml;r gro&szlig;es Bild',

		'properties_insert_file' => 'File',
		'properties_insert_youtube' => 'YouTube Video',

		'properties_insertfile_title' => 'Datei hinzuf&uuml;gen',
		'properties_insertfile_description' => '<span style="font-size: 18px;">Datei </span> Hier k&ouml;nnen Sie eine Datei hochladen. Ein Link zur Datei wird an der Stelle des Cursors erzeugt.',

		'properties_youtube_title' => 'YouTube Video hinzuf&uuml;gen',
		'properties_youtube_description' => '<span style="font-size: 18px;">Video </span> Hier k&ouml;nnen Sie ein YouTube Video zu Ihrer Webseite hinzuf&uuml;gen',
		'properties_youtube_url' => 'F&uuml;gen Sie die URL des Your YouTube Videos ein:',
		'properties_youtube_example' => 'Beispiel: http://www.youtube.com/yourvideo123',
		'properties_youtube_diplayprops' => 'Einstellungen anzeigen:',
		'properties_youtube_includespace' => 'Abstand zum Video hinzuf&uuml;gen',
		'properties_youtube_includetitle' => 'Titel hinzuf&uuml;gen',

		'properties_template_title' => 'Template &auml;ndern',
		'properties_template_description' => 'Hier k&ouml;nnen Sie ein neues Design f&uuml;r Ihre gesammte Website ausw&auml;hlen.<br/><br/><b style="color:#FF0000;">Alle Seiten werden ge&auml;ndert, evtl. gehen Inhalte verloren! M&ouml;chten Sie wirklich fortfahren?</b>',

		'properties_filemanager_deletedir' => 'Verzeichnis l&ouml;schen',
		'properties_filemanager_imgpreview' => 'Bildvorschau',
		'properties_filemanager_renamefile' => 'Datei umbenennen',
		'properties_filemanager_deletefile' => 'Datei l&ouml;schen',
		'properties_filemanager_currentpath' => 'Derzeitiger Pfad:',

		'error_cannotsave' => 'Ein Fehler ist aufgetreten. Die Aktion konnte nicht gesichert werden. Sorry! Bitte laden Sie Ihr Browserfenster neu.',
		'error_nocursor' => 'Der Text Cursor wurde nicht positioniert! Das Einf&uuml;gen ist daher nicht m&ouml;glich.',
		'error_cannotshowsource' => 'Ein Fehler ist aufgetreten. Quelltext nicht anzeigbar. Sorry! Bitte laden Sie Ihr Browserfenster neu.',
		'error_cannotcreatenew' => 'Ein Fehler ist aufgetreten. Neue Seite konnte nicht erstellt werden. Sorry! Bitte laden Sie Ihr Browserfenster neu.',
		'error_cannotdelete' => 'Ein Fehler ist aufgetreten. Die Seite konnte nicht gel&ouml;scht werden. Sorry! Bitte laden Sie Ihr Browserfenster neu.',
		'error_noyoutube' => 'Sorry! Irgendwie scheint dies keine g&uuml;ltige YouTube Video Adresse zu sein',
		'error_cannotdeletepage' => 'Seiten mit bestehenden Unterseiten k&ouml;nnen nicht gel&ouml;scht werden! L&ouml;schen Sie zuerst die Unterseiten.',
		'error_cannotdeleteindex' => 'Die erste Seite kann nicht gel&ouml;scht werden. Sie k&ouml;nnen Sie jedoch bearbeiten.',
		'error_browser_opera' => 'Sorry! Einige Funktionen werden noch nicht vom Opera Browser unterst&uuml;tzt.\nWir arbeiten an der Kompatibilit&auml;t mit allen Browsern.\nBesuchen Sie zimplit.org um die aktuellsten News und Upgrades zu sichten.',
		'error_htmlnotwriteble' => 'Die Datei, die Sie bearbeiten m&ouml;chten hat keine Schreibrechte. \nPr&uuml;fen Sie die Datei-Rechte, setzen Sie diese auf 666 und laden Sie Zimplit neu. \nWenn Sie fortfahren, k&ouml;nnten Probleme auftauchen.\n Datei:',
		'error_badlocation' => 'Ihr Browser hat Fehler produziert und sendet missverst&auml;ndliche Daten &uuml;ber die Seite, die Sie bearbeiten wollen. ',


		'confirm_delete' => 'Sind Sie sicher, dass Sie dies l&ouml;schen wollen?',
	);
?>