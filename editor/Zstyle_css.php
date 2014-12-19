<?php 
header("Content-type: text/css"); 
include('zimplit-config.php'); 
?>
body { margin:0; padding:0; text-align:left; font: 10px/12px Tahoma;  }
img { border: none; }
iframe { border:0; margin:0; padding:0; }
form {margin:0; padding:0;}

.ZpopupScreen {	position: absolute; background: #FFFFFF; border:1px solid #FFFFFF; overflow:hidden; z-index: 20; }
#ZloginScreen{	position: static; width: 241px;  margin: 0 auto; padding:0; text-align: left; }
.ZpopupScreen .inner{
	border: 2px solid #494949;
	overflow: hidden;
}

#ZloginScreen.ZpopupScreen .inner{
	/*height: 286px;*/
	
}

.ZpopupScreen .header{
	color: #FFFFFF;
	font-size: 18px;
	line-height: 29px;
	border-top: 1px solid #9ba8f3;
	border-left: 1px solid #9ba8f3;
	border-bottom: 1px solid #6875be;
	border-right: 1px solid #6875be;
	background: #798cff;
	padding: 0 0 0 10px;
}

.closeBtn {
	display: block;
	float: right;
	margin: 4px;
}

.ZpopupScreen .loginarea{
	padding: 17px 22px 0 22px;
}

#ZloginScreen.ZpopupScreen .loginarea .txtbox{
	border: 1px solid #cccccc;
	margin: 0px 0px 5px 0;
	padding:3px;
	width: 185px;
}
#ZloginScreen.ZpopupScreen .loginarea select.txtbox{
 width: 193px;
}
#ZloginScreen.ZpopupScreen .header {
	width: 225px;
}


#ZBugView .txtbox {
	border: 1px solid #cccccc;
	margin: 0px 0px 5px 0;
	padding:3px;
	width: 250px;
}



#ZBugView .txtarea {
	border: 1px solid #cccccc;
	margin: 0px 0px 5px 0;
	padding:3px;
	width: 250px;
	height: 200px;
}

#ZBugView .submitBtn {
	width: 60px;
	height: 30px;
	font-size: 14px;

	background-color: #cfced2;
	border: 1px solid #99999c;
}

#ZloginScreen.ZpopupScreen .loginarea .submitBtn{
	width: 60px;
	height: 30px;
	font-size: 14px;

	background-color: #cfced2;
	border: 1px solid #99999c;
}


.ZpopupScreen .theContentArea{
	padding: 5px;
}

.ZpopupScreen .theContentArea .txtbox {
	border: 1px solid #cccccc;
	margin: 0px 0px 0 0;
	padding:3px;
	width: 130px;
}


.ZpopupScreen .theContentArea .submitBtn, .ZpopupScreen .ZSrcInner .submitBtn{
	padding: 4px;
	font-size: 14px;
	line-height: 16px;
	margin: 0 0 0 5px;
	background-color: #cfced2;
	border: 1px solid #99999c;
	cursor: pointer;
}


.ZpopupScreen .ZtheImgProps img{ border-left: 1px solid #cccccc; padding: 4px 10px;}

#ZaddmenuPop .theContentArea, #ZmenuSubmenu .theContentArea, .ZpopupScreen .ZlistOfLinks{ font-size: 11px; line-height: 14px; }

#ZaddmenuPop .theContentArea a, #ZmenuSubmenu .theContentArea a, .ZpopupScreen .ZlistOfLinks a {display: block;  margin: 1px; padding: 3px; color: #555555; text-decoration: none;}
#ZaddmenuPop .theContentArea a:hover, #ZmenuSubmenu .theContentArea a:hover , .ZpopupScreen .ZlistOfLinks a:hover{ background: #d5e4f0; text-decoration: none;}
.ZpopupScreen .ZlistOfLinks a { overflow: hidden;}
.ZpopupScreen .ZlistOfLinks a img { float:left; display: block; margin:0; padding:0; }

#ZtheSourceH { clear:both; overflow: hidden; height: 23px; padding: 2px;}
#ZtheSourceH  a { color:#333333; font-size: 14px; padding: 5px; border-right: 1px solid #FFFFFF; display:block; float:left;}
#ZtheSourceH  a:hover { background: #d5e3ef;}

#ZMainOverlay {position: absolute; top:0px; left: 0px; background: #000000; filter:alpha(opacity=60); -moz-opacity: 0.60; opacity: 0.60; z-index: 10; width: 100%;}

#theZlogo { display: block; margin: 3px 0; }

#ZCopyPageName{ width: 310px; border: 1px solid #d0d0d0; margin: 0px 0 10px 0;  }
#ZcopyPagePop .theContentArea {padding: 10px; font-size: 12px; line-height: 16px;}
#ZCopyPageSrc, .ZCopyPageInput { width: 315px; border: 1px solid #d0d0d0; margin: 0px 0 10px 0;  }

#ZcopyPagePop .submitBtn{
	width: 60px;
	font-size: 14px;
	line-height: 16px;
	padding: 0;
	background-color: #cfced2;
	border: 1px solid #919194;
}

#ZmenuStuc { margin-left: 8px; line-height: 11px; padding: 2px; margin-bottom:5px;}
#ZmenuStuc ul{margin:0 0 0 0; padding: 0 0 0 0; list-style-type:none;  display:block; }
#ZmenuStuc ul li { padding: 0px 0 0px 10px; border-left: 1px dotted #494949; background:  url('images/menuSLi.gif') no-repeat 0px 5px; clear:both; white-space: nowrap; }
#ZmenuStuc ul li.last { border-left: none; background: url('images/menuSLi_last.gif') no-repeat 0px 0px;}
#ZmenuStuc ul li a{color:#222222; font-size: 10px; text-decoration:none; padding: 0px 4px; }
/*#ZmenuStuc ul li a:hover, #ZmenuStuc ul li a.selected {background: #cbffc6;}*/
#ZMenuStructure button {
	font-size: 14px;
	line-height: 16px;
	padding: 0;
	background-color: #cfced2;
	border: 1px solid #919194;
}

#ZmenuStuc .ZEditPageDrop {
	margin:-10px 0 0 0;
	padding:2px;
	border: 2px solid #494949;
	position: absolute;
	/*margin-left: 41px;*/
	z-index: 100;
	clear:both; overflow: hidden;
	background: #ffffff;
	overflow: hidden;
}
#ZmenuStuc .ZEditPageDrop li {
	margin:0;
	display:block; 
	float:left;
	clear:both;
	width: 100px;
	padding:0px 0 0px 0;
	border: none;
	background: none;
	border-bottom: none
}


#ZmenuStuc .ZEditPageDrop li a{
	display:block;
}

#ZmenuStuc .ZEditPageDrop li a:hover{
	background: #D5E4F0;
}

#ZRenamePage{z-index: 30;}

#ZFFpasteTxt {
	border: 1px solid #cccccc;
	width: 100%;
	height: 300px;
}

#ZSettingsPopup .ZSettingBox {
	border-top: 1px solid #cccccc;
	border-bottom: 1px solid #cccccc;
	padding: 10px 0;
	cursor:pointer;
}

#ZSettingsPopup .ZSettingBox img{
	margin:0;
	padding:0;
	display:block;
}

#ZSettingsPopup .ZSettingBox:hover {
	background: #ebf3fa;
}

#ZimgSettingsPopup .theContentArea input{
	border: 1px solid #cccccc;
	width: 80px;
	
}

.droppable-hover {background-color: #33FF00;}


#ZmenuStuc ul li a {}

#ZmenuStuc ul li .ZdragUnder {
	height: 4px; overflow: hidden; background: none; margin-bottom: 3px;
	clear:both;
}

#ZmenuStuc ul li .ZdragUnderhover {
	height: 10px; overflow: hidden; clear:both; background:#FFFFFF;margin-bottom: 3px; padding: 2px;
}

.ZtemplShowBox{
	width: 237px; float:left; overflow: hidden;
	padding-bottom: 10px;
}

.ZtemplShowBox .ZTplChooserBtn { padding: 2px 15px; text-decoration: none; }
.ZtemplShowBox .ZTplChooserBtn img { vertical-align: -25%; }

.ZtemplShowBox .templPicture{
	background: url('http://zimplit.org/editor_dev/images/templBg.gif') no-repeat; width: 237px; height: 157px; overflow: hidden;
	padding: 4px 0 0 6px;
}

.ZtemplShowBox .templPicture img{ margin:0; padding:0; display:block; }

#zimplitMenu .ZMainMenuContent img{border:0;  display:block; margin: 0 1px 1px 0;  padding:0;overflow:hidden;} 
#zimplitMenu .ZMainMenuContent  a{ display: block; float:left; padding:0; margin:0; overflow:hidden;}  
#ZpageChoose { font-size:10px; margin:1px; padding:0; width: 100%;border: none;}
#zimplitMenu .ZmenuBlock{ border-bottom: 1px solid #8d8d8d; clear:both; overflow: hidden; float:left; width: 100%;}
#zimplitMenu .Zhelp { text-align: center; background: #798cff; padding: 2px 0px; overflow: hidden; width: 100%;border: none; float: left; }
#zimplitMenu .Zhelp a { display: inline; float: none; color: #FFFFFF; text-decoration: none; border: none; clear:both; }

.ZFMIcon { float:left; padding: 10px; text-align: center; white-space: nowrap; font-size:10px; width: 90px;  height: 50px; overflow: hidden;}
.ZFMIcon img { display: inline; }
.ZFMIcon a { text-decoration: none; }
.ZFMIcon a:hover { }

#ZFileManagerPath { height: 15px; line-heigh: 15px; padding: 5px; background: #dddddd; font-weight: bold;}  

#ZFileManagerArea { height: 450px; overflow: auto; }

#ZimplitSideMenu { width: 65px; float:left;  background: #c4ccff; border-right: 1px solid #FFFFFF; font-family: Tahoma;}
#ZimplitSideMenu .sideScroller { display:block; float:right; overflow: hidden; }
#ZimplitSideMenu .sideScroller img{ display:block; margin:0; padding:0; border:0;}
#ZimplitSideMenu .outerBorder {display:block; clear:both; overflow: hidden; border-right: 2px solid #494949; 	}
#ZimplitSideMenu .sideBtn {margin: 1px 0 5px 1px;  width: 45px;  line-height: 12px;  padding-top: 4px; display:block; overflow: hidden;  text-align: center; color:  #494949; text-decoration: none; overflow: hidden; background:  url('images/sidebarBtn_closed.gif') no-repeat;}
#ZimplitSideMenu .sideBtn img { vertical-align: middle; margin-bottom:12px; margin-top: 5px; }
#ZimplitSideMenu .sideBtn.hideClosed { display:none; }
#ZimplitSideMenu.open .sideBtn.hideClosed { display: block; }

#ZimplitSideMenu .inner { padding: 2px 0 0 7px; overflow: hidden;}
#ZimplitSideMenu.open .inner { padding: 2px 0 0 7px;}
#ZimplitSideMenu .header { background: url('images/sidemenuHeader.gif'); height: 44px;    text-align: center; padding: 14px 2px 0 2px; display: none; }
#ZimplitSideMenu .headerPre { background: #c4ccff; color: #494949; text-align: center; padding: 8px 4px 8px 0px; line-height: 8px; font-size: 11px;  }
#ZimplitSideMenu .headerPre a { color: #494949; }
#ZimplitSideMenu .headerPre img { vertical-align: -15%;}
#ZimplitSideMenu .headerPre a:hover {} 
/*#ZimplitSideMenu .sideBtn .txt {display:none;}*/

#ZimplitSideMenu.open .sideBtn .txt {display:inline;}


#ZimplitSideMenu.open { width: 187px; }
#ZimplitSideMenu.open .outerBorder { width: 184px; overflow:hidden; float:left;}
#ZimplitSideMenu.open .sideBtn { float:left; background:  url('images/sidebarBtn_open.gif') no-repeat; width: 82px;  padding-top: 5px; height: 39px; margin-bottom:2px;}
#ZimplitSideMenu.open .sideBtn img { margin:0; }
#ZimplitSideMenu.open .sideBtn.wide {float:left; overflow:hidden; width: 155px; height: 34px; margin-left: 0px; padding: 10px 0 0 10px; margin-bottom: 1px; line-height: 12px; background: url('images/sidebarBtn_wide.gif') no-repeat; border: 1px solid #b5cbf1; text-align:left; font-size: 14px;}
#ZimplitSideMenu.open .sideBtn.wide img { vertical-align: middle; margin:0; }
#ZimplitSideMenu.open .sideBtn.wide br {display: none;}
#ZimplitSideMenu.open  .header { text-align:left; padding-left: 10px; display: block; }
#ZimplitSideMenu.open  .headerPre  { display: block; position: absolute; background: transparent; margin-left: 130px; margin-top: 8px; }
#ZimplitSideMenu.open .bigContent { width: 148px; margin:0 0 0 3px; padding:5px 0 5px 5px; float:left;}
#ZimplitSideMenu.open .bigContent img{vertical-align: middle;}

#ZSettingsMenuSide{display: none; float:left; margin-left: 8px; padding:4px 2px; } 
#ZimplitSideMenu.open #ZSettingsMenuSide {display: block;}
#ZimplitSideMenu.open #ZSettingsMenuSide a { display: block; clear:both; text-decoration:none; color: #494949;}


#ZPageiframeContainer, #ZPageiframeContainer2 { display: block; overflow: hidden;}
*html #ZPageiframeContainer {float:right;}
*html #ZPageiframeContainer2 {float:right; }

#zimplitPage, #ZhelpIframe { border:0; margin:0; padding:0; display:block; width: 100%; clear:both;}
*html #ZhelpIframe { width:99%; }

.ZtreeList { margin-left: 8px; line-height: 11px; padding: 2px; margin-bottom:5px;}
.ZtreeList ul{margin:2px 0 0 0; padding: 0 0 0 0; list-style-type:none; overflow: hidden; display:block; font-size: 10px; }
.ZtreeList ul li { padding: 2px 0 2px 10px; border-left: 1px dotted #494949; background:  url('images/menuSLi.gif') no-repeat 0px 5px; clear:both;overflow:hidden; white-space: nowrap; }
.ZtreeList ul li.last { border-left: none; background: url('images/menuSLi_last.gif') no-repeat 0px 0px;}
.ZtreeList ul li a{color:#222222; font-size: 10px; text-decoration:none; padding: 0px 5px; }
.ZtreeList ul li a:hover{ font-size: 10px; text-decoration:underline;}

#ZcloseHelp { position: fixed; height: 15px; overflow: hidden; z-index: 100; top:0; right:0px;  z-index: 100; width: 200px; font-size: 12px; color:#494949;  background: #e6edf7; padding: 5px; display: block; border: 5px solid #A2C0F2; border-top:0; margin-right: 20px; text-decoration:none; }

.ZTxtColorBox { height: 10px; width: 20px; border: 1px solid #494949; display:block; float:left; margin-right: 4px;}