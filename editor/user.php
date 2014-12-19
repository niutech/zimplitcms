<?php 
//require('zimplit-config.php');
include('languages/lang_'.$settings['lang'].'.php');
$languagesHtml = ' ';
foreach($languages as $key => $valu){
	if ($settings['lang'] == $key){
		$languagesHtml = $languagesHtml.'<option value="'.$key.'" selected="selected">'.$valu.'</option>';
	} else {
		$languagesHtml = $languagesHtml.'<option value="'.$key.'">'.$valu.'</option>';
	}
}

function bigLogo(){
	global $locationOfEditor,$editorDir;
	$logolink ='';
	if(file_exists($editorDir.'logo/logo_1.gif')){
		$logolink = '<a href="http://www.zimplit.com"><img src="'.$locationOfEditor.'logo/logo_1.gif" id="theZlogo" alt="" /></a>';
	}
	return $logolink;
}

function getExtParam($contentType){
	global $mustbeUid,$settings,$indexFile,$version,$languagesHtml,$locationOfEditor,$LangTexts,$templatePageAddr,$templateFilesDir;
	if($contentType == 'login_screen1'){
		$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et">
			<head>
				<title></title>
				<meta name="author" content="" />
				<meta name="keywords" content="" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					
				<link rel="stylesheet" href="'.$locationOfEditor.'Zstyle_css.php" type="text/css" media="all" />
				<script src="'.$locationOfEditor.'jquery.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'jquery-ui.js" type="text/javascript"></script>

				<script type="text/javascript">
					function InitRegister(){
						$("#ZMainOverlay").height($(window).height());
						$("#ZloginScreen").draggable();
						$("#zimplitPage").height($(window).height());
						
					}
				</script>
				
			</head>
			<body onload="InitRegister();" style="overflow:hidden;">
				<div id="ZMainOverlay"></div>
				<div style="width: 100%; top:0px; left:0px; display:block; position: absolute; z-index: 20;  text-align:center;margin:0; padding:100px 0 0 0;">
					<div id="ZloginScreen" class="ZpopupScreen" >
						<div class="inner">
							<div class="header">
								<a href="'.$indexFile.'"><img src="'.$locationOfEditor.'images/close.gif" class="closeBtn" alt="" /></a>
								'.$LangTexts["login"].'
							</div>
							<form method="post" action="'.$settings['thisPhp'].'?action=login">
							<div class="loginarea">
								'.bigLogo().'
								<br/>
								'.$LangTexts["language"].' <br/><select name="lang" class="txtbox" onchange="document.location=\''.$settings['thisPhp'].'?lang=\'+this.value;">
									'.$languagesHtml.'
								</select>
								<span style="font-size:10px;line-height: 12px;">'.$LangTexts["username"].'</span>
								<input type="text" class="txtbox" name="username" value="'.$LangTexts["username"].'" onfocus="if(this.value==\''.$LangTexts["username"].'\'){this.value=\'\';}"/>
								<span style="font-size:10px;line-height: 12px;">'.$LangTexts["password"].'</span>
								<input type="password" class="txtbox" name="password" value="'.$LangTexts["password"].'" onfocus="if(this.value==\''.$LangTexts["password"].'\'){this.value=\'\';}" />
								<br/><br/>
								<input type="submit" name="submit" class="submitBtn" value="'.$LangTexts["start"].'" /> 
								<input type="checkbox" name="remember" value="true" /> '.$LangTexts["rememberme"].'<br/><br/>
								<a href="'.$settings['thisPhp'].'?action=generatenewpassword" target="_top" style="color: #1e9d11;">'.$LangTexts["forgotpass"].'</a>
								<br/><br/>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<!-- the frame of page to be loaded into -->
				<iframe id="zimplitPage" width="100%" frameborder="0"  src="'.$indexFile.'"></iframe>
			</body>
			</html>	';
		return $content;
	} else if ($contentType == 'login_screen2'){
		$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et">
			<head>
				<title></title>
				<meta name="author" content="" />
				<meta name="keywords" content="" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					
				<link rel="stylesheet" href="'.$locationOfEditor.'Zstyle_css.php" type="text/css" media="all" />
				<script src="'.$locationOfEditor.'jquery.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'jquery-ui.js" type="text/javascript"></script>

				<script type="text/javascript">
					function InitRegister(){
						$("#ZMainOverlay").height($(window).height());
						$("#ZloginScreen").draggable();
						$("#zimplitPage").height($(window).height());
						
					}
					
					function CheckZForm(){
						var theanswer = true;
						var alerts = "'.$LangTexts["register_fields_not_filled"].' \n";
						if (($("#Zusername").val() == "")||($("#Zusername").val() == "'.$LangTexts["username"].'")){
							alerts += "'.$LangTexts["register_nousername"].' \n";
							theanswer = false;
						}
						if (($("#Zemail").val() == "")||($("#Zemail").val() == "'.$LangTexts["register_email"].'")){
							alerts += "'.$LangTexts["register_noemail"].' \n";
							theanswer = false;
						}
						if ($("#Zpassword").val() == ""){
							alerts += "'.$LangTexts["register_nopassword"].' \n";
							theanswer = false;
						} else {
							if (document.getElementById("Zpassword").value != document.getElementById("Zpasswordagain").value){
								alerts += "'.$LangTexts["register_passwordnomatch"].' \n";
								theanswer = false;
							}
						}
						if (!theanswer){ alert(alerts);}
						return theanswer;
					}
				</script>
				
			</head>
			<body onload="InitRegister();">
				<div id="ZMainOverlay"></div>
				<div style="width: 100%; top:0px; left:0px; display:block; position: absolute; z-index: 20;  text-align:center;margin:0; padding:100px 0 0 0;">
					<div id="ZloginScreen" class="ZpopupScreen" style="height:400px;">
						<div class="inner" style="height:396px;">
							<div class="header">
								<a href="'.$indexFile.'"><img src="'.$locationOfEditor.'images/close.gif" class="closeBtn " alt="" /></a>
								'.$LangTexts["create_account"].'
							</div>
							<form method="post" action="'.$settings['thisPhp'].'?action=register" onsubmit="return CheckZForm();">
							<div class="loginarea">
								'.bigLogo().'
								<br/>
								'.$LangTexts["language"].' <br/><select name="lang" class="txtbox" onchange="document.location=\''.$settings['thisPhp'].'?lang=\'+this.value;">
									'.$languagesHtml.'
								</select>
								<span style="font-size:10px;line-height: 12px;">'.$LangTexts["username"].'</span>
								<input type="text" class="txtbox" id="Zusername" name="username" onclick="this.value=\'\';" value="'.$LangTexts["username"].'"/>
								<span style="font-size:10px;line-height: 12px;">'.$LangTexts["password"].'</span>
								<input type="password" class="txtbox" id="Zpassword" name="password" onclick="this.value=\'\';" value="" />
								<span style="font-size:10px;line-height: 12px;">'.$LangTexts["register_retypepassword"].'</span>
								<input type="password" class="txtbox" id="Zpasswordagain" name="password_again" onclick="this.value=\'\';" value="" />
								<span style="font-size:10px;line-height: 12px;">'.$LangTexts["register_email"].'</span>
								<input type="text" class="txtbox" id="Zemail" name="email" onclick="this.value=\'\';" value="'.$LangTexts["register_email"].'"/>
								
								<br/><br/>
								
								<input type="submit" name="submit" class="submitBtn" value="'.$LangTexts["start"].'" /> <a href="#">'.$LangTexts["register_why"].'</a>
								
							</div>
							</form>
						</div>
					</div>
				</div>
				<!-- the frame of page to be loaded into -->
				<iframe id="zimplitPage" width="100%" frameborder="0" height="700px" src="'.$indexFile.'"></iframe>
			</body>
			</html>';
		return $content;
	} else if( $contentType == 'pwd_confirm1'){
		$content = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et">
			<head>
				<title></title>
				<meta name="author" content="" />
				<meta name="keywords" content="" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					
				<link rel="stylesheet" href="'.$locationOfEditor.'Zstyle_css.php" type="text/css" media="all" />
				<script src="'.$locationOfEditor.'jquery.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'jquery-ui.js" type="text/javascript"></script>

				<script type="text/javascript">
					function InitRegister(){
						$("#ZMainOverlay").height($(window).height());
						$("#ZloginScreen").draggable();
						$("#zimplitPage").height($(window).height());
						
					}
				</script>
				
			</head>
			<body onload="InitRegister();" style="overflow:hidden;">
				<div id="ZMainOverlay"></div>
				<div style="width: 100%; top:0px; left:0px; display:block; position: absolute; z-index: 20;  text-align:center;margin:0; padding:100px 0 0 0;">
					<div id="ZloginScreen" class="ZpopupScreen"  >
						<div class="inner">
							<div class="header">
								<a href="'.$indexFile.'"><img src="'.$locationOfEditor.'images/close.gif" class="closeBtn" alt="" /></a>
								'.$LangTexts["changepass_title"].'
							</div>
							<form method="post" action="'.$settings['thisPhp'].'?action=login">
							<div class="loginarea" style="font-size: 11px;">
								'.bigLogo().'
								<br/>
								'.$LangTexts["changepass_directions"].'<br/><br/><br/>
								<a class="submitBtn" href="'.$settings['thisPhp'].'" style="display:block;text-align:center; line-height:30px;text-decoration: none; color: #333333;">'.$LangTexts["ok"].'</a>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<!-- the frame of page to be loaded into -->
				<iframe id="zimplitPage" width="100%" frameborder="0"  src="'.$indexFile.'"></iframe>
			</body>
			</html>	
		';
		return $content;
	} else if( $contentType == 'pwd_confirm2'){
		$content = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et">
			<head>
				<title></title>
				<meta name="author" content="" />
				<meta name="keywords" content="" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					
				<link rel="stylesheet" href="'.$locationOfEditor.'Zstyle_css.php" type="text/css" media="all" />
				<script src="'.$locationOfEditor.'jquery.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'jquery-ui.js" type="text/javascript"></script>

				<script type="text/javascript">
					function InitRegister(){
						$("#ZMainOverlay").height($(window).height());
						$("#ZloginScreen").draggable();
						$("#zimplitPage").height($(window).height());
						
					}
				</script>
				
			</head>
			<body onload="InitRegister();" style="overflow:hidden;">
				<div id="ZMainOverlay"></div>
				<div style="width: 100%; top:0px; left:0px; display:block; position: absolute; z-index: 20;  text-align:center;margin:0; padding:100px 0 0 0;">
					<div id="ZloginScreen" class="ZpopupScreen"  >
						<div class="inner">
							<div class="header">
								<a href="'.$indexFile.'"><img src="'.$locationOfEditor.'images/close.gif" class="closeBtn" alt="" /></a>
								'.$LangTexts["changepass_title"].'
							</div>
							<form method="post" action="'.$settings['thisPhp'].'?action=login">
							<div class="loginarea" style="font-size: 11px;">
								'.bigLogo().'
								<br/>
								'.$LangTexts["changepass_fail"].'<br/><br/><br/>
								<a class="submitBtn" href="'.$settings['thisPhp'].'" style="display:block;text-align:center; line-height:30px;text-decoration: none; color: #333333;">'.$LangTexts["ok"].'</a>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<!-- the frame of page to be loaded into -->
				<iframe id="zimplitPage" width="100%" frameborder="0"  src="'.$indexFile.'"></iframe>
			</body>
			</html>	
		';
		return $content;
	} else if( $contentType == 'pwd_confirm3'){
		$content = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et">
			<head>
				<title></title>
				<meta name="author" content="" />
				<meta name="keywords" content="" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					
				<link rel="stylesheet" href="'.$locationOfEditor.'Zstyle_css.php" type="text/css" media="all" />
				<script src="'.$locationOfEditor.'jquery.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'jquery-ui.js" type="text/javascript"></script>

				<script type="text/javascript">
					function InitRegister(){
						$("#ZMainOverlay").height($(window).height());
						$("#ZloginScreen").draggable();
						$("#zimplitPage").height($(window).height());
						
					}
				</script>
				
			</head>
			<body onload="InitRegister();" style="overflow:hidden;">
				<div id="ZMainOverlay"></div>
				<div style="width: 100%; top:0px; left:0px; display:block; position: absolute; z-index: 20;  text-align:center;margin:0; padding:100px 0 0 0;">
					<div id="ZloginScreen" class="ZpopupScreen"  >
						<div class="inner">
							<div class="header">
								<a href="'.$indexFile.'"><img src="'.$locationOfEditor.'images/close.gif" class="closeBtn" alt="" /></a>
								'.$LangTexts["changepass_title"].'
							</div>
							<form method="post" action="'.$settings['thisPhp'].'?action=login">
							<div class="loginarea" style="font-size: 11px;">
								'.bigLogo().'
								<br/>
								'.$LangTexts["changepass_directions2"].'<br/><br/><br/>
								<a class="submitBtn" href="'.$settings['thisPhp'].'" style="display:block;text-align:center; line-height:30px;text-decoration: none; color: #333333;">'.$LangTexts["ok"].'</a>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<!-- the frame of page to be loaded into -->
				<iframe id="zimplitPage" width="100%" frameborder="0"  src="'.$indexFile.'"></iframe>
			</body>
			</html>	
		';
		return $content;
	} else if( $contentType == 'main_screen1'){
		$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et">
					<head>
						<title></title>
						<meta name="author" content="" />
						<meta name="keywords" content="" />
						<meta http-equiv="Pragma" content="no-cache">
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						
						<link rel="stylesheet" href="'.$locationOfEditor.'Zstyle_css.php" type="text/css" media="all" />
						<script src="'.$locationOfEditor.'jquery.js" type="text/javascript"></script>
						<script src="'.$locationOfEditor.'jquery-ui.js" type="text/javascript"></script>
						<script src="'.$locationOfEditor.'jquery.form.js" type="text/javascript"></script>
						<script type="text/javascript">
							GlobZIndexfile = "'.$indexFile.'";
							GDsupport = "';
		return $content;
	} else if( $contentType == 'main_screen2'){
		$content ='";
							ZimplitEditorLocation = "'.$locationOfEditor.'";
						</script>
						<script src="'.$locationOfEditor.'zimplit_js.php?userID='.$mustbeUid.'&indexfile='.$indexFile.'&scriptname='.$settings['thisPhp'].'&ver='.$version.'&lang='.$settings['lang'].'&temploc='. $templatePageAddr.'" type="text/javascript"></script>
						<script src="Zmenu.js?t='.time().'" type="text/javascript"></script>
						
					<style>
						body,html { margin:0; padding:0; }
						#zimplitMenu {background: #AAAAAA; } 
					</style>
						
					</head>
					
					
					
					
					<body onload="ready();" id="ZimplitRootBody">
						<div id="ZFramesCont">
							<div id="ZPageiframeContainer">
								<iframe id="zimplitPage" name="zimplitPage" onload="ZDoTheReload();"  frameborder="0" height="700px" src="';
		return $content;
	} else if( $contentType == 'main_screen3'){
		$content = '?t='.time().'"></iframe>
							</div>
							
							<div id="ZPageiframeContainer2"  style="display:none;">
								<a id="ZcloseHelp" href="javascript:void(0);" onclick="Zimplit.GUI.hideHelp();" style="display: none;">Close Help</a>
								<iframe id="ZhelpIframe" name="ZhelpIframeName" frameborder="0" height="700px"></iframe>
							
							</div>
						</div>
					</body>
					</html>';
		return $content;			
	} else if ( $contentType == 'templpage1'){
		$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et">
			<head>
				<title></title>
				<meta name="author" content="" />
				<meta name="keywords" content="" />
				<meta http-equiv="Pragma" content="no-cache">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				
				<link rel="stylesheet" href="'.$locationOfEditor.'Zstyle_css.php" type="text/css" media="all" />
				<script src="'.$locationOfEditor.'jquery.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'jquery-ui.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'jquery.form.js" type="text/javascript"></script>
				<script src="'.$locationOfEditor.'zimplitTemplate_new.js.php?scriptname='.$settings['thisPhp'].'&ver='.$version.'" type="text/javascript"></script>
			<style>
				body,html { margin:0; padding:0; }
				iframe { border:0; margin:0; padding:0; width: 100%; }
				#zimplitMenu {background: #AAAAAA; }
				.LeftBox { display: none; }
				.RightBox {width: auto; float: none;}
				#ZdesignFromUrlForm { text-align: left; width:960px; margin: 15px auto 0 auto; font-size: 14px; }
				#main { display: none; }
				.RightBox > ul {display: none;}
			</style>
				 
			</head>
			<body onload="" id="ZimplitRootBody">
				<form action="'.$settings['thisPhp'].'" method="get" id="ZdesignFromUrlForm">
					<div style="padding: 10px; border: 1px dashed #494949;">
					'.$LangTexts["disclaimer"].'
					</div>
					<br/>
					<input type="hidden" name="page" value="index.html"/>
					<input type="hidden" name="action" value="downloadHtmlTemplate"/>

										 <input type="checkbox" onchange="if(this.checked){$(\'#ZdesignFromUrlFormInp\').get(0).disabled= false;$(\'#ZdesignFromUrlFormSub\').get(0).disabled= false;}else{$(\'#ZdesignFromUrlFormInp\').get(0).disabled= true;$(\'#ZdesignFromUrlFormSub\').get(0).disabled= true;}"/> '.$LangTexts["read_disclaimer"].'

					'.$LangTexts["get_design_from_url"].': <input type="text" name="file" id="ZdesignFromUrlFormInp" disabled="disabled" value="http://" />


										<input type="submit" disabled="disabled"  id="ZdesignFromUrlFormSub" value="'.$LangTexts["ok"].'"/>
					

</br></br>

					

				</form>
			
				<!-- the frame of page to be loaded into -->
				<div id="zimplitTempPage">';
				
			return $content;
		
		
	} else if ( $contentType == 'templpage2'){					 
		$content = '</div>
			<script> $(".RightBox").css("width","auto");</script>
			</body>
			</html>'; 
		return $content;
	} else if ( $contentType == 'templpageindex'){
		return $templatePageAddr;
	} else if ( $contentType == 'templpagepath'){
		return 	$templateFilesDir;
	}
	
}

?>