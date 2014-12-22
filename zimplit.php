<?php

/*
Zimplit CMS version 3.0

Zimplit GNU Affero General Public Licence Version 3
=======================================================================
This program is licensed under the AGPLv3 with the additional restriction that no other brands, trade names, trademarks or service marks may be used for derivative products as specified in AGPLv3 section 7(e).

All names, links and logos of Zimplit must be kept as in original distribution without any changes in all software screens, specially in start-up page and the software header, even if the application source code has been changed or updated or code has been added.

Additionally you are required to keep a visible link to Zimplit Legal Notices as specified in AGPLv3 section 5(d) and 7(b). The required link to the Zimplit Legal Notices must be static, visible and readable, and the text in the Zimplit Legal Notices may not be altered.

If you need commercial licence to remove this kind of restrictions please contact us.

You can see the AGPLv3 licence at: http://www.gnu.org/licenses/agpl.html
======================================================================= 

*/

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE); 


/**
 * @param action: load - sends a html file content as response.
 * Use 'file' parameter to specify the HTML file.
 * 
 * Example: zimplit.php?action=load&file=page.html
 * 
 * 
 * @param action: save - saves a HTML source to a file.
 * Use 'file' parameter to specify the HTML file.
 * Use 'html' POST variable, to pass HTML source.
 * 
 * Example: zimplit.php?action=save&file=page.html;
 * 			html="<html>....</html>"
 * 
 * 
 * @param action: new - creates a new empty html file.
 * Use 'file' parameter to specify the HTML file.
 * 
 * Example: zimplit.php?action=new&file=page.html
 * 
 * 
 * @param action: delete - deletes a file.
 * Use 'file' parameter to specify the file.
 * Note: if the file is not in the webroot directory, the folder must be specified
 * 
 * Example: zimplit.php?action=delete&file=page.html
 * Example: zimplit.php?action=delete&file=Z-files/page.html
 * 
 * 
 * @param action: upload - uploads a file to a server.
 * Use 'folder' parameter (optional) to specify the folder, where the uploaded file must be moved.
 * Use 'file' POST variable, to pass the file. input="file".
 * 
 * Example: zimplit.php?action=upload&folder=Z-pictures;
 * 			file=[Binary stream].
 * 
 *
 * @param action: rename - renames a file.
 * Use 'oldname' parameter to specify the old name of the existing file.
 * Use 'newname' parameter to specify the new name of the file.
 * Note: if the file is not in the webroot directory, the folder must be specified
 * 
 * Example: zimplit.php?action=rename&oldname=oldpage.html&newname=newpage.html
 * 
 * 
 * @param action: changeuserpass - changes username & password data.
 * Use 'username' parameter to specify the new username of the existing file.
 * Use 'password' parameter to specify the new name of the file.
 * 
 * Example: zimplit.php?action=changeuserpass
 * Use 'username' POST variable, to pass the username.
 * Use 'password' POST variable, to pass the password.
 * 
 * 
 * @param action: generatenewpassword - generates a new password and sends it by email.
 * Use 'securitycode' parameter to pass a security code for email verification.
 * Example: zimplit.php?action=generatenewpassword
 * 
 * 
 * @param action: listfiles - returns a list of files in the webroot directory.
 * 
 * Example: zimplit.php?action=listfiles
 */

/* get config file */ 
require 'Zconfig.php';

//GET data
$GDsupport = false; 
if (extension_loaded('gd') && function_exists('gd_info')) {
    $GDsupport = true; 
}
 
if (!isset($_GET['action'])){ $action = NULL; } else {$action = $_GET['action'];}
if (!isset($_GET['file'])){	$file = NULL;} else {$file = htmlspecialchars($_GET['file'], ENT_QUOTES, 'UTF-8');}
if (!isset($_GET['page'])){	$page = NULL;} else {$page = $_GET['page'];}

if (!isset($_GET['max_width'])){$max_width = NULL;} else {$max_width = $_GET['max_width'];}
if (!isset($_GET['max_height'])){$max_height = NULL;} else {$max_height = $_GET['max_height'];}
if (!isset($_GET['folder'])){$folder = NULL;} else {$folder = $_GET['folder'];}
if (!isset($_GET['oldname'])){$oldName = NULL;} else {$oldName = $_GET['oldname'];}
if (!isset($_GET['newname'])){$newName = NULL;} else {$newName = $_GET['newname'];}
if (!isset($_GET['title'])){$title = NULL;} else {$title = urldecode($_GET['title']);}
if (isset($_GET['securitycode'])){	$securityCode = $_GET['securitycode'];}
$indexFile = getIndexFile();

//POST data
if (!isset($_POST['html'])){$html = NULL;} else {$html = $_POST['html'];}
if (isset($_POST['username'])){$username = $_POST['username'];}
if (isset($_POST['password'])){$password = $_POST['password'];}
if (isset($_POST['password_again'])){$password_again = $_POST['password_again'];}
if (!isset($_POST['email'])){$email = NULL;} else {$email = $_POST['email'];} 
if (!isset($_POST['remember'])){$remember = NULL;} else {$remember = $_POST['remember'];}

/* section of language and storing it in cookie */
if(isset($_POST['lang'])){
	$settings['lang'] =$_POST['lang']; 
	setcookie("ZsessionLang", $settings['lang'], time()+60*60*24*30); 
} else if (isset($_GET['lang'])){
	$settings['lang'] =$_GET['lang']; 
	setcookie("ZsessionLang", $settings['lang'], time()+60*60*24*30); 
} else if (isset($_COOKIE['ZsessionLang'])){
	if($_COOKIE['ZsessionLang'] != ''){
		$settings['lang'] = $_COOKIE['ZsessionLang'];
	} else {
		$settings['lang'] = $defaultLang;
	}
}else{
	$settings['lang'] = $defaultLang;
}

//Settings
$userID = $mustbeUid;
$version = '3.0';
preg_match('/([^\/]+\.php)/', $_SERVER['SCRIPT_NAME'], $matches1);
$settings['thisPhp'] = $matches1[1];
$settings['filesFolder'] = 'Z-files';
$settings['picturesFolder'] = 'Z-pictures';
$settings['scriptsFolder'] = 'Z-scripts';
$settings['loginHtmlFile'] = 'login.html';
$settings['registerHtmlFile'] = 'register.html';
$settings['passfile'] = 'security.php';
$settings['menufile'] = 'Zmenu.js';
$settings['settingsfile'] = 'Zsettings.js';
$settings['reminderContent'] = "You have requested a new password for Your Zimplit web editor. \nUsername: [username]\nPassword: [password]";
$settings['confirmationContent'] = "To confirm password change of Your Zimplit editor visit link \n";


/* for file downloader */
$currentCssPath ='';
$currentAbsPath ='';

include $editorDir.'user.php';
$settings['templates_remote_path'] = getExtParam('templpagepath'); 

//Local variables
$processRequest = false;

function writePassfileParam($parameter, $value) {
	global $settings;
	$content = file_get_contents($settings['passfile']);
    $fhandle = fopen($settings['passfile'], 'w');
	$matchNr = preg_match('/\$'.$parameter.'=\"([^\"]*)\"/', $content);
    if ($matchNr == 0) {
        $content = str_replace('?>', '$'.$parameter.'="'.$value.'"; ?>', $content);
    } else {
        $content = preg_replace('/\$'.$parameter.'=\"([^\"]*)\"/', '$'.$parameter.'="'.$value.'"', $content);
    }
    $r = fwrite($fhandle, $content);
    fclose($fhandle);
}

function readPassfileParam($parameter) {
	global $settings;
	$content = file_get_contents($settings['passfile']);
	preg_match('/\$'.$parameter.'=\"([^\"]*)\"/', $content, $matches);
	$result = $matches[1];
    return $result;
}

function writePassfile($username, $password, $email, $sessionId) {
    global  $settings;
	$fhandle = fopen($settings['passfile'], 'w');
	$content = '<?php $u="'.$username.'"; $p="'.md5($password).'"; $e="'.$email.'"; $s="'.$sessionId.'"; ?>';
	fwrite($fhandle, $content);
	fclose($fhandle);
}

//Register a new user and write the data to the file
function register($username, $password, $email) {
	global  $settings, $indexFile;
    $sessionId = generateRandomCode(20);
    setcookie("ZsessionId", $sessionId);
    writePassfile($username, $password, $email, $sessionId);

	if (!is_dir($settings['filesFolder']))
		{
			mkdir($settings['filesFolder'], 0777);
			chmod($settings['filesFolder'],0777);
		}
	if (!is_dir($settings['picturesFolder'])) {
		mkdir($settings['picturesFolder'], 0777);
		chmod($settings['picturesFolder'],0777);
		};
	if (!is_dir($settings['scriptsFolder'])){
		mkdir($settings['scriptsFolder'], 0777);
		chmod($settings['scriptsFolder'],0777);
	}
	
	
	if(checkFileExistance($settings['menufile'])=='0'){
		checkMenuFile();
	} else {
		if (is_file($settings['menufile'])) {
			if (is_readable($settings['menufile'])) {
				$Mcontent = file_get_contents($settings['menufile']);
				if($Mcontent == ''){
					checkMenuFile();
				}
			}
		}
	}
	checkSettingsFile();
	echo '<html><head><script>document.location = "'.$settings['thisPhp'].'?action=load&file='.$indexFile.'";</script></head><body></body></html>';
}

function checkMenuFile(){
	global  $settings, $indexFile;
	
		$theIndFile = 'hasNone';
		if(checkFileExistance('index.html')=='0'){
			if(checkFileExistance('index.htm')=='0'){
			
			} else{
				$theIndFile = 'index.htm';
			}
		} else {
			$theIndFile = 'index.html';
		}
		
		
		
		if ($theIndFile != 'hasNone'){
			$fhandle = fopen($settings['menufile'], 'w');
			
				$contentMenu = 'var ZMenuArray = []; 
var GlobZIndexfile = "'.$theIndFile.'"; 
ZMenuArray["'.$theIndFile.'"] = [];
ZMenuArray["'.$theIndFile.'"]["name"] = "First Page";
ZMenuArray["'.$theIndFile.'"]["parent"] = "";
ZMenuArray["'.$theIndFile.'"]["self"] = "'.$theIndFile.'";
ZMenuArray["'.$theIndFile.'"]["index"] = "0";';

			fwrite($fhandle, $contentMenu);
			fclose($fhandle);
		} else {
			
		}
}

function checkSettingsFile(){
	global  $settings;
	$writeSettingsFile = false;	
	if(checkFileExistance($settings['settingsfile'])=='0'){
		$writeSettingsFile = true;
	} else {
		if (is_file($settings['settingsfile'])) {
			if (is_readable($settings['settingsfile'])) {
				$Mcontent = file_get_contents($settings['settingsfile']);
				if($Mcontent == ''){
					$writeSettingsFile = true;
				}
			}
		}
	}
		
	if ($writeSettingsFile){
		$fhandle = fopen($settings['settingsfile'], 'w');
		$contentMenu = 'ZmaxpicZoomW = "150"; 
ZmaxpicZoomH = "150"; 
ZmaxpicW = "800"; 
ZmaxpicH = "800"; ';

		fwrite($fhandle, $contentMenu);
		fclose($fhandle);
	}
}


//Show login screen
function showLoginScreen() {
	global $settings, $locationOfEditor, $userID, $version;
	$content = getExtParam('login_screen1'); 
	echo $content;
}


//Show registration screen
function showRegistrationScreen() {
	global $settings, $locationOfEditor, $userID,$version;
	$content = getExtParam('login_screen2');
	echo $content;
}


//Checking username and password
function login($username, $password, $remember) {
	global $settings;
	$content = file_get_contents($settings['passfile']);
	if (strpos($content, '$u="'.$username.'";') && strpos($content, '$p="'.md5($password).'";')) {
        $sessionId = generateRandomCode(20);
        $expire = 0;
        if ($remember == 'true') {
            $expire = time()+60*60*24*30;
        }
        setcookie("ZsessionId", $sessionId, $expire);
        writePassfileParam('s', $sessionId);
        writePassfileParam('r', $remember);
		header( 'Location: '.$settings['thisPhp'].'?action=load&file='.getFile());
	} else {
		logout();
	}
}

//Closing session
function logout() {
    $remember = readPassfileParam("r");
    if ($remember == 'true') {
        header( 'Location:'.getFile());
    } else {
        setcookie("ZsessionId", "",  time()-60*60*24*30);
        writePassfileParam('s', '');
        writePassfileParam('r', '');
        showLoginScreen();
    }
}


//Check, if the visitor is authorized to access the CMS
function isAutorized() {
	global $settings;
	if(isset($_COOKIE['ZsessionId'])){ $sessId = $_COOKIE['ZsessionId'];} else { $sessId ='';}
	$rv = false;
	$content = file_get_contents($settings['passfile']);
	if (strpos($content, '$s="";') === false && strlen ($sessId) > 0 && strpos($content, '$s="'.$sessId.'";')) {
		$rv = true;
	}
	return $rv;
}

//Change username and password
function changeUsernamePasword($username, $password) {
	if (isAutorized() &&  strlen ($username) > 0 &&  strlen ($password) > 0 ) {
        writePassfileParam('u', $username);
        writePassfileParam('p', md5($password));
    }
	//global $settings;
	//$content = str_replace('$u="'.$_COOKIE['Zuser'].'"; $p="'.$_COOKIE['Zpass'].'";',
	//						 '$u="'.$username.'"; $p="'.md5($password).'";', $content);
	//
	//$fhandle = fopen($settings['passfile'], 'w');
	//fwrite($fhandle, $content);
	//fclose($fhandle);
	//setcookie("Zuser", $username);
	//setcookie("Zpass", md5($password));
	return $content;
}

//Generate random code with given length
function generateRandomCode($length) {
	$chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
	$result = '';
    for ($i = 0; $i < $length; $i++) {
    $char = $chars[rand(0, strlen($chars)-1)];
        $result .= $char;
    }
    return $result;
}

//Generate and send a new password
function generateNewPassword() {
	global $settings, $securityCode, $locationOfEditor, $userID,$version;
	$content = file_get_contents($settings['passfile']);
	preg_match('/\$e=\"([^\"]*)\"/', $content, $matches);
	$email = $matches[1];
	preg_match('/\$u=\"([^\"]*)\"/', $content, $matches);
	$username = $matches[1];
	$securityCode2 = md5(date("F d Y H:i:s.", filemtime($settings['passfile'])));
	
	if ($securityCode) {
		if ($securityCode == $securityCode2) {
			//for ($i = 0; $i < 8; $i++) {
			//	$char = $chars[rand(0, strlen($chars)-1)];
			//	$newpass .= $char;
			//}
			$newpass .= generateRandomCode(8);
			$fhandle = fopen($settings['passfile'], 'w');
			$content = preg_replace('/\$p=\"([^\"]*)\"/', '$p="'.md5($newpass).'"', $content);
			$r = fwrite($fhandle, $content);
			fclose($fhandle);
			
			$message = str_replace('[username]', $username, $settings['reminderContent']);
			$message = str_replace('[password]', $newpass, $message);
			mail($email, 'Your new Zimplit password', $message);
			
			/* the html displayed when passwd confirmation sent */
			$content = getExtParam('pwd_confirm1');
			if ($r > 0) echo $content;
			else return false;
		} else {
			$content = getExtParam('pwd_confirm2');
			echo $content;
		}
	} else {
		$link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?action=generatenewpassword&securitycode='.$securityCode2.'';
		$message = $settings['confirmationContent'].$link;
		mail($email, 'A new password was requested from Zimplit editor', $message);
		
		/* the html displayed when passwd confirmation sent */
		$content = getExtParam('pwd_confirm3'); 
		echo $content;
	
	}
}

//Send reply mail 

function sendReply(){
	$message = '
User question from Zimplit editor

Name: '.$_POST['Name'].'
E-mail: '.$_POST['Email'].'

Location: '.$_POST['doclocation'].'

Problem:
'.utf8_decode($_POST['Text']).'
	';
	mail('support@zimplit.org', 'User question from Zimplit editor', $message);
	return true;
}

// checck file existance
// returns 1 if file exists and 0 if does not
function checkFileExistance($file){
	if (is_file($file)) {
		if (is_readable($file)) {
			return '1';
		} else {
			return '0';
		}
	} else {
		return '0';
	}
}

function getFile(){
    $file = htmlspecialchars($_GET['file'], ENT_QUOTES, 'UTF-8');
    if ($file == '') {
        $file = htmlspecialchars($_POST['file'], ENT_QUOTES, 'UTF-8');
    }
    if ($file != '' && checkFileExistance($file)=='1'){
        return $file;
    }
    return getIndexFile();
}

function getIndexFile(){
	if(checkFileExistance('index.html')=='0'){
		return 'index.htm';
	} else {
		return 'index.html';
	}
}

// function to resize image via gd library

function createthumb($name,$filename,$new_w,$new_h){
	$system=explode('.',$name);
	if (preg_match('/jpg|jpeg|JPG|JPEG/',$system[1])){
		$src_img=imagecreatefromjpeg($name);
	}
	if (preg_match('/png|PNG/',$system[1])){
		$src_img=imagecreatefrompng($name);
	}
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if ($old_x > $old_y) {
		$thumb_w=$new_w;
		$thumb_h=$old_y*($new_h/$old_x);
	}
	if ($old_x < $old_y) {
		$thumb_w=$old_x*($new_w/$old_y);
		$thumb_h=$new_h;
	}
	if ($old_x == $old_y) {
		$thumb_w=$new_w;
		$thumb_h=$new_h;
	}
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	if (preg_match("/png/",$system[1]))
	{
		imagepng($dst_img,$filename); 
	} else {
		imagejpeg($dst_img,$filename); 
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img); 
}


//Get the HTML content from the file.
//Returns FALSE on falure, html content on success
function getHTML($file) {
	if (is_file($file)) {
		if (is_readable($file)) {
			
			$content = file_get_contents($file);
			if ($content === FALSE) {
				return 'Error: Cannot read from the file '.$file.'.';
			}
			
			return $content;
		} else {
			return 'Error: The file '.$file.' is not readable.';
		}
	} else {
		return 'Error: The file '.$file.' does not exist.';
	}
}

//Get the HTML content from the file with editor .
//Returns FALSE on falure, html content on success
function getHTML1($file) {
	global  $locationOfEditor,$GDsupport, $userID,$settings,$version;
	if (is_file($file)) {
		if (is_readable($file)) {
			
			$content = file_get_contents($file);
			if ($content === FALSE) {
				return 'Cannot read from the file '.$file.'.';
			} else {
				$addscripts = '"; var ZphpName="'.$settings['thisPhp'];
				$LoadingFrameHtmlTop = getExtParam('main_screen1').$GDsupport.$addscripts.getExtParam('main_screen2');
				$LoadingFrameHtmlBottom = getExtParam('main_screen3'); 
				$content = $LoadingFrameHtmlTop . $file . $LoadingFrameHtmlBottom;
			}
			
			
			
			return $content;
		} else {
			return 'The file '.$file.' is not readable.';
		}
	} else {
		return 'The file '.$file.' does not exist.';
	}
}


//Writes the HTML content to the file.
//Returns FALSE on falure, TRUE on success
function saveHTML($file, $html) {
	if (is_file($file)) {
		if (is_writable($file)) {
			if (!$handle = fopen($file, 'w')) {
				return 'Cannot open file '.$file.'.';
			}
			if (fwrite($handle, $html) === FALSE) {
				return 'Cannot write to file '.$file.'.';
			}
			fclose($handle);
		} else {
			return 'The file '.$file.' is not writable.';
		}
	} else {
		return 'The file '.$file.' does not exist.';
	}
}

function checkFileIsWritable($file){
	if (is_writable($file)) {
		return 0;
	} else {
		return 1;
	}
}



//Writes the HTML content to the file.
//Returns FALSE on falure, TRUE on success
function saveHTML1($file, $html) {
	$html1 = preg_replace('/\\\"/', '"', urldecode($html));
	$html1 = preg_replace('/%27/', "'", $html1);
	
	if (is_file($file)) {
		if (is_writable($file)) {
			if (!$handle = fopen($file, 'w')) {
				return 'Cannot open file '.$file.'.';
			}
			if (fwrite($handle, $html1) === FALSE) {
				return 'Cannot write to file '.$file.'.';
			}
			fclose($handle);
		} else {
			return 'The file '.$file.' is not writable.';
		}
	} else {
		return 'The file '.$file.' does not exist.';
	}
}



//Create new html file
function newFile($file) {
	if (file_exists($file)) {
		return 'The file '.$file.' already exists.';
	}
	if (touch($file)) {
		chmod($file,0666); 
		return true;
	} else {
		return 'The file '.$file.' cannot be created.';
	}
}


//Delete the file
function deleteFile($file, $folder='') {
	if (!file_exists($file)) {
		return 'The file '.$file.' does not exist.';
	}
	if(is_dir($file)){
		if (@rmdir($file)) {
			return true;
		} else {
			return 'The directory '.$file.' cannot be deleted.';
		}
	} else {
		if (@unlink($file)) {
			return true;
		} else {
			return 'The file '.$file.' cannot be deleted.';
		}
	}
}


//Upload a file
function uploadFile($folder='') {
	global $_FILES, $max_width, $max_height,$GDsupport;
	
	$file = $_FILES['file']['name'];
	$tmpfile = $_FILES['file']['tmp_name'];
	
	if ($folder) {
		if (!is_dir($folder)) {
			return 'No such directory: '.$folder;
		} else if (!is_writable($folder)) {
			return 'Cannot write to directory: '.$folder;
		}
	}
	
	$error = $_FILES["file"]["error"];
	if ($error == UPLOAD_ERR_INI_SIZE) {
   		return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
   	} else if ($error == UPLOAD_ERR_FORM_SIZE) {
   		return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
   	} else if ($error == UPLOAD_ERR_PARTIAL) {
   		return 'The uploaded file was only partially uploaded.';
   	} else if (!$error == UPLOAD_ERR_OK) {
   		return 'Failed to upload the file.';
   	}
	
	$ext = strchr($file, '.');

	//Check image size
	if (strpos('.jpg.jpeg.png.gif.', $ext.'.') !== false) {
		$info = getimagesize($tmpfile);
	
		if (($info[0] > $max_width) || ($info[1] > $max_height)) {
			return 'Image must be '.$max_width.'px X '.$max_height.'px or smaller. Please resize image and try again.';
		}
	}
	if ($folder) {
		$path = $folder.'/'.$file;
	} else {
		$path = $file;
	}
	if (!move_uploaded_file($tmpfile, $path)) {
		return 'Failed to move the file to the '.$folder.' directory.';
	} else {
		if($GDsupport){ // if gd library present do thumbnail
			if (strpos('.jpg.jpeg.png.JPG.JPEG.PNG.', $ext.'.') !== false) {
				$content = file_get_contents('Zsettings.js');
				preg_match('/ZmaxpicZoomW \= \"([^\"]+)\"/i', $content, $ZWmatch); 
				$ZoomThumbW =  $ZWmatch[1];
				preg_match('/ZmaxpicZoomH \= \"([^\"]+)\"/i', $content, $ZHmatch); 
				$ZoomThumbH =  $ZHmatch[1];
				$thenewname = preg_replace('/'.$ext.'/i', '_thumb'.$ext, $path);
				createthumb($path,$thenewname,$ZoomThumbW,$ZoomThumbH);
			} 
		}
		return true;
	}
}


//Rename a file
function renameFile($oldName, $newName) {
	if (file_exists($newName)) {
		return 'The file '.$newName.' already exists.';
	}
	if (!file_exists($oldName)) {
		return 'The file '.$oldName.' does not exist.';
	}
	if (rename($oldName, $newName)) {
		return true;
	} else {
		return 'Failed to rename a file '.$oldName.'.';
	}
}


//Copy a HTML file with a new title
function copyHtml($file, $newFile, $title) {
	$content = getHTML($file);
	if (strpos($content, 'Error: ') !== 0) {
		$content = preg_replace('/<title>[^<]+<\/title>/i', '<title>'.$title.'</title>', $content);
		$r = newFile($newFile);
		if (strpos($r, 'Error: ') !== 0) {
			return saveHTML($newFile, $content);
		} else return $r;
	} else return $content;
}

//Get a list of files in http directory
function listFiles() {
	if ($handle = opendir('.')) {
	    while (false !== ($file = readdir($handle))) {
	        if ($file != '.' && $file != '..' && is_file($file) && strpos($file, '.htm')) {
	        	$files[] = $file;
	        }
	    }
	    closedir($handle);
		
		$fileAndTitle = array();
		
		foreach($files as $Thefile){
			$content = getHTML($Thefile);
			
			$matches = array();
			$pattern = '/<title>(.*)<\/title>/i';
			preg_match($pattern, $content, $matches);
			$pagetitle = $matches[1];
			$fileAndTitle[] = $Thefile.'|'.$pagetitle;
			
		}
	}
	return implode(';', $fileAndTitle);
}

function listFilesDir($file) {
	if($file == ''){ $thedir = '.';} else { $thedir= $file;}
	if ($handle = opendir($thedir)) {
	    while (false !== ($file = readdir($handle))) {
	        if (is_dir($thedir.'/'.$file)) {
				if($thedir != '.'){
					$files[] = $file.'|dir';
				} else {
					if($file != '.' && $file != '..'){
						$files[] = $file.'|dir';
					}
				}
	        } else {
				$files[] = $file.'|file';
			}
	    }
	    closedir($handle);
	}
	return implode(';', $files);
}

//Download zip
function downloadZip($src) {
	global $settings;
	
	$file = basename($src);
	if(function_exists("curl_init")) {
		$ch = curl_init();
		$fp = fopen($file, 'w');
		curl_setopt($ch, CURLOPT_URL, $settings['templates_remote_path'].'/'.$src);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);		
		curl_setopt($ch, CURLOPT_FILE, $fp);
		$response = curl_exec($ch);
		curl_close($ch);
	} else {
		$data = file_get_contents($settings['templates_remote_path'].'/'.$src);
		file_put_contents($file, $data);
	}
}

function unzip($file, $path="") {
	global $settings;
	$filepath = getcwd().'/'.$file;
	if (file_exists($filepath)) {
		
		if (file_exists($settings['scriptsFolder'].'/pclzip.lib.php')) {
			require_once($settings['scriptsFolder'].'/pclzip.lib.php');
			$archive = new PclZip($file);
			if ($archive->extract(PCLZIP_OPT_REPLACE_NEWER) == 0) {
		    	return "Error : ".$archive->errorInfo(true);
			} else {
				  return true;
			}
		} else {
			$phpversion = phpversion();
			$modules = get_loaded_extensions();
			if ($phpversion[0] == 4) {
				if (function_exists("zip_open")) {
					$zip = zip_open($filepath);
					if ($zip) {
						while ($zip_entry = zip_read($zip)) {
							if (zip_entry_filesize($zip_entry) > 0) {
								$complete_path = $path.str_replace('/','\\',dirname(zip_entry_name($zip_entry)));
								$complete_name = $path.str_replace ('/','\\',zip_entry_name($zip_entry));
								if(!file_exists($complete_path)) { 
									$tmp = '';
									foreach(explode('\\',$complete_path) as $k) {
										$tmp .= $k.'\\';
										if(!file_exists($tmp)) {
											mkdir($tmp, 0777);
										}
									}
								}
								if (zip_entry_open($zip, $zip_entry, "r")) {
									$fd = fopen($complete_name, 'w');
									fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
									fclose($fd);
									zip_entry_close($zip_entry);
								}
							}
						}
						zip_close($zip);
						return true;
					} else {
						return 'Error: The zip file '.$file.' is damaged.';
					}
				}			
				
			} else {
				if (in_array("zip", $modules)) {
					$zip = new ZipArchive();
					if ($zip->open($file)===true)
					{
					    $zip->extractTo(".");
					    $zip->close();
					    return true;
					}
					return 'Error: The zip file '.$file.' is damaged.';
				} else {
					return 'Error: Zip is not supported.';
				}
			}
		}
		
	} else {
		return 'Error: The file '.$file.' does not exist.';
	}
}

function downloadTemplate($file) {
	downloadZip($file);
	return unzip(basename($file),'');
}

function checkIfHasIndexFile(){
	if(checkFileExistance('index.html')=='0'){
		if(checkFileExistance('index.htm')=='0'){
			return false;
		} else { 
			return true;
		}
	} else {
		return true;
	}
}


function loadExternalTemplHtml($fileaddr){
	global  $locationOfEditor, $userID, $settings, $version;
		$LoadingFrameHtmlTop = getExtParam('templpage1'); 
		$LoadingFrameHtmlBottom = getExtParam('templpage2');
		$content = $LoadingFrameHtmlTop . file_get_contents($fileaddr) . $LoadingFrameHtmlBottom;
	echo $content;
}

function loadTemplPage($fileaddr){
	global $settings, $userID, $version;
	loadExternalTemplHtml(getExtParam('templpagepath')); 
}


/*unzip("template1.zip");*/

function sendAnEmail(){
	if(isset($_POST['ZtheEmail'])&&isset($_POST['ZpageLocation'])&&isset($_POST['ZdomainName'])&&isset($_POST['ZuserEmail'])){
		$emailaddr = $_POST['ZtheEmail'];
		$userEmail = $_POST['ZuserEmail'];
		$pageLoc = $_POST['ZpageLocation'];
		$domainName = $_POST['ZdomainName'];
		
		$theLetter = "Feedback from Your site: ".$pageLoc."\n";
		foreach ($_POST as $key => $value){
			if($key != 'ZtheEmail'){
				$exploded = explode("_",$key);
				if($exploded[0] == 'name'){
					$theInput = $_POST["value_".$exploded[1]];
					$theLetter .= $value.': '.$theInput."\n";
					
				}
			}
		}
		
		function sendAMail($toemail,$fromemail,$subject,$content){
			$mail_headers  = "X-Mailer: Zimplit CMS www-engine v1.0 www.krabi.ee\r\n";
			$mail_headers .= "MIME-Version: 1.0\r\n";
			$mail_headers .= "Content-Transfer-Encoding: 8bit\r\n";
			$mail_headers .= "Content-Type: text/plain; charset=utf-8\r\n";
			$mail_headers .= "From: <".$fromemail.">\r\n";
			mail($toemail,$subject,$content,$mail_headers);
		}
		sendAMail($emailaddr,$userEmail, 'Feedback from '.$domainName , $theLetter);
	}
	echo '<script>history.go(-1);</script>';
	//echo $theLetter."\n\n".$emailaddr;
}





if (file_exists($settings['passfile'])) {
	if (isAutorized()) {
		
		if(checkFileExistance($settings['menufile'])=='0'){
			checkMenuFile();
		} else {
			if (is_file($settings['menufile'])) {
				if (is_readable($settings['menufile'])) {
					//$Mcontent = file_get_contents($settings['menufile']);
					
					if(filesize($settings['menufile'])== 0){
						checkMenuFile();
					}
				}
			}
		}
		checkSettingsFile();
		
		if ($action == 'logout') {
			logout();
			//showLoginScreen();
		} else {
			if(checkIfHasIndexFile()){
				$processRequest = true;
			} else {
				if ($action == 'gettemplate') {
					$theansunpack = downloadTemplate($file);
					if($theansunpack  == true){
						header( 'Location: '.$settings['thisPhp'] ) ;
						echo '<html><head><script>document.location = "'.$settings['thisPhp'].'";</script></head><body></body></html>';
					} else { 
						echo $theansunpack ;
						//echo 'Some bad, bad error occured! Unpacking failed.';
					}
				} else if ($action == 'loadTemplPage'){
					loadTemplPage($file);
				} else if ($action== 'downloadHtmlTemplate'){
					@downloadExternalPage($file,$page);	
					header( 'Location: '.$settings['thisPhp'] ) ;
					echo '<html><head><script>document.location = "'.$settings['thisPhp'].'";</script></head><body></body></html>';
				} else {
					loadExternalTemplHtml(getExtParam('templpageindex')); 
				}
			}
		}		
	} else {
		if (($action == 'login') && isset($username) && isset($password)) {
			login($username, $password, $remember);
		} else if($action == 'generatenewpassword') {
			generateNewPassword();
		} else if ($action == 'submitForm'){
			sendAnEmail();
		} else {
			showLoginScreen();
		}
	}
} else {
	if (($action == 'register') && $username && $password &&
			$password_again && $email && ($password == $password_again)) {
		register($username, $password, $email);
		$processRequest = true;
	} else {
		showRegistrationScreen();
	}
}

/* html downloader */

function writeToFile($file,$source){
	if (!$handle = fopen($file, 'w')) {
			return 'Cannot open file '.$file.'.';
	}
	if (fwrite($handle, $source) === FALSE) {
		return 'Cannot write to file '.$file.'.';
	}
	fclose($handle);
}

function changeLinksAddrs($html,$sources){
	global $settings;
	$newhtml = $html;
	foreach($sources as $src){
		if(preg_match("/\?/",$src['fullPath'])){
			$fname= explode("?",$src['fullPath']);
			$fname= $fname[0];
		} else {
			$fname = $src['fullPath'];
		}
		$newhtml = str_replace($fname, $settings['filesFolder'].'/'.$src['file'], $newhtml);
	}
	return $newhtml;

}

/* get all link values. fullpath = the path written in original file; file = file name (empty if link absolute as this file should not be downloaded) */
function getFileAddrs($html){
	$sources = array();

	/* src="" values */	
	preg_match_all("/src\=(\"|\')?([^(\"|\'| |\>)]+)/",$html, $srcs,PREG_PATTERN_ORDER);
 	foreach($srcs[2] as $source){
		$fileaddr = NULL;
		if(preg_match("/\//",$source,$fileaddrArr)){
			preg_match("/\/([^\/]+$)/",$source,$fileaddrArr);
			if($fileaddrArr){
				if(preg_match("/\?/",$fileaddrArr[1])){
					$fileaddr = explode("?",$fileaddrArr[1]);
					$fileaddr= $fileaddr[0];
				} else {
					$fileaddr = $fileaddrArr[1];
				}
			}
		} else {
			$fileaddr = $source;
		}
		

		if($fileaddr != NULL){		
			$srcarr = array(
				"fullPath"=> $source,
				"file" => $fileaddr,
			);
			array_push($sources,$srcarr);
		}
	}

	/* <link href="" values */
	preg_match_all("/\<link.*href\=(\"|\')([^(\"|\')]+)/",$html, $hrefs,PREG_PATTERN_ORDER);
	foreach($hrefs[2] as $href){
		
		$fileaddr = NULL;
		if(preg_match("/\//",$href,$fileaddrArr)){
			preg_match("/\/([^\/]+$)/",$href,$fileaddrArr);
			if($fileaddrArr){
				if(preg_match("/\?/",$fileaddrArr[1])){
					$fileaddr = explode("?",$fileaddrArr[1]);
					$fileaddr= $fileaddr[0];
				} else {
					$fileaddr = $fileaddrArr[1];
				}
			}
		} else {
			$fileaddr = $href;
		}
		
		if($fileaddr != NULL){		
			$srcarr = array(
				"fullPath"=> $href,
				'file' => $fileaddr,
			);
			array_push($sources,$srcarr);
		}
	}
	return $sources;
	
}



function cssParseReturn($matches){
	global $settings,$currentCssPath,$currentAbsPath;
	echo $matches[2]."\n".$currentCssPath."\n".$currentAbsPath."\n";
	$fname = end(explode("/",$matches[2]));
	if($matches[2][0] == '/'){  
		$filecont = file_get_contents($currentAbsPath.$matches[2]);
	} else {
		$filecont = file_get_contents($currentCssPath.$matches[2]);
	}
	newFile($settings['filesFolder'].'/'.$fname);
	writeToFile($settings['filesFolder'].'/'.$fname, $filecont);
	return 'url("'.$fname.'")';
}

function parseCss($content){
	return preg_replace_callback("/url\((\'|\")?([^(\'|\"\))]+)(\'|\")?\)/","cssParseReturn",$content);
}

function downloadFiles($sources,$pagelocation){
	global $settings,$currentCssPath,$currentAbsPath;
	foreach($sources as $src){
		if($src['file'] != ""){
			$ext = end(explode('.',$src['file']));
			
			if (strpos('.htm.HTM.html.HTML.php.PHP.swf.SWF.js.JS.', $ext.'.') === false) {
				
				if(!preg_match("/http/",$src['fullPath'])){
					$tmpfilecontents = file_get_contents($pagelocation.$src['fullPath']);
				} else {
					$tmpfilecontents = file_get_contents($src['fullPath']);
				}
		
				newFile($settings['filesFolder'].'/'.$src['file']);
			
				if($ext == 'css'){
				
					if(preg_match("/http/",$src['fullPath'])){
						$currentCssPath = '';
					} else if(!preg_match("/\//",$src['fullPath'])){
						$currentCssPath = $currentAbsPath;
					} else {
							$currentCssPath = preg_replace("/(.*\/)[^\/]*$/",$currentAbsPath."$1",$src['fullPath']);
					}
					$tmpfilecontents= parseCss($tmpfilecontents);
				}
				writeToFile($settings['filesFolder'].'/'.$src['file'], $tmpfilecontents);
			 }
		}	
	}
	
}

function removeJsActions($code){

	$code = preg_replace("/onmouseout=\"[^\"]*\"/si",'',$code);
	$code = preg_replace("/onmouseout='[^']*'/si",'',$code);
	$code = preg_replace("/onmouseover=\"[^\"]*\"/si",'',$code);
	$code = preg_replace("/onmouseover='[^']*'/si",'',$code);
	$code = preg_replace("/onclick=\"[^\"]*\"/si",'',$code);
	$code = preg_replace("/onclick='[^']*'/si",'',$code);
	$code = preg_replace("/onload=\"[^\"]*\"/si",'',$code);
	$code = preg_replace("/onload='[^']*'/si",'',$code);
	$code = preg_replace("/<script[^>]*?>.*?<\/script>/si",'',$code);
	
	return $code;
}


function downloadExternalPage($link,$pageA){
	global $settings,$currentAbsPath;
	if(preg_match("/http:\/\/.*\//",$link)){
	preg_match("/(http:\/\/.*\/)[^\/]*$/",$link,$pagelocationtmp);
		$pagelocation = $pagelocationtmp[1];
	} else {
		$pagelocation = $link;
	}
	if($pagelocation[strlen($pagelocation)-1]!= '/'){
		$pagelocation=$pagelocation.'/';
	}
	$currentAbsPath =$pagelocation;
	$html = file_get_contents($link);
	$html = removeJsActions($html);
	
	
	
	$sources = getFileAddrs($html);
	downloadFiles($sources,$pagelocation);
	$html = changeLinksAddrs($html,$sources);
	if($pageA != null){
		newFile($pageA);
		writeToFile($pageA, $html);
	} else {
		newFile('index.html');
		writeToFile('index.html', $html);
	}
	return true;
}	

if ($processRequest) {
	if ($action == 'load') {
		echo getHTML1($file);
	} else if ($action == 'load1') {
		echo getHTML($file);	
	} else if ($action == '') {
		echo getHTML1($indexFile);
	} else if ($action == 'save') {
		echo saveHTML($file, $html);
	} else if ($action == 'saveE') {
		echo saveHTML1($file, $html);
	} else if ($action == 'new') {
		echo newFile($file);
	} else if ($action == 'delete') {
		echo deleteFile($file);
	} else if ($action == 'upload') {
		echo uploadFile($folder);
	} else if ($action == 'rename') {
		echo renameFile($oldName, $newName);
	} else if ($action == 'changeuserpass') {
		echo changeUsernamePasword($username, $password);
	} else if ($action == 'generatenewpassword') {
		echo generateNewPassword();
	} else if ($action == 'listfiles') {
		echo listFiles();
	} else if ($action == 'copyhtml') {
		echo copyHTML($file, $newName, $title);
	} else if ($action == 'checkFile') {
		echo checkFileExistance($file);
	} else if ($action == 'sendreply') {
		echo sendReply();
	} else if ($action == 'iswriteble') {
		echo checkFileIsWritable($file);
	} else if ($action == 'gettemplate') {
		echo downloadTemplate($file);
	} else if ($action== 'loadExternalHtml'){
		loadExternalTemplHtml($file);
	} else if ($action== 'loadTemplPage'){
		loadTemplPage($file);
	} else if ($action== 'listAllFiles'){
		echo listFilesDir($file);
	} else if ($action == 'submitForm'){
		sendAnEmail();
	} else if ($action== 'downloadHtmlTemplate'){
		echo downloadExternalPage($file,$page);
	}
}
/*if (file_exists('installer.php')) unlink('installer.php');*/
?>