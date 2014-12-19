<?php 
	/* the url locarion of this file */
	$clientDir = '';
	
	/* Your user id */
	$mustbeUid = 'publicUser';
	
	$editorDir = 'editor/';
	
	$locationOfEditor = $clientDir.$editorDir;
	
	/* address of the php file that displays templates */
	$templatePageAddr = 'http://client.zimplit.com/ztemplates/'; /* can be a php or html file too */
	/* address of the directory where template zip file are */
	$templateFilesDir =  'http://client.zimplit.com/ztemplates/';
	
	/* suffixes of language files and according language names: editor/languages/lang_[suffix].php */
	$languages = array(
		'en' => 'English',
		'et' => 'Eesti',
		'de' => 'Deutsch',
		'se' => 'Svenska',
		'fi' => 'Suomi',
		'it' => 'itaalia',
	);
	
	/* suffix of the default language file in case user has not selected one */
	$defaultLang = 'en';
	
?>