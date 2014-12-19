/* default modules */
var ZScripterModule = {
	title: langTexts["module_scripter_title"],
	icon: ZimplitEditorLocation+"images/ZscripterFilesIco.gif",
	guide_text: langTexts["module_scripter_description"],
	public_html: function(){
		var theHtml = '';
		return theHtml;
	},
	zimplit_html: function(){
		var theHtml = "";
		return theHtml;
	},
	zimplit_optionsview_html: function(){
		var theHtml =	langTexts["module_scripter_optview1"]+'<br/>'+
						'<textarea id="Zmodule_Scripter_public" cols="55" rows="5"></textarea><br/><br/>'+
						langTexts["module_scripter_optview1"]+'<br/>'+
						'<textarea id="Zmodule_Scripter_zimplit" cols="55" rows="5"></textarea>';
		return theHtml;
	},
	on_submit: function(){
		var mName = $('#Zmodule_Scripter_name').attr('value');
		var publicHtml = $('#Zmodule_Scripter_public').attr('value');
		var zimplitHtml = $('Zmodule_Scripter_zimplit').attr('value');
			var theDate = new Date();
			var timestamp = theDate.getTime();
		var jsFileName = 'scripter_'+timestamp+'.js';
		var jsSource = 	'if (window.top.isintheZeditor){'+
							'document.write(\'<span class="ZelementToBeDeleted" style="background: #dddddd;">\'+unescape(\''+escape($('#Zmodule_Scripter_zimplit').attr('value'))+'\')+\'</span>\');'+
						'} else {'+
							'document.write(unescape(\''+escape($('#Zmodule_Scripter_public').attr('value'))+'\'));'+
						'}';

		$.post(ZphpName+"?action=new&file=Z-files/"+jsFileName  , { empty: 'empty'}, function(data){
			if(data == 1){
				$.post(ZphpName+"?action=save&file=Z-files/"+jsFileName, { html: jsSource},
				function(data2){
					if(data2 == ""){
						var script = ZimplitPage.createElement('script');
						script.type = 'text/javascript';
						script.text = '';
						script.id = 'ZtempidScript';
						script.className = 'ZmoduleScript';
						var tmpEl = ZimplitPage.getElementById('ZimplitBlinker');
						var insertedElement = tmpEl.parentNode.insertBefore(script, tmpEl);
						$(insertedElement).attr('zsrctemp',"Z-files/"+jsFileName).removeAttr('id');
						$(insertedElement).before('<span class="ZelementToBeDeleted" style="background: #dddddd;">'+$('#Zmodule_Scripter_zimplit').attr('value')+'</span>')
						ZremovePopup('#ZmodulePropsPop');
					} else {
						alert(data2);
					}
				});
			} else {
				alert(langTexts["module_scripter_error1"]);
			}
			
		});
	
	}
	
}
Zmodules.push(ZScripterModule);

var ZGoogleSearchModule = {
	title: langTexts["module_googlesearch_title"],
	icon: ZimplitEditorLocation+"images/googleSearch.gif",
	guide_text: '<img src="'+ZimplitEditorLocation+'images/googleSearchBig.gif"  style="display:block; float:left; margin-right: 10px;" alt="" /> '+langTexts["module_googlesearch_description"],
	zimplit_optionsview_html: function(){
		var thispage=ZimplitPage.location.href;
		var thissite = thispage.substring(0,thispage.lastIndexOf('\/'))+'/';
		var theHtml =	langTexts["module_googlesearch_optview"]+' <input id="Zmodule_Gsearch_page" style="width: 340px;" value="'+thissite+'" />';
		return theHtml;
	},
	on_submit: function(){
		var ZGsearchPage = $('#Zmodule_Gsearch_page').val();
		var ZGsearchText = $('#Zmodule_Gsearch_text').val();
		if(!Zimplit.getId(Zimplit.objectNames.googleSearchScript,'page')){
			$(ZimplitPage.body).prepend('<span id="'+Zimplit.objectNames.googleSearchScript+'" style="display: none;"></span>');
		}
		
		ZinsertAtBlinker('<span id="ZtempGoogleEditContent"></span>');
		 Zimplit.getId('ZtempGoogleEditContent','page').innerHTML = Zimplit.Sources.googleSearchBox(ZGsearchPage) + '<div class="ZelementToBeDeleted" style="background:#aaaaaa; color: #FF0000;"><b>'+langTexts["module_googlesearch_notify1"]+'</b><div>';
		 $(Zimplit.getId('ZtempGoogleEditContent','page')).attr('id','');
									
 		ZremovePopup('#ZmodulePropsPop');
	}
}
Zmodules.push(ZGoogleSearchModule);




var ZGoogleMapsModule ={
	title: langTexts["googlemap_title"],
	icon: ZimplitEditorLocation+"images/googleMaps.gif",
	guide_text: '<img src="'+ZimplitEditorLocation+'images/googleMapsBig.gif"  style="display:block; float:left; margin-right: 10px;" alt="" /> '+langTexts["googlemap_text"]+'',
	googleScript: 'http://www.google.com/jsapi?key=ABQIAAAAhox8rLPQ1SDwoS5l973qnBTaTMz-yFeCWozVi0VhBDLUysy0uxSF3gklh0VQpajoYFImTjochkOgxg',
	
	/* function that should return the html to be displayed for options.  */
	zimplit_optionsview_html: function(){
		var theHtml =	'<br/><br/>'+
								'<div style="clear:both; overflow: hidden;">'+
									'<div style="float:left; width: 100px;">'+
										langTexts["googlemap_pointer_text"]+': <textarea id="ZGooleMap_text"  name="ZGooleMap_text_name" style="width: 170px;"></textarea>'+
									'</div>'+ 
									'<div style="float:right; width: 300px;"><div id="ZGooleMap_area" style="height:300px;width: 300px;">'+langTexts["googlemap_loading"]+'</div></div>'+
								'</div>'+
								'<input type="hidden" name="ZGooleMap_point_x_name" id="ZGooleMap_point_x" value=""/>'+
								'<input type="hidden" name="ZGooleMap_point_y_name" id="ZGooleMap_point_y" value=""/>'+
								'<input type="hidden" name="ZGooleMap_zoom_name" id="ZGooleMap_zoom" value=""/>';
		return theHtml;
	},
	
	/* if options view html in zimplit is done, this function is initiated. can be used for additional post processing. */
	zimplit_optionsview_after: function(){
		$.ajaxSetup({async: false});
		$.getScript(this.googleScript, function(){
			google.load("maps", "2.x", {callback:function(){
				if (GBrowserIsCompatible()) {
					ZimplitGooglemap = new GMap2(document.getElementById('ZGooleMap_area'));
					ZimplitGooglemap.setCenter(new GLatLng(58.368,26.729), 1);
					/*ZimplitGooglemap.setUIToDefault();*/
					var mapTypeControl = new GMapTypeControl();
					ZimplitGooglemap.addControl(new GSmallMapControl());
					ZimplitGooglemapPoints = new GMarker(new GLatLng(58.368,26.730));
					ZimplitGooglemap.addOverlay(ZimplitGooglemapPoints);
					
					//map.openInfoWindow(new GLatLng(58.368,26.730),document.createTextNode("minu kodu"));
					GEvent.addListener(ZimplitGooglemap, "click", function(overlay, point){
						ZimplitGooglemap.removeOverlay(ZimplitGooglemapPoints); 
						ZimplitGooglemapPoints = new GMarker(point);
						ZimplitGooglemap.addOverlay(ZimplitGooglemapPoints);
						$('#ZGooleMap_point_x').val(point.x);
						$('#ZGooleMap_point_y').val(point.y);
						$('#ZGooleMap_zoom').val(ZimplitGooglemap.getZoom());
					});
					
					GEvent.addListener(ZimplitGooglemap, "zoomend", function() {
						$('#ZGooleMap_zoom').val(ZimplitGooglemap.getZoom());
					});

				  } else {
						$('#ZGooleMap_area').html(langTexts["no_google"]);
				  }
				}
			});
		  });
		  $.ajaxSetup({async: true});
	},
	
	/* save button clicked... then what happens ? */
	on_submit: function(){
		var theGpointX = $('#ZGooleMap_point_x').val();
		var theGpointY = $('#ZGooleMap_point_y').val();
		var theGzoom = $('#ZGooleMap_zoom').val();
		var theGtext = $('#ZGooleMap_text').val();

		if(!Zimplit.getId(Zimplit.objectNames.googleSearchScript,'page')){
			$(ZimplitPage.body).prepend('<span id="'+Zimplit.objectNames.googleSearchScript+'" style="display: none;"></span>');
		}
		
		ZinsertAtBlinker('<span id="ZtempGoogleEditContent"></span>');
		 Zimplit.getId('ZtempGoogleEditContent','page').innerHTML = Zimplit.Sources.googleMapBox(theGpointX,theGpointY,theGzoom,theGtext) + '<div class="ZelementToBeDeleted" style="background:#aaaaaa; color: #FF0000;"><b>'+langTexts["module_googlesearch_notify1"]+'</b><div>';
		 $(Zimplit.getId('ZtempGoogleEditContent','page')).attr('id','');
									
 		ZremovePopup('#ZmodulePropsPop');
	}
}
/*Zmodules.push(ZGoogleMapsModule);*/




var ZFeedbackModule ={
	title: langTexts["feedback_title"],
	icon: ZimplitEditorLocation+"images/comments_add.gif",
	guide_text: '<img src="'+ZimplitEditorLocation+'images/comments_add_big.gif"  style="display:block; float:left; margin-right: 10px;" alt="" /> '+langTexts["feedback_text"],
	
	addField: function(){
		$('#theFeedbackformFields .ZFtxtarea').parent().parent().before('<tr><td>'+langTexts["feedback_textfield"]+': </td><td><input type="text" value=""/></td></tr>');
	},
	
	/* function that should return the html to be displayed for options.  */
	zimplit_optionsview_html: function(){
		var theHtml =	'<div id="ZFeedbackSetup" style="line-height: 24px;">'+
								''+langTexts["feedback_email"]+': <input type="text" name="ZFeedbackEmail_name" id="ZFeedbackEmail"/><br/>'+
								
								''+langTexts["feedback_formfields"]+':'+
								'<div id="theFeedbackformFields" style="border-top: 1px dotted #919194;  clear:both; padding: 5px; margin: 2px 0 5px 0;">'+
									'<table>'+
									'<tr><td>'+langTexts["feedback_textfield"]+': </td><td><input type="text" value="Name"/></td></tr>'+
									'<tr><td>'+langTexts["feedback_textfield"]+': </td><td><input type="text" id="ZFemail" value="E-mail"/></td></tr>'+
									'<tr><td>'+langTexts["feedback_textarea"]+': </td><td><span class="ZFtxtarea"><input type="text"  value="'+langTexts["feedback_yourfeedback"]+'"/></span></td></tr>'+
									'<tr><td>'+langTexts["feedback_sendBtn"]+': </td><td><span class="ZFtxtSubmit"><input type="text"  value="'+langTexts["send"]+'"/></span></td></tr>'+
									'</table>'+
								'</div>'+
								'<button class="submitBtn" onclick="ZFeedbackModule.addField()">'+langTexts["feedback_addformfield"]+'</button>'+
							'</div>';
		return theHtml;
	},
	
	/* if options view html in zimplit is done, this function is initiated. can be used for additional post processing. */
	zimplit_optionsview_after: function(){
		if(!ZBlinker()){
			alert(langTexts["error_nocursor"]);
			ZremovePopup('#ZmodulePropsPop');
		}
	},
	
	
	
	/* save button clicked... then what happens ? */
	on_submit: function(){
		var theEmail = $('#ZFeedbackEmail').val();
		if(theEmail.indexOf('@')>-1){
			var pageLocation = document.location.href;
			var domainName = pageLocation.match(/^(https?:\/\/)?[^\/]+/gi);
			var userEmail = $('#ZFemail').val();
			var theFormHtml='<form action="zimplit.php?action=submitForm" method="post" class="ZDeletableEl"><input type="hidden" name="ZtheEmail" value="'+theEmail+'"/><table>';
			theFormHtml += '<input type="hidden" name="ZpageLocation" value ="'+pageLocation+'" />'+
										'<input type="hidden" name="ZuserEmail" value ="'+userEmail+'" />'+
										'<input type="hidden" name="ZdomainName" value ="'+domainName+'" />';
			var countr = 0;
			$('#theFeedbackformFields input').each(function(){
				if($(this).parent().hasClass('ZFtxtarea')){
					theFormHtml += '<tr><td>'+ $(this).val()+': </td><td><input type="hidden" name="name_'+countr+'" value="'+$(this).val()+'"/><textarea name="value_'+countr+'"></textarea></td></tr>';
				} else if($(this).parent().hasClass('ZFtxtSubmit')){
					theFormHtml += '<tr><td><input type="submit" value="'+$(this).val()+'"/></td><td>&nbsp;</td></tr>';
				}else {
					theFormHtml += '<tr><td>'+$(this).val()+': </td><td><input type="hidden" name="name_'+countr+'" value="'+$(this).val()+'"/><input name="value_'+countr+'"/></td></tr>';
				}
				countr++;
			});
			theFormHtml += '</table></form>';
			ZinsertAtBlinker(theFormHtml);
			ZremovePopup('#ZmodulePropsPop');
			ZStyleOverride()
		} else {
			alert(langTexts["feedback_email_notdefined"]);
			$('#ZFeedbackEmail').css('background','#FF9999').get(0).focus();
		}
	}
}
Zmodules.push(ZFeedbackModule);

var ZinsertMenu ={
	title: langTexts["menu_insert"],
	icon: ZimplitEditorLocation+"images/menuSmall.gif",
	guide_text: '<img src="'+ZimplitEditorLocation+'images/menustrucClosed.gif"  style="display:block; float:left; margin-right: 10px;" alt="" /> '+langTexts["menu_text"],
	changeMStyle: function (el,style){
		$('#ZmenuStylePicturesContainer .ZmenuStylePictures').each(function(){
			var src = $(this).attr('src');
			src = src.replace(/\_a\.gif/gi,'.gif');
			$(this).attr('src',src);
		});
		var thisSrc= $(el).attr('src');
		thisSrc = thisSrc.replace(/\.gif/gi,'_a.gif');
		$(el).attr('src',thisSrc);
		$('#theMenuType').val(style);
		ZinsertMenu.rewritePreview();
	},
	/* function that should return the html to be displayed for options.  */
	zimplit_optionsview_html: function(){
		var theHtml =	'<div style="clear:both; height:1px;"></div><b>Choose Menu style:</b>'+
									'<div style="border-top: 1px dotted #919194;  clear:both; padding: 5px; margin: 2px 0 5px 0;" id="ZmenuStylePicturesContainer">'+
										'<img src="'+ZimplitEditorLocation+'images/menu_horizontaldrop_a.gif" class="ZmenuStylePictures" alt=""  onclick="ZinsertMenu.changeMStyle(this,\'horizontalDropdown\')" />'+
										'<img src="'+ZimplitEditorLocation+'images/menu_verticaldrop.gif" class="ZmenuStylePictures" alt="" onclick="ZinsertMenu.changeMStyle(this,\'verticalDropdown\')" />'+
										'<input type="hidden" id="theMenuType" value="horizontalDropdown"/>'+
									'</div>'+
								'<b>Styles </b>(here You can configure the colours and borders of the menu):<br/>'+
								'<div style="border-top: 1px dotted #919194;  clear:both; padding: 5px; margin: 2px 0 5px 0;"><table id="ZMenuConfigStyles">'+
									'<tr><td>Add index page to menu: </td><td><input type="checkbox" name="ZInserFirstPage_name" id="ZInserFirstPage" checked="checked"></td></tr>'+
									'<tr><td>Text size: </td><td><input type="text" name="ZM_txt_size_name" id="ZM_txt_size" onchange="ZinsertMenu.rewritePreview();"  value="12px"></td></tr>'+
									'<tr><td>Text color: </td><td><input type="text" name="ZM_txt_col_name" id="ZM_txt_col" onchange="ZinsertMenu.rewritePreview();" value="#494949"></td></tr>'+
									'<tr><td>Hover color: </td><td><input type="text" name="ZM_hov_col_name" id="ZM_hov_col" onchange="ZinsertMenu.rewritePreview();" value="#ABCABC"></td></tr>'+
									'<tr><td>Backgound color: </td><td><input type="text" name="ZM_bg_col_name" id="ZM_bg_col" onchange="ZinsertMenu.rewritePreview();" value="#FFFFFF"></td></tr>'+
									'<tr><td>Border style: </td><td><input type="text" name="ZM_brd_name" id="ZM_brd" onchange="ZinsertMenu.rewritePreview();" value="1px solid #494949"></td></tr>'+
								'</table></div>'+
								'<b>Preview:</b>'+
								'<div id="ZMenuPreviewArea" style="border-top: 1px dotted #919194; clear:both; padding: 5px; margin: 2px 0 5px 0; background: #eeeeee; overflow: hidden;">'+
									
								'</div>'+
								'<div style="clear:both; height:1px;"></div>'+
	'';
		return theHtml;
	},
	
	rewritePreview: function(){
		var styleString = '';
		var txtSize = $('#ZM_txt_size').val();
		var txtColor = $('#ZM_txt_col').val();
		var hoverColor = $('#ZM_hov_col').val();
		var bgColor = $('#ZM_bg_col').val();
		var border= $('#ZM_brd').val();
		
		styleString += (txtSize == '')?'':'textsize:'+txtSize+';';
		styleString += (txtColor == '')?'':'linkcolor:'+txtColor+';';
		styleString += (txtColor == '')?'':'hovercolor:'+hoverColor+';';
		styleString += (bgColor == '')?'':'bgcolor:'+bgColor+';';
		styleString += (border == '')?'':'border:'+border;
		Zimplit.menus.insert.allMenu($('#ZMenuPreviewArea'),$('#theMenuType').val(),styleString);
		
	},
	
	/* if options view html in zimplit is done, this function is initiated. can be used for additional post processing. */
	zimplit_optionsview_after: function(){
		if(!ZBlinker()){
			alert(langTexts["error_nocursor"]);
			ZremovePopup('#ZmodulePropsPop');
		} else {
			ZinsertMenu.rewritePreview();
		}
	},
	
	
	
	/* save button clicked... then what happens ? */
	on_submit: function(){
		var styleString = '';
		var txtSize = $('#ZM_txt_size').val();
		var txtColor = $('#ZM_txt_col').val();
		var hoverColor = $('#ZM_hov_col').val();
		var bgColor = $('#ZM_bg_col').val();
		var border= $('#ZM_brd').val();
		
		styleString += (txtSize == '')?'':'textsize:'+txtSize+';';
		styleString += (txtColor == '')?'':'linkcolor:'+txtColor+';';
		styleString += (txtColor == '')?'':'hovercolor:'+hoverColor+';';
		styleString += (bgColor == '')?'':'bgcolor:'+bgColor+';';
		styleString += (border == '')?'':'border:'+border;
		Zimplit.blinker.insert('<div class="ZmenuWrapper" style="overflow:hidden;">'+Zimplit.menus.insert.allMenu(null,$('#theMenuType').val(),styleString)+'</div>','block');
		//ZinsertAtBlinker(Zimplit.menus.insert.allMenu(null,$('#theMenuType').val(),styleString));
		ZremovePopup('#ZmodulePropsPop');
		ZimplitPageOut.ZinsMenuL(); 
		ZMakeMenusNiceAndClickable();
	}
}
Zmodules.push(ZinsertMenu);






