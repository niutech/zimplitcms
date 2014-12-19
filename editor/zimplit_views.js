/* html sources of editor views */
Zimplit.Sources = {
	editor: '<div  id="zimplitMenu" class="ZpopupScreen"  style="position: absolute; width: 71px; overflow:hidden; margin:0; padding:0;z-index:10;top:10px; left: 180px;">'+
				'<div class="inner" style="overflow: hidden; padding:0; float:left; ">' +
					'<div  class="header" style="height: 14px;padding: 0px; overflow: hidden;width: 100%; ">'+
						'&nbsp;'+
						
					'</div>'+
					'<div style="padding-left: 1px; overflow:hidden; clear:both; float:left;" class="ZMainMenuContent ">'+
						/*'<div class="ZmenuBlock">'+
							'<a href="javascript:void(0);" onclick="ZSaveContent();"><img onmouseover="ZMBtnover(this,\'imgSave\');" onmouseout="ZMBtnout(this,\'imgSave\');" src="'+ZLinksToImages.imgSave+'" alt="'+langTexts["menu_save_tooltip"]+'" title="'+langTexts["menu_save_tooltip"]+'" /></a>'+
							'<a href="javascript:void(0);" onclick="ZNewPagePop();"><img onmouseover="ZMBtnover(this,\'imgNew\');" onmouseout="ZMBtnout(this,\'imgNew\');" src="'+ZLinksToImages.imgNew+'" alt="'+langTexts["menu_newpage_tooltip"]+'" title="'+langTexts["menu_newpage_tooltip"]+'" /></a>'+
						'</div>'+*/
						'<div class="ZmenuBlock">'+
							'<a href="javascript:void(0);" onclick="ZdoUndo();"><img onmouseover="ZMBtnover(this,\'imgUndo\');" onmouseout="ZMBtnout(this,\'imgUndo\');" src="'+ZLinksToImages.imgUndo+'" alt="'+langTexts["menu_undo_tooltip"]+'" title="'+langTexts["menu_undo_tooltip"]+'" /></a>'+
							'<a href="javascript:void(0);" onclick="ZdoRedo();"><img onmouseover="ZMBtnover(this,\'imgRedo\');" onmouseout="ZMBtnout(this,\'imgRedo\');" src="'+ZLinksToImages.imgRedo+'" alt="'+langTexts["menu_redo_tooltip"]+'" title="'+langTexts["menu_redo_tooltip"]+'" /></a>'+
						'</div>'+
						'<div class="ZmenuBlock">'+
							'<a href="javascript:void(0);" onclick="ZDoComandSelection(\'bold\');"><img onmouseover="ZMBtnover(this,\'imgBold\');" onmouseout="ZMBtnout(this,\'imgBold\');" src="'+ZLinksToImages.imgBold+'" alt="'+langTexts["menu_bold_tooltip"]+'"  title="'+langTexts["menu_bold_tooltip"]+'" /></a>'+
							'<a href="javascript:void(0);" onclick="ZDoComandSelection(\'italic\');"><img onmouseover="ZMBtnover(this,\'imgItalic\');" onmouseout="ZMBtnout(this,\'imgItalic\');" src="'+ZLinksToImages.imgItalic+'" alt="'+langTexts["menu_italic_tooltip"]+'"  title="'+langTexts["menu_italic_tooltip"]+'" /></a>'+
							
							'<a href="javascript:void(0);" onclick="ZDoComandSelection(\'underline\');"><img onmouseover="ZMBtnover(this,\'imgUnderline\');" onmouseout="ZMBtnout(this,\'imgUnderline\');" src="'+ZLinksToImages.imgUnderline+'" alt="'+langTexts["menu_underline_tooltip"]+'" title="'+langTexts["menu_underline_tooltip"]+'"/></a>'+
							'<a href="javascript:void(0);" onmousedown="ZmenuSubmenuAtOnce(this,Zimplit.Sources.headings(),function(){void(0);});" onmouseup="ZmenuSubmenuPopUp(this);"><img onmouseover="ZMBtnover(this,\'imgFontformat\');" onmouseout="ZMBtnout(this,\'imgFontformat\');" src="'+ZLinksToImages.imgFontformat+'" alt="'+langTexts["menu_textformat"]+'"  title="'+langTexts["menu_textformat"]+'" /></a>'+						
							
							'<a href="javascript:void(0);" onmousedown="ZmenuSubmenuAtOnce(this,Zimplit.Sources.fontsizes(),function(){void(0);});" onmouseup="ZmenuSubmenuPopUp(this);" ><img  src="'+ZLinksToImages.imgFontsize+'" onmouseover="ZMBtnover(this,\'imgFontsize\');" onmouseout="ZMBtnout(this,\'imgFontsize\');" alt="'+langTexts["menu_fontsize_tooltip"]+'"  title="'+langTexts["menu_fontsize_tooltip"]+'" /></a>'+
							'<a href="javascript:void(0);" onmousedown="ZmenuSubmenuAtOnce(this,Zimplit.Sources.txtcolors(),function(){void(0);});" onmouseup="ZmenuSubmenuPopUp(this);"><img src="'+ZLinksToImages.imgFontColor+'" onmouseover="ZMBtnover(this,\'imgFontColor\');" onmouseout="ZMBtnout(this,\'imgFontColor\');" alt="'+langTexts["menu_textcolor"]+'" title="'+langTexts["menu_textcolor"]+'"/></a>'+
						/*	'<a href="javascript:void(0);" onclick="ZInsertSymbols();"><img src="'+ZimplitEditorLocation+'images/symbols.gif" alt="Insert symbol"  title="Insert symbol" /></a>'+*/
						
						
							'<a href="javascript:void(0);" onmousedown="ZmenuSubmenuAtOnce(this,Zimplit.Sources.linkPopup,ZlinkStartFunction);" onmouseup="ZmenuSubmenuPopUp(this);"><img class="ZimgLink" onmouseover="ZMBtnover(this,\'imgLink\');" onmouseout="ZMBtnout(this,\'imgLink\');" src="'+ZLinksToImages.imgLink+'"  alt="'+langTexts["menu_link_tooltip"]+'"  title="'+langTexts["menu_link_tooltip"]+'" /></a>'+
							
							'<a href="javascript:void(0);" onclick="Zimplit.edit.toggleList();"><img class="ZimgList" onmouseover="ZMBtnover(this,\'imgList\');" onmouseout="ZMBtnout(this,\'imgList\');" src="'+ZLinksToImages.imgList+'" alt="'+langTexts["menu_list"]+'"  title="'+langTexts["menu_list"]+'" /></a>'+
						'</div>'+
						'<div class="ZmenuBlock">'+	
							
							
							'<a href="javascript:void(0);" onclick="ZimgPop();"><img class="ZimgPicture" onmouseover="ZMBtnover(this,\'imgPicture\');" onmouseout="ZMBtnout(this,\'imgPicture\');" src="'+ZLinksToImages.imgPicture+'" alt="'+langTexts["menu_image_tooltip"]+'"  title="'+langTexts["menu_image_tooltip"]+'" /></a>'+
							
							'<a href="javascript:void(0);" onmousedown="ZmenuSubmenuAtOnce(this,Zimplit.Sources.insertMenu(),function(){void(0);});" onmouseup="ZmenuSubmenuPopUp(this);" ><img onmouseover="ZMBtnover(this,\'imgAdd\');" onmouseout="ZMBtnout(this,\'imgAdd\');" src="'+ZLinksToImages.imgAdd+'" alt="'+langTexts["menu_add_tooltip"]+'"  title="'+langTexts["menu_add_tooltip"]+'" /></a>'+
							
						'</div>'+
						//'<a href="javascript:void(0);" onclick="ZaddmenuPop();"><img onmouseover="ZMBtnover(this,\'imgMenu\');" onmouseout="ZMBtnout(this,\'imgMenu\');" src="'+ZLinksToImages.imgMenu+'" alt="Site menu"  title="Site menu" /></a>'+
						//'<a href="javascript:void(0);" onclick="ZBugPop();"><img onmouseover="ZMBtnover(this,\'imgBug\');" onmouseout="ZMBtnout(this,\'imgBug\');" src="'+ZLinksToImages.imgBug+'" alt="Send a question"  title="Send a question" /></a>'+

						//'<div class="Zhelp"><a href="http://client.zimplit.com/manuals/English_manual_version_2.php?client=<?php echo $uid; ?>" target="_blank">'+langTexts["help"]+'</a></div>'+
						
					' </div>'+
				'</div>'+
			'</div>',
	sidemenu: '<div id="ZimplitSideMenu">'+
							'<div class="outerBorder">'+
							
									'<div class="headerPre">'+
										'<a href="'+ZphpName+'?action=logout" ><img src="'+ZimplitEditorLocation+'images/logout_icon.gif" alt="" /></a><br/><a href="'+ZphpName+'?action=logout" >'+langTexts["log_out"]+'</a>'+
									'</div>'+
									'<div class="header">'+
									ZlogoSmall+
									'</div>'+
									'<div class="inner">'+	
									'<a href="javascript:void(0);" onclick="Zimplit.GUI.sideMenu.toggle();"><img src="'+ZimplitEditorLocation+'images/sidemenuScroller.gif" class="sideScroller" alt="" /></a>'+
									'<a class="sideBtn" href="javascript:void(0);" onclick="ZSaveContent();"><img src="'+ZimplitEditorLocation+'images/saveSide.gif" alt="'+langTexts["menu_save_tooltip"]+'" title="'+langTexts["menu_save_tooltip"]+'" /><br/><span class="txt">'+langTexts["menu_save_tooltip"]+'</span></a>'+
									'<a href="javascript:void(0);" class="sideBtn" onclick="ZNewPagePop();"><img src="'+ZimplitEditorLocation+'images/newpageSide.gif" alt="'+langTexts["menu_newpage_tooltip"]+'" title="'+langTexts["menu_newpage_tooltip"]+'" /><br/><span class="txt">'+langTexts["menu_newpage_tooltip"]+'</span></a>'+
									'<a href="javascript:void(0);" onclick="Zimplit.GUI.sideMenu.btnToggle(\'#ZmenuStuc\');" class="sideBtn wide"><img src="'+ZimplitEditorLocation+'images/menustrucClosed.gif" alt="" /> <br/><span class="txt">'+langTexts["properties_settings_menustruc"]+'</span></a>'+
									'<div id="ZmenuStuc" style="display:none;" class="bigContent">'+
										langTexts["wait"]+
									'</div>'+
									'<a href="javascript:void(0);" onclick="Zimplit.popups.fileManager();" class="sideBtn wide hideClosed"><img src="'+ZimplitEditorLocation+'images/fileSide.gif" alt="" /> <br/><span class="txt">'+langTexts["properties_settings_filemanager"]+'</span></a>'+
									
									'<a href="javascript:void(0);" onclick="Zimplit.GUI.sideMenu.btnToggle(\'#ZSettingsMenuSide\');" class="sideBtn wide"><img src="'+ZimplitEditorLocation+'images/settingsSide.gif" alt="" /> <br/><span class="txt">'+langTexts["menu_settings_tooltip"]+'</span></a>'+
									'<div id="ZSettingsMenuSide" class="bigContent" style="display:none;line-height: 20px;"  >'+
										/*'<a href="javascript:void(0);" onclick="Zimplit.popups.fileManager();"><img src="'+ZimplitEditorLocation+'images/fileManagerSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_filemanager"]+'</a>'+*/
										'<a href="javascript:void(0);" onclick="ZimgSettingsPop();"><img src="'+ZimplitEditorLocation+'images/imgsetSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_picprops"]+'</a>'+
										
										'<a href="javascript:void(0);" onclick="Zimplit.popups.changeTemplate();"><img src="'+ZimplitEditorLocation+'images/changeTemplateSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_changetemplate"]+'</a>'+
										/*'<a href="javascript:void(0);" onclick="ZdeletePage();"><img src="'+ZimplitEditorLocation+'images/deleteSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_deletepage"]+'</a>'+*/
										'<a href="javascript:void(0);" onclick="ZSrcPop();"><img src="'+ZimplitEditorLocation+'images/sourceSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_pagesource"]+'</a>'+
										
										/*'<a href="javascript:void(0);" onclick="ZmenuStrucPop();"><img src="'+ZimplitEditorLocation+'images/menuSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_menustruc"]+'</a>'+
										'<a href="javascript:void(0);" onclick="Zaddmenu(5);"><img src="'+ZimplitEditorLocation+'images/menuSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_addmainmenu"]+'</a>'+
										'<a href="javascript:void(0);" onclick="Zaddmenu(3);"><img src="'+ZimplitEditorLocation+'images/menuSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_addsubmenu"]+'</a>'+*/
									'</div>'+	
									'<a href="javascript:void(0);" onclick="Zimplit.GUI.sideMenu.btnToggle(\'#ZHelpMenuSide\');" class="sideBtn wide"><img src="'+ZimplitEditorLocation+'images/helpSide.gif" alt="" /> <br/><span class="txt">'+langTexts["help"]+'</span></a>'+
									'<div id="ZHelpMenuSide" class="bigContent ZtreeList"  style="display:none;" >'+
										'<ul>'+
										'<li><a href="javascript:void(0);" onclick="Zimplit.GUI.loadHelp(\'\');">Manual</a></li>'+

										'</ul>'+
									'</div>'+
									
									
									
								'</div>'+
								
							'</div>'+
						'</div>'+
						'',
	imgPopup: function(){  
				return '<div id="ZimgPopup" class="ZpopupScreen">'+
					'<div class="inner" style="width:300px;height: 270px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZimgPopup\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							langTexts["properties_image_title"]+
						'</div>'+
						'<div class="theContentArea" style="padding: 5px;">'+
							'<div style="clear:both;overflow:hidden;padding:10px"><img src="'+ZimplitEditorLocation+'images/addpic_img.gif" style="float:left;margin-right:10px; margin-bottom: 10px;" alt="" />'+
						langTexts["properties_image_description"]+' </div>'+
							
							'<div class="ZtheImgProps" style="clear:both;overflow:hidden; padding: 10px 25px;">'+
								'<a href="javascript:void(0);" onclick="ZChangeImgAlignment(this,\'Block\');"><img src="'+ZimplitEditorLocation+'images/imgPropBlock_a.gif" class="selected" onmouseover="ZimgPopPropOver(this,\'imgPropBlock_a.gif\');" onmouseout="ZimgPopPropOut(this,\'imgPropBlock.gif\');" alt="Align normal" /></a>'+
								'<a href="javascript:void(0);" onclick="ZChangeImgAlignment(this,\'Left\');"><img src="'+ZimplitEditorLocation+'images/imgPropLeft.gif" onmouseover="ZimgPopPropOver(this,\'imgPropLeft_a.gif\');" onmouseout="ZimgPopPropOut(this,\'imgPropLeft.gif\');" alt="Align left" /></a>'+
								'<a href="javascript:void(0);" onclick="ZChangeImgAlignment(this,\'Right\');"><img src="'+ZimplitEditorLocation+'images/imgPropRight.gif" onmouseover="ZimgPopPropOver(this,\'imgPropRight_a.gif\');" onmouseout="ZimgPopPropOut(this,\'imgPropRight.gif\');" alt="Align right" style="border-right: 1px solid #cccccc;" /></a>'+
								'<input type="hidden" id="ZtheImgPropsAlignment" value="Block" />'+
							'</div>'+
							'<div style="padding:10px;">'+
								'<input type="checkbox" id="ZtheImgPropsZoom" /a> '+langTexts["properties_image_clickandzoom"]+''+
							'</div>'+
							'<form id="ZimageForm" method="post" action="'+ZphpName+'?action=upload&folder=Z-pictures&max_width='+ZmaxpicW +'&max_height='+ZmaxpicH +'" style="margin:0; padding:2px 5px; clear:both;">'+
								'<input type="file" name="file" id="ZImageUploadAddr" style="border: 1px solid #919194; width: 230px; height:20px; margin-right: 4px;" class="txtbox" />'+
								'<input type="submit" class="submitBtn" name="Submit" value="'+langTexts["ok"]+'" />'+
							'</form>'+ 
						'</div>'+	
					'</div>'+
				'</div>';},
	linkPopup: '<div id="ZmenuSubmenu" class="ZpopupScreen ZlinkPopup">'+
					'<div class="inner" style="width:200px;">'+
						'<div class="theContentArea">'+
							'<input type="text" name="LinkAddr" id="ZlinkAddr" class="txtbox" />'+
							//'<button onclick="ZremovePopup(\'#ZlinkPopup\');">Cancel</button>'+
							
							'<button class="submitBtn" name="Submit" onclick="ZInsertLink($(\'#ZlinkAddr\').val());">'+langTexts["ok"]+'</button>'+
						'</div>'+	
					'</div>'+
				'</div>',
	copyPagePopup: '<div id="ZcopyPagePop" class="ZpopupScreen">'+
						'<div class="inner" style="width:340px;">'+
							'<div class="header">'+
								'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZcopyPagePop\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
								langTexts["properties_newpage_title"]+
							'</div>'+
							'<div class="theContentArea">'+
								
								'<img src="'+ZimplitEditorLocation+'images/copyPage.gif" style="float:left;margin-right: 10px;" alt="" />'+
								langTexts["properties_newpage_description"]+

								'<div style="clear:both;margin-top: 10px;">'+
									'<span style="font-size: 10px; line-heigt:12px;">'+langTexts["properties_newpage_pagename"]+'</span>'+
									'<input type="txtbox" name="name" value="Page name" id="ZCopyPageName" /><br/>'+
									'<span style="font-size: 10px; line-heigt:12px;">'+langTexts["properties_newpage_pagetocopy"]+'</span>'+
									'<select name="PageSrc" id="ZCopyPageSrc">'+
										'<option>-- '+langTexts["wait"]+' --</option>'+
									'</select><br/>'+
									'<span style="font-size: 10px; line-heigt:12px;">'+langTexts["get_design_from_url"]+' :</span>'+
									'<input id="ZNewPageUrl" name="newPageUrl" class="ZCopyPageInput" type="txtbox" value="http://" /><br/><br/>' +
									'<button name="submit" class="submitBtn" onclick="Zimplit.newPage()">'+langTexts["save"]+'</button>'+
									'<button name="submit" class="submitBtn" onclick="ZremovePopup(\'#ZcopyPagePop\')">'+langTexts["cancel"]+'</button>&nbsp;'+
								'</div>'+

							'</div>'+
						'</div>'+
					'</div>',
/*	addmenuPop: '<div id="ZaddmenuPop" class="ZpopupScreen">'+
					'<div class="inner" style="width:210px;height: 170px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZaddmenuPop\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							'Menu'+
						'</div>'+
						'<div class="theContentArea">'+
							'<a href="javascript:void(0)" onclick="Zaddmenu(4)">The whole site menu</a>'+
							'<a href="javascript:void(0)" onclick="Zaddmenu(1)">Insert mainmenu (with just links)</a>'+
							'<a href="javascript:void(0)" onclick="Zaddmenu(5)">Insert mainmenu (with list elements LI)</a>'+
							'<a href="javascript:void(0)" onclick="Zaddmenu(2)">Insert this level and subpages</a>'+
							'<a href="javascript:void(0)" onclick="Zaddmenu(3)">Insert subpages of this page</a>'+
							'<a href="javascript:void(0)" onclick="ZmenuStrucPop();">Menu structure and options</a>'+
						'</div>'+	
					'</div>'+
				'</div>',*/
				
	menuStructure: '<div id="ZMenuStructure" class="ZpopupScreen">'+
						'<div class="inner" style="width:300px;height: 465px;">'+
							'<div class="header">'+
								'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZMenuStructure\');" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
								langTexts["properties_menustructure_title"]+
							'</div>'+
							'<div class="theContentArea"  style="overflow: auto;padding:0px;">'+
								'<div style="background: #ececec;overflow:hidden; clear:both; padding: 10px;float:left;">'+
									'<img src="'+ZimplitEditorLocation+'images/menuSruc.gif" style="float:left;margin-right: 10px;" alt="" />'+
									langTexts["properties_menustructure_description"]+
								'</div>'+
								'<div style="border: 1px solid #cccccc;clear:both;height:317px; overflow: hidden;">'+
									'<div id="ZmenuStuc">'+
										langTexts["wait"]+
									'</div>'+
								'</div>'+
								'<div style="background: #ececec;overflow:hidden;padding: 10px;">'+
									'<button onclick="ZSaveTheMenuStruc();">'+langTexts["save"]+'</button>&nbsp;'+
									'<button onclick="ZremovePopup(\'#ZMenuStructure\');">'+langTexts["cancel"]+'</button>'+
									'<a href="#" style="font-size: 12px; padding: 0 0 0 10px;line-height: 26px; color: #0e9600;vertical-align:middle;">'+langTexts["help"]+'</a>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>',
	menuStructureAskName: '<div id="ZRenamePage" class="ZpopupScreen">'+
					'<div class="inner" style="width:300px;height: 70px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="$(\'#ZRenamePage\').remove();" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							langTexts["properties_menustructure_askname"]+
						'</div>'+
						'<div class="theContentArea">'+
							'<input type="hidden" id="ZRenamePageSrc" value=""/>'+
							'<input type="text"  class="txtbox" id="ZRenamePageName" class="txtbox" />'+
							'<button class="submitBtn" name="Submit" onclick="ZRenamePage($(\'#ZRenamePageSrc\').val(), $(\'#ZRenamePageName\').val());">'+langTexts["ok"]+'</button>'+
							'<button onclick="$(\'#ZRenamePage\').remove();" class="submitBtn">'+langTexts["cancel"]+'</button>'+
						'</div>'+	
					'</div>'+
				'</div>',
	headings: function (){
		return '<div id="ZmenuSubmenu" class="ZpopupScreen">'+
					'<div class="inner" style="">'+
						
						'<div class="theContentArea" style="overflow: auto;">'+
							'<a href="javascript:void(0);" onclick="ZInsHeading(0);">'+langTexts["properties_fontsize_normal"]+'</a>'+
							'<a href="javascript:void(0);" onclick="ZInsHeading(1);">'+langTexts["properties_fontsize_h1"]+'</a>'+
							'<a href="javascript:void(0);" onclick="ZInsHeading(2);">'+langTexts["properties_fontsize_h2"]+'</a>'+
							'<a href="javascript:void(0);" onclick="ZInsHeading(3);">'+langTexts["properties_fontsize_h3"]+'</a>'+
							'<hr style="width: 100px;"/>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textFont(\'Arial\');" style="font-family :arial">Arial</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textFont(\'Courier New\');" style="font-family :\'Courier New\'">courier</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textFont(\'Georgia\');" style="font-family :georgia">Georgia</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textFont(\'Times\');" style="font-family :times">Times</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textFont(\'Verdana\');" style="font-family :verdana">Verdana</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textFont(\'Trebuchet MS\');" style="font-family :\'Trebuchet MS\'">Trebuchet MS</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textFont(\'Lucida Sans\');" style="font-family :\'Lucida Sans\'">Lucida Sans</a>'+
							
						'</div>'+	
					'</div>'+
				'</div>';
			},
	fontsizes: function (){
		return '<div id="ZmenuSubmenu" class="ZpopupScreen">'+
					'<div class="inner" style="">'+
						
						'<div class="theContentArea" style="overflow: auto;">'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(8);" >8px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(10);" >10px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(12);" >12px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(14);" >14px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(16);" >16px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(18);" >18px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(20);" >20px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(22);" >22px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(24);" >24px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(28);" >28px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(32);" >32px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(48);" >48px</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textSize(72);" >72px</a>'+
						'</div>'+	
					'</div>'+
				'</div>';
			},
		
	txtcolors: function (){
		return '<div id="ZmenuSubmenu" class="ZpopupScreen">'+
					'<div class="inner" style="">'+
						
						'<div class="theContentArea" style="overflow: auto;">'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textColor(\'000000\');" style="font-family :arial; white-space: nowrap;"><span class="ZTxtColorBox" style="background:#000000"></span>'+langTexts["color_black"]+'</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textColor(\'800000\');" style="font-family :arial; white-space: nowrap;"><span class="ZTxtColorBox" style="background:#800000"></span>'+langTexts["color_maroon"]+'</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textColor(\'008000\');" style="font-family :arial; white-space: nowrap;"><span class="ZTxtColorBox" style="background:#008000"></span>'+langTexts["color_green"]+'</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textColor(\'808000\');" style="font-family :arial; white-space: nowrap;"><span class="ZTxtColorBox" style="background:#808000"></span>'+langTexts["color_olive"]+'</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textColor(\'000080\');" style="font-family :arial; white-space: nowrap;"><span class="ZTxtColorBox" style="background:#000080"></span>'+langTexts["color_marine"]+'</a>'+
							'<a href="javascript:void(0);" onclick="Zimplit.edit.textColor(\'FFFFFF\');" style="font-family :arial; white-space: nowrap;"><span class="ZTxtColorBox" style="background:#FFFFFF"></span>'+langTexts["color_white"]+'</a>'+
						'</div>'+	
					'</div>'+
				'</div>';
			},
			
	srcPop: '<div id="ZViewSrc" class="ZpopupScreen">'+
				'<div class="inner" style="width:900px;">'+
					'<div class="header">'+
						'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZViewSrc\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
						langTexts["properties_source_title"]+
					'</div>'+
					'<div class="ZSrcInner">'+
						'<div class="sourcesHeader" id="ZtheSourceH"  style="background:#ececec;"></div>'+
						'<div>'+
							'<textarea id="ZtheSourceW" style="width:894px; height: 400px;"></textarea>'+
							'<input type="hidden" id="ZtheSourceF" value=""/>'+
						'</div>'+
						'<div style="padding: 5px 1px; overflow:hidden;"><button onclick="ZsaveSrc($(\'#ZtheSourceW\').val(),$(\'#ZtheSourceF\').val());" class="submitBtn">'+langTexts["save"]+'</button><br/></div>'+
					'</div>'+
				'</div>'+
			'</div>',
/*	bugPop: '<div id="ZBugView" class="ZpopupScreen">'+
				'<div class="inner" style="width:285px;height: 400px;">'+
					'<div class="header">'+
						'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZBugView\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
						'Send us a question or bug'+
					'</div>'+
					'<div style="padding: 10px;">'+
						'<form method="post" id="ZbugForm" action="'+ZphpName+'?action=sendreply">'+ 
						'<div class="theContentArea">'+
							'<input type="hidden" name="doclocation" id="ZbugFormDocLoc" value="" />'+
							'<span style="font-size: 10px; line-heigt:12px;">Your name</span><br/>'+
							'<input type="text" name="Name" class="txtbox"/><br/>'+
							'<span style="font-size: 10px; line-heigt:12px;">Your e-mail</span><br/>'+
							'<input type="text" name="Email" class="txtbox"/><br/>'+
							'<span style="font-size: 10px; line-heigt:12px;">Type your problem here</span><br/>'+
							'<textarea class="txtarea" name="Text"></textarea><br/>'+
							'<input type="submit" value="Send" class="submitBtn" />'+
						'</div>'+
						'</form>'+
					'</div>'+
				'</div>'+
			'</div>',
			*/
	FFPastePop: '<div id="ZFFpaste" class="ZpopupScreen">'+
				'<div class="inner" style="width:285px;height: 400px;">'+
					'<div class="header">'+
						'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZFFpaste\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
						langTexts["properties_firefoxpaste_title"]+
					'</div>'+
					'<div style="padding: 10px;">'+
						'<div class="theContentArea">'+
							'<textarea class="txtarea" id="ZFFpasteTxt"></textarea><br/><br/>'+
							'<button onclick="ZFFPasteDo();" class="submitBtn">'+langTexts["properties_firefoxpaste_paste"]+'</button>&nbsp;'+
							'<button onclick="ZremovePopup(\'#ZFFpaste\');" class="submitBtn">'+langTexts["cancel"]+'</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>',
	ZSettingsPopup: '<div id="ZmenuSubmenu" class="ZpopupScreen">'+
					'<div class="inner" style="">'+
						'<div class="theContentArea ZlistOfLinks" style="padding: 5px;">'+
							'<a href="javascript:void(0);" onclick="Zimplit.popups.fileManager();"><img src="'+ZimplitEditorLocation+'images/fileManagerSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_filemanager"]+'</a>'+
							'<a href="javascript:void(0);" onclick="ZimgSettingsPop();"><img src="'+ZimplitEditorLocation+'images/imgsetSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_picprops"]+'</a>'+
							
							'<a href="javascript:void(0);" onclick="Zimplit.popups.changeTemplate();"><img src="'+ZimplitEditorLocation+'images/changeTemplateSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_changetemplate"]+'</a>'+
							'<a href="javascript:void(0);" onclick="ZdeletePage();"><img src="'+ZimplitEditorLocation+'images/deleteSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_deletepage"]+'</a>'+
							'<a href="javascript:void(0);" onclick="ZSrcPop();"><img src="'+ZimplitEditorLocation+'images/sourceSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_pagesource"]+'</a>'+
							
							'<a href="javascript:void(0);" onclick="ZmenuStrucPop();"><img src="'+ZimplitEditorLocation+'images/menuSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_menustruc"]+'</a>'+
							'<a href="javascript:void(0);" onclick="Zaddmenu(5);"><img src="'+ZimplitEditorLocation+'images/menuSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_addmainmenu"]+'</a>'+
							'<a href="javascript:void(0);" onclick="Zaddmenu(3);"><img src="'+ZimplitEditorLocation+'images/menuSmall.gif" alt="" />&nbsp;&nbsp;'+langTexts["properties_settings_addsubmenu"]+'</a>'+
						'</div>'+	
					'</div>'+
				'</div>',
	imgSettingsPop: function() {return '<div id="ZimgSettingsPopup" class="ZpopupScreen">'+
					'<div class="inner" style="width:300px;height: 300px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZimgSettingsPopup\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							langTexts["properties_imagesettings_title"]+
						'</div>'+
						'<div class="theContentArea" style="padding: 5px;">'+
								'<div style="clear:both;overflow:hidden;padding: 10px;"><img src="'+ZimplitEditorLocation+'images/settingsPic.gif" style="float:left;margin-right:10px; margin-bottom: 0px;" alt="" />'+
								langTexts["properties_imagesettings_description"]+'</div>'+
								'<div  style="clear:both;overflow:hidden;padding: 10px;">'+
									'<div style="clear:both; overflow:hidden;">'+
										langTexts["properties_imagesettings_smallimage"]+'<br/>'+
										'<img src="'+ZimplitEditorLocation+'images/thumbnailsPic.gif" style="float:left; margin: 5px 15px 5px 5px;" alt="" />'+
										'<br/><input type="text" id="ZimgSettingsPopupSmallX" value="'+ZmaxpicZoomW+'"/> <b>X</b> <input type="text" id="ZimgSettingsPopupSmallY" value="'+ZmaxpicZoomH+'"/><br/><br/>'+
									'</div>'+
									'<div style="clear:both; overflow:hidden;">'+
										langTexts["properties_imagesettings_largeimage"]+'<br/>'+
										'<img src="'+ZimplitEditorLocation+'images/imagesPic.gif" style="float:left; margin: 5px;" alt="" />'+
										'<br/><input type="text" id="ZimgSettingsPopupLargeX" value="'+ZmaxpicW+'"/> <b>X</b> <input type="text" id="ZimgSettingsPopupLargeY" value="'+ZmaxpicH+'"/><br/><br/>'+
									'</div><br/>'+	
									'<button onclick="ZchangePicSettings();" class="submitBtn">'+langTexts["save"]+'</button>'+
									'<button onclick="ZremovePopup(\'#ZimgSettingsPopup\');" class="submitBtn">'+langTexts["cancel"]+'</button>'+
								'</div>'+
						'</div>'+	
					'</div>'+
				'</div>';},
	insertMenu: function(){ 
					return '<div id="ZmenuSubmenu" class="ZpopupScreen" >'+
						'<div class="inner" style="overflow: hidden;float:left;">'+
							'<div class="theContentArea ZlistOfLinks" style="overflow: hidden; clear: both;">'+
								'<a href="javascript:void(0);" onclick="ZInsFilePop();"><img src="'+ZimplitEditorLocation+'images/fileUp.gif" alt="" title="" />&nbsp;&nbsp;'+langTexts["properties_insert_file"]+'</a>'+
								'<a href="javascript:void(0);" onclick="ZInsYoutubePop();"><img src="'+ZimplitEditorLocation+'images/youtubeSmall.gif" alt="" title="" />&nbsp;&nbsp;'+langTexts["properties_insert_youtube"]+'</a>'+
								ZdrawModulesList()+
							'</div>'+	
						'</div>'+
					'</div>';
				},
	insFilePopup: function(){  
				return '<div id="ZinsFilePopup" class="ZpopupScreen">'+
					'<div class="inner" style="width:300px;height: 150px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZinsFilePopup\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							langTexts["properties_insertfile_title"]+
						'</div>'+
						'<div class="theContentArea" style="padding: 5px;">'+
							'<div style="clear:both;overflow:hidden;padding:10px"><img src="'+ZimplitEditorLocation+'images/fileUpload.gif" style="float:left;margin-right:10px; margin-bottom: 0px;" alt="" />'+
							langTexts["properties_insertfile_description"]+'</div>'+
							'<form id="ZFileUpForm" method="post" action="'+ZphpName+'?action=upload&folder=Z-files&max_width=100000&max_height=100000" style="margin:10px 0 0 0; padding:0px 5px; clear:both; display:block;">'+
								'<input type="file" name="file" id="ZFileUploadAddr" style="border: 1px solid #919194; width: 230px;  margin-right: 4px;" class="txtbox" />'+
								'<input type="submit" class="submitBtn" name="Submit" value="'+langTexts["ok"]+'" />'+
							'</form>'+ 
						'</div>'+	
					'</div>'+
				'</div>';},
	insYoutubePop: function (){
		return '<div id="ZYoutubePopup" class="ZpopupScreen">'+
						'<div class="inner" style="width:300px;height: 280px;">'+
							'<div class="header">'+
								'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZYoutubePopup\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
								langTexts["properties_youtube_title"]+
							'</div>'+
							'<div class="theContentArea" style="margin: 4px;">'+
								'<div style="clear:both;overflow:hidden;padding:5px 10px; border-bottom: 1px dotted #919194;"><img src="'+ZimplitEditorLocation+'images/youtubeBig.gif" style="float:left;margin-right:10px; margin-bottom: 10px;" alt="" />'+
								langTexts["properties_youtube_description"]+'</div>'+
								'<div style="clear:both;overflow:hidden;padding:5px 10px 10px 10px; border-bottom: 1px dotted #919194;font-size: 12px; margin-bottom: 5px;">'+
									'<div style="margin: 8px 0;">'+langTexts["properties_youtube_url"]+'</div>'+
									'<input type="text" style="width: 250px;" id="ZyoutubeAddr" /><br/>'+
									'<span style="color:#c4c4c4;font-size: 10px;">'+langTexts["properties_youtube_example"]+'</span>'+
									'<div style="margin: 16px 0 8px 0;"><b>'+langTexts["properties_youtube_diplayprops"]+'</b></div>'+
									'<input type="checkbox" id="ZyoutubeMargin" /> '+langTexts["properties_youtube_includespace"]+'<br/>'+
									'<input type="checkbox" id="ZyoutubeTitleYes" /> '+langTexts["properties_youtube_includetitle"]+' <input type="text" id="ZyoutubeTitle" />'+
							
								'</div>'+
								'<button onclick="ZInsYoutube($(\'#ZyoutubeAddr\').val(),  $(\'#ZyoutubeMargin\').attr(\'checked\'), $(\'#ZyoutubeTitleYes\').attr(\'checked\'), $(\'#ZyoutubeTitle\').val());" class="submitBtn">'+langTexts["save"]+'</button>'+
								'<button onclick="ZremovePopup(\'#ZYoutubePopup\');" class="submitBtn">'+langTexts["cancel"]+'</button>'+ 
							'</div>'+	
						'</div>'+
					'</div>';
					
	},
	emptyEdArea: function(){
		return '<span class="'+ZEmptyEditableAreaNotifierClass+'">'+Zmessages.editableEmpty+'</span>';
	},
	googleSearchScript: function(){
		return '<style type="text/css">.'+Zimplit.objectNames.googleSearchBox+' .gsc-control { width : 100%; } .ZGoogleMapBox img { background: transparent; background-image: none; }</style>'+
							'<script src="http://www.google.com/jsapi?key=ABQIAAAAhox8rLPQ1SDwoS5l973qnBTaTMz-yFeCWozVi0VhBDLUysy0uxSF3gklh0VQpajoYFImTjochkOgxg" type="text/javascript"></script>'+
							'<script  type="text/javascript" src="'+ZimplitEditorLocation+'ZgoogleSearcBox.js"></script>';
	},
	googleSearchBox: function(pageSrc){
		var currentdate = new Date();
		var milliseconds = currentdate.getTime();
		var thecode= '<div class="'+Zimplit.objectNames.googleSearchBox+' ZDeletableEl2" id="'+Zimplit.objectNames.googleSearchDivIdPrefix+milliseconds+'"></div>';
		if(IE){
			thecode += '<span class="ZreplaceWithGSBoxScript" theid="'+Zimplit.objectNames.googleSearchDivIdPrefix+milliseconds+'" pagesrc="'+pageSrc+'"></span>';
		} else {
			thecode += '<script  type="text/javascript">ZLoadGSearch(document.getElementById("'+Zimplit.objectNames.googleSearchDivIdPrefix+milliseconds+'"),"'+pageSrc+'");</script>';
		}		
		return thecode;
	},
	
	googleMapBox: function(pointx,pointy,zoom,text){
		var currentdate = new Date();
		var milliseconds = currentdate.getTime();
		var thecode= '<div class="'+Zimplit.objectNames.googleMapBox+' ZDeletableEl2" id="'+Zimplit.objectNames.googleMapDivIdPrefix+milliseconds+'"></div>';
		if(IE){
			thecode += '<span class="ZreplaceWithGMBoxScript" theid="'+Zimplit.objectNames.googleMapDivIdPrefix+milliseconds+'" pointx="'+pointx+'" pointy="'+pointy+'" zoom="'+zoom+'" text="'+text+'"></span>';
		} else {
			thecode += '<script  type="text/javascript">ZLoadGMap(document.getElementById("'+Zimplit.objectNames.googleMapDivIdPrefix+milliseconds+'"),'+pointx+','+pointy+','+zoom+',"'+text+'");</script>';
		}		
		return thecode;
	},
	
	changeTemplatePop: function(){
		return '<div id="ZChangeTemplate" class="ZpopupScreen">'+
					'<div class="inner" style="width:300px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZChangeTemplate\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							langTexts["properties_template_title"]+
						'</div>'+
						'<div class="theContentArea">'+
							'<div style="margin: 10px;font-size: 12px;">'+
								'<img src="'+ZimplitEditorLocation+'images/changeTemplate.gif" style="float:left;margin-right:10px; margin-bottom: 0px;display:block;" alt="" />'+
							langTexts["properties_template_description"]+
							'</div>'+
							'<button class="submitBtn" name="Submit" onclick="Zimplit.popups.templatesView();">'+langTexts["continue"]+'</button>'+
							'<button class="submitBtn" name="Submit" onclick="ZremovePopup(\'#ZChangeTemplate\');">'+langTexts["cancel"]+'</button>'+
						'</div>'+	
					'</div>'+
				'</div>';
	},
	
	templateView: function(){
		return '<div id="ZTemplateView" class="ZpopupScreen">'+
					'<div class="inner" style="width:800px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZTemplateView\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							langTexts["properties_template_title"]+
						'</div>'+
						'<div class="theContentArea">'+
							'<div style="padding: 2px 5px 5px 5px;">'+
								langTexts["disclaimer_short"]+''+
								 '<input type="checkbox" onchange="if(this.checked){$(\'#downloadAPage\').get(0).disabled= false;$(\'#ZdesignFromUrlFormSubA\').get(0).disabled= false;}else{$(\'#downloadAPage\').get(0).disabled= true;$(\'#ZdesignFromUrlFormSubA\').get(0).disabled= true;}"/> '+langTexts["read_disclaimer"]+''+
							langTexts["templateview_eneter_address"]+': <input type="text" class="txtbox"  disabled="disabled" value="http://" id="downloadAPage" style="width: 300px;padding:6px;"/>'+
								'<button class="submitBtn" id="ZdesignFromUrlFormSubA" name="Submit" disabled="disabled"  onclick="Zimplit.template.change(null,\'userdefined\')">'+langTexts["continue"]+'</button>'+
							'	<button class="submitBtn" name="Submit" onclick="ZremovePopup(\'#ZTemplateView\');">'+langTexts["cancel"]+'</button>'+
							
								
							'</div>'+
							'<div id="ZTemplateViewLoader" style="margin: 100px 0 0 0; text-align: center; height:250px;"><img src="'+ZimplitEditorLocation+'images/loading.gif" class="ZloaderImg" alt="" /></div>'+
							'<iframe style="height:350px;  overflow: auto; border:0; display:none; width:100%;" frameborder="0" id="ZTemplateViewArea" onload="Zimplit.template.rewriteView(this);" src="'+ZphpName+'?action=loadExternalHtml&file='+templateLoc+'"></iframe>'+
							
						'</div>'+	
					'</div>'+
				'</div>';
	},
	
	fileManager: function(){
		return '<div id="ZFileManager" class="ZpopupScreen">'+
					'<div class="inner" style="width:600px;">'+
						'<div class="header">'+
							'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZFileManager\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
							langTexts["properties_settings_filemanager"]+
						'</div>'+
						'<div class="theContentArea">'+
							'<div id="ZFileManagerPath"></div>'+
							'<div id="ZFileManagerArea"></div>'+
						'</div>'+	
					'</div>'+
				'</div>';
	}
}