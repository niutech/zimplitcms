<?php
include('zimplit-config.php');
$uid = $_GET['userID'];


if ($mustbeUid == $uid){

$version = $_GET['ver'];
if($_GET['scriptname']){$phpName=$_GET['scriptname'];} else {$phpName='';}
if($phpName == ''){$phpName ='zimplit.php';}
$templLoc = '';
if(isset($_GET['temploc'])){$templLoc =$_GET['temploc']; }
echo 'var templateLoc = "'.$templLoc.'";';
/* get language stuff */
if(isset($_GET['lang'])){
	$lang = $_GET['lang'];
} else {
	$lang = 'en';
}

include('languages/lang_'.$lang.'.php');
echo "langTexts =[];\n";
foreach($LangTexts as $key => $theText){
	echo "langTexts['".$key."'] ='".$theText."';\n";
}


?>

/*
Zimplit CMS is a Content Management System developed by
Welisa, Inc. Copyright (C) 2008 Welisa Inc zimplit@zimplit.org.

-- AVAILABLE LICENCE TYPES --

Zimplit CMS is available under three different licenses:

1) AGPL 3
You must keep a visible link to Zimplit Legal Notices, on every generated page. The required link to the Zimplit Legal Notices must be static, visible and readable, 
and the text in the Zimplit Legal Notices may not be altered.

2) Linkware / "Powered by Zimplit CMS" Link Requirement Licence
Same as AGPL, but instead of keeping a link to the Zimplit Legal Notices, you must place a static, visible and readable link to www.zimplit.org with the text or an
image stating "Powered by Zimplit CMS" on every generated page.

3) Commercial Licence
This license will allow you to remove the Zimplit Legal Notices/"Powered by Zimplit CMS" link at one specific domain. This license will also protect your modifications 
against the copyleft requirements in AGPL 3 and give access to registry in the user support forum.
Commercial licenses are available at www.zimplit.org/buy_commercial_license.html. 


You may change this LICENCE TYPES SECTION to relevant information, if you have purchased a commercial licence, 
but then the files may not be distributed to any other domain not covered by a commercial licence.

-- LICENCE TYPES SECTION END -

This copyright note must under no circumstances be removed from this file and any distribution of code covered by this licence.

For more information please visit http://www.zimplit.org
*/

/* last 08 04 09 */



/* just google analytics tracker */
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

//$.getScript('http://www.google.com/jsapi?key=ABQIAAAAhox8rLPQ1SDwoS5l973qnBTaTMz-yFeCWozVi0VhBDLUysy0uxSF3gklh0VQpajoYFImTjochkOgxg');


isintheZeditor = true; /* can be used by scripts to determine if page is viewed in editor or not */

/* browser detect */
var IE = document.all?true:false;
var FF =/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)?true:false;
var OPERA = (navigator.userAgent.indexOf("Opera")>-1)?true:false;
var OTHERBROWSER = (IE||FF)?false:true;

jQuery.fn.outerHTML = function(s) {
	return (s)
	? this.before(s).remove()
	: jQuery("<p>").append(this.eq(0).clone()).html();
}

if(window.navigator.platform.toLowerCase().indexOf('mac') != -1){
	var MAC = true;
} else {
	var MAC = false;
}

/* constants */
var ZEditableAreaClass = 'ZEditableArea'; /* the classname for editable area. if no elements with this class are present everything is editable */
var ZEmptyEditableAreaNotifierClass ="ZemptyEdAreaNotifier"; /* the classname for element that shows notification if no content present for an editable area */
var ZundoLevels = 40; /* number of times user can do undo */
var Zuneditables = '.mainMenu,.subMenu,.ZmenuDelBtn, .ZSwitchDirlink, .mainMenuLi, .allMenu'; /* elements that can not be edited. prefix . for class and # for id */
var ZMenuScriptbottom = 'var GlobZIndexfile = "'+GlobZIndexfile+'";';  /* indexfile definition in Zmenu.js */
var ZfunctionKeys = new Array(8,46,13,32,0,37,39,0);
var ZfunctionKeys2 = new Array(8,13,32,0,0);
if(IE){ var _blinker = '<IMG id="ZimplitBlinker" src="'+ZimplitEditorLocation+'images/blinker.gif" alt="" />';} else { var _blinker = '<img id="ZimplitBlinker" src="'+ZimplitEditorLocation+'images/blinker.gif" alt="" />'; }
if(IE){var _blinkerBegin = '<IMG id=ZimplitBlinker';} else { var _blinkerBegin = '<img id="ZimplitBlinker';}


/* here will be all editor texts in the future */
var Zmessages = {
	editableEmpty: langTexts["empty_editable"]
}

/* default values of important variables */
var ZeditableAreasMode = false; /* if true then only editable areas can be edited even if none present */
var ZimplitMenu = null;
var ZimplitPage = null;
var ZisSelection = false;
var ZrememberRange = null;
var rng = null;
var ZimageSelected = null;

/* most of this will be overwritten in Zsettings.js if present */
var ZmaxpicZoomW = 150;
var ZmaxpicZoomH = 150;
var ZmaxpicW = 800;
var ZmaxpicH = 800;
var ZimgHspace = 0;
var ZimgVspace = 0;

/* load settings file */
document.write('<script src="Zsettings.js?t='+Math.ceil(1000000*Math.random())+'" type="text/javascript"></script>');

/* html names do not allow all characters. so the list of characters to be replaced. feel free to add your own */
var ZcharReplaces = [
{'ch':/ /g,'repl':'_'},
{'ch':/\?/g,'repl':'_'},
{'ch':/\!/g,'repl':'_'},
{'ch':/õ/g,'repl':'o'},
{'ch':/ä/g,'repl':'a'},
{'ch':/ö/g,'repl':'o'},
{'ch':/ü/g,'repl':'u'},
{'ch':/\&/g,'repl':'and'},
{'ch':/’/g,'repl':''},
{'ch':/"/g,'repl':''},
{'ch':/</g,'repl':''},
{'ch':/>/g,'repl':''},
{'ch':/\\/g,'repl':''},
{'ch':/\//g,'repl':''},
{'ch':/а/g,'repl':'a'},
{'ch':/б/g,'repl':'b'},
{'ch':/в/g,'repl':'v'},
{'ch':/г/g,'repl':'g'},
{'ch':/д/g,'repl':'d'},
{'ch':/е/g,'repl':'e'},
{'ch':/ё/g,'repl':'e'},
{'ch':/ж/g,'repl':'sh'},
{'ch':/з/g,'repl':'z'},
{'ch':/и/g,'repl':'i'},
{'ch':/й/g,'repl':'i'},
{'ch':/к/g,'repl':'k'},
{'ch':/л/g,'repl':'l'},
{'ch':/м/g,'repl':'m'},
{'ch':/н/g,'repl':'n'},
{'ch':/о/g,'repl':'o'},
{'ch':/п/g,'repl':'p'},
{'ch':/р/g,'repl':'r'},
{'ch':/с/g,'repl':'s'},
{'ch':/т/g,'repl':'t'},
{'ch':/у/g,'repl':'y'},
{'ch':/ф/g,'repl':'f'},
{'ch':/х/g,'repl':'h'},
{'ch':/ц/g,'repl':'ts'},
{'ch':/ч/g,'repl':'ts'},
{'ch':/ш/g,'repl':'sh'},
{'ch':/щ/g,'repl':'stsh'},
{'ch':/ъ/g,'repl':''},
{'ch':/ы/g,'repl':'o'},
{'ch':/ь/g,'repl':''},
{'ch':/э/g,'repl':'e'},
{'ch':/ю/g,'repl':'ju'},
{'ch':/я/g,'repl':'ja'}
];
	 	 			
/* data arrays */
var ZUndoArray = [];
var ZRedoArray = [];
var Zmodules = []; /* the array of added  modules */

<?php
	include('zimplit_default_modules.js');
	echo "\n";
?>

/* images used in editor menus */
var ZLinksToImages = {
	imgLink : ZimplitEditorLocation +'images/link.gif',
	imgLink_a : ZimplitEditorLocation + 'images/link_a.gif',
	imgLink_h : ZimplitEditorLocation + 'images/link_h.gif',
	
	imgPicture : ZimplitEditorLocation + 'images/picture.gif',
	imgPicture_a : ZimplitEditorLocation+ 'images/picture_a.gif',
	imgPicture_h : ZimplitEditorLocation+ 'images/picture_h.gif',
	
	imgSrc: ZimplitEditorLocation+ 'images/source.gif',
	imgSrc_a: ZimplitEditorLocation+ 'images/source_a.gif',
	imgSrc_h: ZimplitEditorLocation+ 'images/source.gif',
	
	imgSave : ZimplitEditorLocation +'images/save.gif',
	imgSave_a : ZimplitEditorLocation + 'images/save_a.gif',
	imgSave_h : ZimplitEditorLocation + 'images/save_h.gif',
	
	imgUndo : ZimplitEditorLocation +'images/undo.gif',
	imgUndo_a : ZimplitEditorLocation + 'images/undo_a.gif',
	imgUndo_h : ZimplitEditorLocation + 'images/undo_h.gif',
	
	imgRedo : ZimplitEditorLocation +'images/redo.gif',
	imgRedo_a : ZimplitEditorLocation + 'images/redo_a.gif',
	imgRedo_h : ZimplitEditorLocation + 'images/redo_h.gif',
	
	imgBold : ZimplitEditorLocation +'images/bold.gif',
	imgBold_a : ZimplitEditorLocation + 'images/bold_a.gif',
	imgBold_h : ZimplitEditorLocation + 'images/bold_h.gif',
	
	imgItalic : ZimplitEditorLocation +'images/italic.gif',
	imgItalic_a : ZimplitEditorLocation + 'images/italic_a.gif',
	imgItalic_h : ZimplitEditorLocation + 'images/italic_h.gif',
	
	imgUnderline : ZimplitEditorLocation +'images/underline.gif',
	imgUnderline_a : ZimplitEditorLocation + 'images/underline_a.gif',
	imgUnderline_h : ZimplitEditorLocation + 'images/underline_h.gif',
	
	imgList : ZimplitEditorLocation +'images/list.gif',
	imgList_a : ZimplitEditorLocation + 'images/list_a.gif',
	imgList_h : ZimplitEditorLocation + 'images/list_h.gif',
	
	imgFontsize : ZimplitEditorLocation +'images/fontsize.gif',
	imgFontsize_a : ZimplitEditorLocation + 'images/fontsize_a.gif',
	imgFontsize_h : ZimplitEditorLocation + 'images/fontsize_h.gif',
	
	imgFontColor : ZimplitEditorLocation +'images/textcolor.gif',
	imgFontColor_a : ZimplitEditorLocation + 'images/textcolor_a.gif',
	imgFontColor_h : ZimplitEditorLocation + 'images/textcolor_h.gif',
	
	imgFontformat : ZimplitEditorLocation +'images/fontFormat.gif',
	imgFontformat_a : ZimplitEditorLocation + 'images/fontFormat.gif',
	imgFontformat_h : ZimplitEditorLocation + 'images/fontFormat_h.gif',
	
	imgNew : ZimplitEditorLocation +'images/newpage.gif',
	imgNew_a : ZimplitEditorLocation + 'images/newpage_a.gif',
	imgNew_h : ZimplitEditorLocation + 'images/newpage_h.gif',
	
	imgDel : ZimplitEditorLocation +'images/delete.gif',
	imgDel_a : ZimplitEditorLocation + 'images/delete_a.gif',
	imgDel_h : ZimplitEditorLocation + 'images/delete_h.gif',
	
	imgMenu : ZimplitEditorLocation +'images/menu.gif',
	imgMenu_a : ZimplitEditorLocation + 'images/menu_a.gif',
	imgMenu_h : ZimplitEditorLocation + 'images/menu.gif',
	
	imgBug : ZimplitEditorLocation +'images/bug.gif',
	imgBug_a : ZimplitEditorLocation + 'images/bug_a.gif',
	imgBug_h : ZimplitEditorLocation + 'images/bug.gif',
	
	imgSettings : ZimplitEditorLocation +'images/settings.gif',
	imgSettings_a : ZimplitEditorLocation + 'images/settings_a.gif',
	imgSettings_h : ZimplitEditorLocation + 'images/settings_h.gif',
	
	imgAdd : ZimplitEditorLocation +'images/add.gif',
	imgAdd_a : ZimplitEditorLocation + 'images/add_a.gif',
	imgAdd_h : ZimplitEditorLocation + 'images/add_h.gif',
	
	imgSmallTrash: ZimplitEditorLocation+ 'images/strash.gif'
}






/* main menu buttons hover and out functions */
function ZMBtnover(el,name){
	if($(el).attr('src').indexOf('_a.gif') == -1){ $(el).attr('src',eval('ZLinksToImages.'+name+'_h')); }/* if not active load hover image */
	ZmenuSubmenuPopRemove();
}
function ZMBtnout(el,name){
	if($(el).attr('src').indexOf('_a.gif') == -1){
		$(el).attr('src',eval('ZLinksToImages.'+name));
	}
}

// nonIEstuff
	function getRangeObject(selectionObject) {
			if (selectionObject.getRangeAt){
				return selectionObject.getRangeAt(0);
				
			}else { // Safari!
				var range = document.createRange();
				range.setStart(selectionObject.anchorNode,selectionObject.anchorOffset);
				range.setEnd(selectionObject.focusNode,selectionObject.focusOffset);
				return range;
			}
	}
	function cmsBlinkerNode(){
/* saf */	var newNode = ZimplitPage.createElement("img");
			newNode.setAttribute('src', ZimplitEditorLocation+ 'images/blinker.gif');
			newNode.setAttribute('id', 'ZimplitBlinker');
			return newNode;
	}
// nonIEstuff



function ZClearBlinker(){
	if(ZimplitPage.getElementById('ZimplitBlinker')) {$(ZimplitPage.getElementById('ZimplitBlinker')).remove();}
}

function ZBlinker(){
	return ZimplitPage.getElementById('ZimplitBlinker');
}

function ZinsertAtBlinker(theHtml){
	if(ZcheckBlinkerIsInEditable()&&ZBlinker()){
		$(ZBlinker()).before(theHtml);
	}
}


function splitByBlinker(contentSrc){
		var content = [];
		var blinkerSrc = (IE)?ZBlinker().outerHTML:$(ZBlinker()).outerHTML();
		if(contentSrc.indexOf(blinkerSrc) > -1){
			content = contentSrc.split(blinkerSrc);
		}
		return content;
}
/* FUNCTIONS OF EDITABE AREAS */
function ZIsInEditableArea(rangeobj){
	var editableanswer = false;
	ZredefineSelectionBorders(rangeobj);
	var edparents = (IE)?$(rangeobj.parentElement()).parents().add($(rangeobj.parentElement())):$(rangeobj.commonAncestorContainer).parents(); 
	edparents.each(function(){
		if($(this).hasClass(ZEditableAreaClass)){
			editableanswer = true;
		}
	}); 
	return editableanswer;
}



function ZcheckBlinkerIsInEditable(){
	var ZitIs = true;
	if(ZeditableAreasMode){
		ZitIs = false;
		var ZblinkerParents = $(ZBlinker()).parents();
		ZblinkerParents.each(function(){
			if($(this).hasClass(ZEditableAreaClass)){
				ZitIs = true;
			}
		}); 
	} 
	return ZitIs;
}

function ZcheckForEditableAreas(){
	if($(ZimplitPage).find('.'+ZEditableAreaClass).length > 0){
		ZeditableAreasMode = true;
	}
}

function ZredefineSelectionBorders(rangeobj){
	var editableselectanswer = false;
	var startIsInEditable = false;
	var endIsInEditable = false;
	var startel = null;
	var endel = null;
	if(!IE) {
		var edparentsStart = $(rangeobj.startContainer).parents().add(rangeobj.startContainer); 
		edparentsStart.each(function(){
			if($(this).hasClass(ZEditableAreaClass)){
				startIsInEditable = true;
				startel = this; 
			}
		}); 
		

		
		
		var edparentsEnd = $(rangeobj.endContainer).parents().add(rangeobj.endContainer); 
		edparentsEnd.each(function(){
			if($(this).hasClass(ZEditableAreaClass)){
				endIsInEditable = true;
				endel = this;
			}
		}); 
		
		if (startIsInEditable && endIsInEditable && (startel == endel)){
			ZisSelection = true;
		} else if (startIsInEditable && !endIsInEditable){
			var clone = rangeobj.cloneRange();
			//var l = (startel.childNodes.length ==0)?startel.length:startel.childNodes.length;
			var endNode = startel;
			var endOffset =startel.childNodes.length;
			clone.setEnd(endNode,endOffset); 
			ZimplitPageOut.window.getSelection().removeAllRanges();
			ZimplitPageOut.window.getSelection().addRange(clone);

			
		} else if (endIsInEditable && !startIsInEditable){
			var clone = rangeobj.cloneRange();
			clone.setStart(endel,0);
			ZimplitPageOut.window.getSelection().removeAllRanges();
			ZimplitPageOut.window.getSelection().addRange(clone);
		} else {
			ZimplitPageOut.window.getSelection().removeAllRanges();
		}
	} else {
/* vaja teha */
		var edparentsStartEnd = $(rangeobj.parentElement()).parents().add($(rangeobj.parentElement())); 
		edparentsStartEnd.each(function(){
			if($(this).hasClass(ZEditableAreaClass)){
				startIsInEditable = true;
				endIsInEditable = true;
			}
		}); 
		if (startIsInEditable && endIsInEditable){
			ZisSelection = true;
			
		} else {
			ZimplitPage.selection.empty();
			ZisSelection = false;
		}
	}
	
}

function ZnotifyEmptyEditableAreas(){
	if(ZBlinker()){
		if(ZBlinker().parentNode.className == ZEmptyEditableAreaNotifierClass){
			$(ZBlinker().parentNode).after(_blinker).remove();
		}
	}
	var Zempty = /[^\ ]/m;
	var Zedareas = $(ZimplitPage).find('.'+ZEditableAreaClass).each(function(){
		if($(this).find('img').length == 0 && (!Zempty.test($(this).text()) || this.innerHTML == '')){
			$(this).append(Zimplit.Sources.emptyEdArea());
		}
	});
	
}

function ZstartEditingEmptyEditableArea(){
	
}


function ZClickInEditable() {
	ZmenuSubmenuPopRemove();
	var sel = null; 
	if(IE){ rng = ZimplitPage.selection.createRange(); } else { sel = ZimplitPageOut.getSelection(); rng = getRangeObject(sel); }

	ZClearBlinker();
	
	 /* if click is somewhere not listed in Zuneditables */
	function isNotUneditabe(){
		var theAnswer = true;
		var uneditableEls = Zuneditables.split(',');
		for (var j in uneditableEls){
			if(IE){if ('.'+ rng.parentElement().className == uneditableEls[j]){theAnswer = false;}}
			if(!IE){if ('.' + rng.commonAncestorContainer.parentNode.className == uneditableEls[j]){theAnswer = false;}}
		}
		if(IE){if ($(rng.parentElement()).parents().filter(Zuneditables).length != 0){theAnswer = false;}}
		if(!IE){if ($(rng.commonAncestorContainer.parentNode).parents().filter(Zuneditables).length != 0){theAnswer = false;}}
		return theAnswer;
	}
	
	if(IE){
		if((ZeditableAreasMode && ZIsInEditableArea(rng)) || !ZeditableAreasMode){
			if (isNotUneditabe()){
				if(rng.parentElement().id != 'ZimplitRootBody'){
					if(rng.htmlText == ''){ // tavaline blinker
						rng.pasteHTML(_blinker);
						ZisSelection = false;
						ZimageSelected = null;
						$(ZimplitPage).find('#ZResizeImageBtn').remove();
						ZCurrentStyle();
						
					} else { // selektitud ala
						ZisSelection = true;
					}
					
				}
			} else {
				ZisSelection = false;
			}
		}
	} else{

		if((ZeditableAreasMode && ZIsInEditableArea(rng)) || !ZeditableAreasMode){
			if (isNotUneditabe()){
				if(sel == ''){ // tavaline blinker
					
					rng.insertNode(cmsBlinkerNode());
					
					ZisSelection = false;
					ZimageSelected = null;
					$(ZimplitPage).find('#ZResizeImageBtn').remove();
					ZCurrentStyle();
					if(OPERA){  
				
						
					}
				} else { // selektitud ala
					
					ZimageSelected = null;
					$(ZimplitPage).find('#ZResizeImageBtn').remove();
					ZCurrentStyle();
					ZisSelection = true;
				}
			}
		}
	}
	ZnotifyEmptyEditableAreas();
	
}
/* ENDOF FUNCTIONS OF EDITABE AREAS */


function ZSetRangeToBlinker(){
	if(IE){ rng = ZimplitPage.getElementById('ZimplitBlinker').createRange(); } else {  }
}

function ZisFunctionKey(theKey){ 
		var answer = false;
		for(var i=0; i < ZfunctionKeys.length; i++){
			if (theKey == ZfunctionKeys[i]){
				answer = true;
			}
		}
		return answer;
}

function ZisFunctionKey2(theKey){ 
		var answer = false;
		for(var i=0; i < ZfunctionKeys2.length; i++){
			if (theKey == ZfunctionKeys2[i]){
				answer = true;
			}
		}
		return answer;
}

function ZFFSetSelectionContent(theHtml){
	var sel = ZimplitPageOut.getSelection(); var rng = getRangeObject(sel);
	var innerContent = rng.extractContents();
	rng.insertNode(cmsBlinkerNode());
	$(ZimplitPage.getElementById('ZimplitBlinker')).before(theHtml);
}

function ZInsertChar(character){
	if(!ZisSelection) {
		$(ZimplitPage.getElementById('ZimplitBlinker')).before(String.fromCharCode(character));
	} else {
		ZsetUndo();
		if(IE){
			rng = ZimplitPage.selection.createRange();
			rng.pasteHTML(String.fromCharCode(character) + _blinker);
			rng.collapse(false);
		}
		if(!IE){
			ZFFSetSelectionContent(String.fromCharCode(character));
		}
		ZisSelection = false;
	}
}



function ZFunctionKey(theKey){
	switch (theKey){
		case 8:
			// delete
			if(!ZisSelection) {
				if(ZcheckBlinkerIsInEditable()){
					var blinkerspilt = Zimplit.blinker.split();
					
					if(blinkerspilt.src_before.charAt(blinkerspilt.src_before.length-1) == '>'){
						ZsetUndo();
						
						/*IE*/if((blinkerspilt.src_before.lastIndexOf('<IMG') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<BR') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<INPUT') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<LI') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<H1') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<H2') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<H3') == blinkerspilt.src_before.lastIndexOf('<'))|| (blinkerspilt.src_before.lastIndexOf('<A ') == blinkerspilt.src_before.lastIndexOf('<'))){
							blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.lastIndexOf('<')) + _blinker + blinkerspilt.src_after;
						/*FF*/} else if ((blinkerspilt.src_before.lastIndexOf('<img') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<br') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<input') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<li') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<h1') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<h2') == blinkerspilt.src_before.lastIndexOf('<')) || (blinkerspilt.src_before.lastIndexOf('<h3') == blinkerspilt.src_before.lastIndexOf('<'))|| (blinkerspilt.src_before.lastIndexOf('<a ') == blinkerspilt.src_before.lastIndexOf('<'))){
							blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.lastIndexOf('<')) + _blinker + blinkerspilt.src_after;
						} else if(ZimplitPage.getElementById('ZimplitBlinker').parentNode.innerHTML == ZimplitPage.getElementById('ZimplitBlinker').outerHTML){
							ZimplitPage.getElementById('ZimplitBlinker').parentNode.outerHTML = _blinker;
						} else {
							blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.lastIndexOf('<')) + _blinker + blinkerspilt.src_before.substring(blinkerspilt.src_before.lastIndexOf('<'), blinkerspilt.src_before.length) + blinkerspilt.src_after;
						}
						
					} else if ( blinkerspilt.src_before.charAt(blinkerspilt.src_before.length-1) == ';') {
						ZsetUndo();
						blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.lastIndexOf('&')) + _blinker + blinkerspilt.src_after;
					} else {
						blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.length-1) + _blinker + blinkerspilt.src_after;
					}
					
					if(!ZcheckBlinkerIsInEditable()){
						blinkerspilt.element.innerHTML = blinkerspilt.src_before + _blinker + blinkerspilt.src_after;
					}
					
					ZStyleOverride();
					ZMakeImagesActive();
					
				}
			} else {
				if(IE){
					rng = ZimplitPage.selection.createRange();
					rng.pasteHTML(_blinker);
					rng.collapse(false);
					ZisSelection = false;
				}
				if(!IE){
					ZFFSetSelectionContent('');
					ZisSelection = false;
					
				}
			}
			
		break;
		case 46:
			// delete
			
			if(!ZisSelection) {
				if(ZcheckBlinkerIsInEditable()){
					var blinkerspilt = Zimplit.blinker.split();
					if(blinkerspilt.src_after.charAt(0) == '<'){
						ZsetUndo();
							var s_a = blinkerspilt.src_after.toLowerCase();
							var s_end = blinkerspilt.src_after.indexOf('>');
						if((s_a.indexOf('<img')==0) || (s_a.indexOf('<br')==0) || (s_a.indexOf('<input')==0) || (s_a.indexOf('<h1')==0) || (s_a.indexOf('<h2')==0) || (s_a.indexOf('<li')==0) || (s_a.indexOf('<a')==0)){
							blinkerspilt.element.innerHTML = blinkerspilt.src_before + _blinker + blinkerspilt.src_after.substring(0,s_end);
						} else if(ZimplitPage.getElementById('ZimplitBlinker').parentNode.innerHTML == ZimplitPage.getElementById('ZimplitBlinker').outerHTML){
							ZimplitPage.getElementById('ZimplitBlinker').parentNode.outerHTML = _blinker;
						} else {
							blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring +blinkerspilt.src_after.substring(0,s_end) + _blinker + blinkerspilt.src_after.substring(s_end,blinkerspilt.src_after.length);
						}
					} else if ( blinkerspilt.src_after.charAt(0) == '&') {
						ZsetUndo();
						blinkerspilt.element.innerHTML = blinkerspilt.src_before + _blinker + blinkerspilt.src_after.substring(blinkerspilt.src_after.indexOf(';'),blinkerspilt.src_after.length);
					} else {
						
						blinkerspilt.element.innerHTML = blinkerspilt.src_before + _blinker + blinkerspilt.src_after.substring(1,blinkerspilt.src_after.length);
					}
					
					/*if(!ZcheckBlinkerIsInEditable()){
						blinkerspilt.element.innerHTML = blinkerspilt.src_before + _blinker + blinkerspilt.src_after;
					}*/
					
					ZStyleOverride();
					ZMakeImagesActive();
					
				}
			} else {
				if(IE){
					rng = ZimplitPage.selection.createRange();
					rng.pasteHTML(_blinker);
					rng.collapse(false);
					ZisSelection = false;
				}
				if(!IE){
					ZFFSetSelectionContent('');
					ZisSelection = false;	
				}
			}
			
		break;
		case 13:
			// enter
			ZsetUndo();
			if(!ZisSelection) { 
				if(Zimplit.listMode){
					var blinkerspilt = Zimplit.blinker.split();
					blinkerspilt.element.innerHTML = blinkerspilt.src_before+'</li><li>'+ _blinker + blinkerspilt.src_after;
				} else {
					$(ZimplitPage.getElementById('ZimplitBlinker')).before('<br>'); 
				}
			} else {
				if(!IE){
					ZFFSetSelectionContent('<br>');
					ZisSelection = false;
				}	
			}
		break;
		case 32:
			// space
			ZsetUndo();
			if(!ZisSelection) {
				var blinkerspilt = Zimplit.blinker.split();
				if ( blinkerspilt.src_before.charAt(blinkerspilt.src_before.length-1) == ' '){
					$(ZimplitPage.getElementById('ZimplitBlinker')).before('&nbsp;'); 
				} else {
					$(ZimplitPage.getElementById('ZimplitBlinker')).before(' '); 
				}
			} else {
				if(!IE){
					ZFFSetSelectionContent(' ');
					ZisSelection = false;
				}	
			}
		break;
		case 37:
			//left arrow
			if(ZcheckBlinkerIsInEditable()){
				var blinkerspilt = Zimplit.blinker.split();
				if(blinkerspilt.src_before.charAt(blinkerspilt.src_before.length-1) == '>'){
					blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.lastIndexOf('<')) + _blinker + blinkerspilt.src_before.substring(blinkerspilt.src_before.lastIndexOf('<'),blinkerspilt.src_before.length) + blinkerspilt.src_after;
				} else if ( blinkerspilt.src_before.charAt(blinkerspilt.src_before.length-1) == ';') {
					blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.lastIndexOf('&')) + _blinker + blinkerspilt.src_before.substring(blinkerspilt.src_before.lastIndexOf('&'),blinkerspilt.src_before.length) + blinkerspilt.src_after;
				} else {
					blinkerspilt.element.innerHTML = blinkerspilt.src_before.substring(0,blinkerspilt.src_before.length-1) + _blinker + blinkerspilt.src_before.substring(blinkerspilt.src_before.length-1,blinkerspilt.src_before.length) + blinkerspilt.src_after;
				}
				
				if(!ZcheckBlinkerIsInEditable()){
						blinkerspilt.element.innerHTML = blinkerspilt.src_before + _blinker + blinkerspilt.src_after;
					}
				ZStyleOverride();
				ZMakeImagesActive();
			}
		break;
		case 39:
			//right arrow
			if(ZcheckBlinkerIsInEditable()){
			
				var blinkerspilt = Zimplit.blinker.split();
				
			//	var theContent = $(ZimplitPage.body).html();
				//var ContentTemp = splitByBlinker(theContent);
				
				if(blinkerspilt.src_after.charAt(0) == '<'){
					blinkerspilt.element.innerHTML = blinkerspilt.src_before + blinkerspilt.src_after.substring(0,blinkerspilt.src_after.indexOf('>')+1) + _blinker + blinkerspilt.src_after.substring(blinkerspilt.src_after.indexOf('>')+1,blinkerspilt.src_after.length);
				} else if(blinkerspilt.src_after.charAt(0) == '&'){
					blinkerspilt.element.innerHTML = blinkerspilt.src_before + blinkerspilt.src_after.substring(0,blinkerspilt.src_after.indexOf(';')+1) + _blinker + blinkerspilt.src_after.substring(blinkerspilt.src_after.indexOf(';')+1,blinkerspilt.src_after.length);
				} else {
					blinkerspilt.element.innerHTML = blinkerspilt.src_before + blinkerspilt.src_after.substring(0,1) + _blinker + blinkerspilt.src_after.substring(1,blinkerspilt.src_after.length);
				}
				
				
				if(!ZcheckBlinkerIsInEditable()){
					blinkerspilt.element.innerHTML = blinkerspilt.src_before + _blinker + blinkerspilt.src_after;
				}
				ZStyleOverride();
				ZMakeImagesActive();
			}
		break;
		case 90: //undo	
			
				ZgetUndo();
				ZStyleOverride();
			
		break;
		case 86: // paste
			if(!ZisSelection) {
				ZsetUndo();
				if(IE){
					$(ZimplitPage.getElementById('ZimplitBlinker')).before(window.clipboardData.getData('text').replace(/\n/gi,'<br/>'));
				}
				if(!IE){
					ZFFPastePop();
				} 
			} else {
				ZsetUndo();
				
				if(IE){
					rng = ZimplitPage.selection.createRange();
					rng.text = window.clipboardData.getData('text').replace(/\n/gi,'<br/>');
					rng.collapse(false);
					ZisSelection = false;
				}
				if(!IE){
					ZFFPastePop();
				} 
				
			}
		break;
		case 67: //  copy
			if(ZisSelection) {
				rng = ZimplitPage.selection.createRange();
				rng.execCommand("Copy");
			}
		break;
			
	}
}

function ZCurrentStyle(){
	var ZStyles = [];
	ZStyles['link'] = false;
	ZStyles['linkEL'] = null;
	ZStyles['bold'] = false;
	ZStyles['italic'] = false;
	ZStyles['underline'] = false;
	ZStyles['list'] = false;
	
	if (($(ZimplitPage.getElementById('ZimplitBlinker')).parents('a').length > 0)){
		ZStyles['link'] = true;
		if(IE){ZStyles['linkEL'] = $(ZimplitPage.getElementById('ZimplitBlinker')).parents('a').get(0);}
		if(!IE){ZStyles['linkEL'] = $(ZimplitPage.getElementById('ZimplitBlinker')).parent('a');}
	}
	if(!IE){if(ZimageSelected){ if( $(ZimageSelected).parents('a').length > 0){
		ZStyles['link'] = true;
		ZStyles['linkEL'] = $(ZimageSelected).parent('a');
	}}}
	
	if (($(ZimplitPage.getElementById('ZimplitBlinker')).parents('b').length > 0)){
		ZStyles['bold'] = true;
	}
	
	if (($(ZimplitPage.getElementById('ZimplitBlinker')).parents('li').length > 0)){
		ZStyles['list'] = true;
		Zimplit.listMode = true;
	} else { Zimplit.listMode = false; }
	
	ZsetMenuStyles(ZStyles);
	return ZStyles;
}

function ZsetMenuStyles(stylesArr){
	if(stylesArr['link']){
		$($('#zimplitMenu .ZimgLink')).attr('src',ZLinksToImages.imgLink_a);
	} else {
		$($('#zimplitMenu .ZimgLink')).attr('src',ZLinksToImages.imgLink);
	}
	
	if(stylesArr['list']){
		$($('#zimplitMenu .ZimgList')).attr('src',ZLinksToImages.imgList_a);
	} else {
		$($('#zimplitMenu .ZimgList')).attr('src',ZLinksToImages.imgList);
	}
}

function ZFFGetBetweenSel(){
	$(ZimplitPage).find('#ZimplitSelStart, #ZimplitSelEnd').remove();
	
	var newNodeEnd = ZimplitPage.createElement("selend");
	newNodeEnd.setAttribute('id', 'ZimplitSelEnd');
	var sel1 = ZimplitPageOut.getSelection(); var rng1 = getRangeObject(sel1);
	var rangeEnd = rng1.cloneRange();
	rangeEnd.collapse(false);
	rangeEnd.insertNode(newNodeEnd);
	
	var newNodeStart = ZimplitPage.createElement("selstart");
	newNodeStart.setAttribute('id', 'ZimplitSelStart');
	var sel1 = ZimplitPageOut.getSelection(); var rng1 = getRangeObject(sel1);
	var rangeBegin = rng1.cloneRange();
	rangeBegin.collapse(true);
	rangeBegin.insertNode(newNodeStart);
	
	var theHtml = ZimplitPage.body.innerHTML;
	var Ztemp012 = theHtml.split('<selstart id="ZimplitSelStart"></selstart>');
	var Ztemp12 = Ztemp012[1].split('<selend id="ZimplitSelEnd"></selend>');
	var theAnswer = [];
	theAnswer[0] = Ztemp012[0];
	theAnswer[1] = Ztemp12[0];
	theAnswer[2] = Ztemp12[1];
	
	
	
	return theAnswer;
}



function ZDoComandSelection(theCommand,param){
	
	function ZFFDoTheTag(Ztag){
		var sel2 = ZimplitPageOut.getSelection(); var rng2 = getRangeObject(sel2);
		var startRangeNode = rng2.startContainer;
		var endRangeNode = rng2.endContainer;
		
		var startIsBold = false;
		if (($(startRangeNode).parents(Ztag).length > 0)){
			startIsBold = true;
		}
		var endIsBold = false;
		if (($(endRangeNode).parents(Ztag).length > 0)){
			endIsBold = true;
		}
		var theHTML = ZFFGetBetweenSel();
		
		if(startIsBold && endIsBold){
			var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
			var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
			theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
			ZimplitPage.body.innerHTML = theHTML[0] +'</'+Ztag+'>'+ theHTML[1] +'<'+Ztag+'>'+ theHTML[2];
		} else if (startIsBold){
			var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
			var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
			theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
			
			var thetagRegexp1 = new RegExp("<"+Ztag+"><\\\/"+Ztag+">","g");
			var thetagRegexp2 = new RegExp("<"+Ztag+">(\\s)+<\\\/"+Ztag+">","g");
			var theHtmlContent = theHTML[1].replace(/(<[^>]+>)/g,'</'+Ztag+'>'+'$1'+'<'+Ztag+'>').replace(thetagRegexp1,'').replace(thetagRegexp2,'');
			ZimplitPage.body.innerHTML = theHTML[0] +''+ theHtmlContent +'</'+Ztag+'>'+ theHTML[2];
		} else if (endIsBold){
			var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
			var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
			theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
			
			var thetagRegexp1 = new RegExp("<"+Ztag+"><\\\/"+Ztag+">","g");
			var thetagRegexp2 = new RegExp("<"+Ztag+">(\\s)+<\\\/"+Ztag+">","g");
			var theHtmlContent = theHTML[1].replace(/(<[^>]+>)/g,'</'+Ztag+'>'+'$1'+'<'+Ztag+'>').replace(thetagRegexp1,'').replace(thetagRegexp2,'');
			ZimplitPage.body.innerHTML = theHTML[0] +'<'+Ztag+'>'+ theHtmlContent +''+ theHTML[2];
		} else {
			var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
			var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
			theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
			
			var thetagRegexp1 = new RegExp("<"+Ztag+"><\\\/"+Ztag+">","g");
			var thetagRegexp2 = new RegExp("<"+Ztag+">(\\s)+<\\\/"+Ztag+">","g");
			var theHtmlContent = theHTML[1].replace(/(<[^>]+>)/g,'</'+Ztag+'>'+'$1'+'<'+Ztag+'>').replace(thetagRegexp1,'').replace(thetagRegexp2,'');
			ZimplitPage.body.innerHTML = theHTML[0] +'<'+Ztag+'>'+ theHtmlContent +'</'+Ztag+'>'+ theHTML[2];
		}
	}
	
	ZsetUndo();
	if(IE){
		var rng = ZimplitPage.selection.createRange();
		rng.execCommand(theCommand,false, param);
	}
	if(!IE){
		if(theCommand == 'bold'){
			
			if(ZCurrentStyle()['bold']){
				if(!ZisSelection){
					function removeBold(el){
						if(el.tagName.toLowerCase()== "b"){
							$(el).replaceWith(el.innerHTML);
						}
						if(el != ZimplitPage.body){
							removeBold(el.parentNode);
						}
					}
					removeBold(ZimplitPage.getElementById('ZimplitBlinker').parentNode);
				}
			} else {
				if(ZisSelection){
					ZFFDoTheTag('b');
				}
			}
		}
		
		if(theCommand == 'italic'){
			if(ZCurrentStyle()['italic']){
				if(!ZisSelection){
					function removeBold(el){
						if(el.tagName.toLowerCase()== "i"){
							$(el).replaceWith(el.innerHTML);
						}
						if(el != ZimplitPage.body){
							removeBold(el.parentNode);
						}
					}
					removeBold(ZimplitPage.getElementById('ZimplitBlinker').parentNode);
				}
			} else {
				if(ZisSelection){
					ZFFDoTheTag('i');
				}
			}
		}
		
		if(theCommand == 'underline'){
			if(ZCurrentStyle()['underline']){
				if(!ZisSelection){
					function removeBold(el){
						if(el.tagName.toLowerCase()== "u"){
							$(el).replaceWith(el.innerHTML);
						}
						if(el != ZimplitPage.body){
							removeBold(el.parentNode);
						}
					}
					removeBold(ZimplitPage.getElementById('ZimplitBlinker').parentNode);
				}
			} else {
				if(ZisSelection){
					ZFFDoTheTag('u');
				}
			}
		}
		
		ZMakeImagesActive();
	}
}

function prepareForSave(){
	ZClearBlinker();
	/* remove stupid skype elements */
	$(ZimplitPage).find('.skype_tb_injection').each(function(){
		var thephonenr = $(this).attr('context');
		$(this).before(thephonenr).remove();
	});
	$(ZimplitPage.documentElement.getElementsByTagName('head')[0]).find('#injection_graph_css').remove();
	
	/* clear google search content */
	if(Zimplit.getId(Zimplit.objectNames.googleSearchScript,'page')){
		Zimplit.getId(Zimplit.objectNames.googleSearchScript,'page').innerHTML= Zimplit.Sources.googleSearchScript();
	}
	$(ZimplitPage).find('.'+Zimplit.objectNames.googleSearchBox).html('');
	$(ZimplitPage).find('.'+Zimplit.objectNames.googleMapBox).html('');
	
	
	$(ZimplitPage.documentElement.getElementsByTagName('head')[0]).find('style').each(function (){
		if (this.innerHTML == '.ZGoogleSearchBox .gsc-control { width : 100%; }'){
			$(this).remove();
		}
	});	
	/* firebug ads some stuff user does not want to see probably */
	$(ZimplitPage).find('#_firebugConsole').remove();
	$(ZimplitPage).find('#_firebugConsole').remove();
	
	$(ZimplitPage).find('.subMenu2andUp').html('');
	$(ZimplitPage).find('.ZmenuDelBtn').remove();
	$(ZimplitPage).find('#ZResizeImageBtn').remove();
	$(ZimplitPage).find('.ZelementToBeDeleted').remove();
	$(ZimplitPage).find('.'+ZEmptyEditableAreaNotifierClass).remove();
	
	$(ZimplitPage).find('#ZinsertedImage').removeAttr('id');
	
	$(ZimplitPage).find('.ZSwitchDirlink a').each(function(d){
		$(this).attr('href', $(this).attr('href').substring(0, $(this).attr('href').lastIndexOf('/')+1));
	});
	
// return all masked links
	$(ZimplitPage.body).find('a[oldhref]').each(function(d){
		$(this).attr('href',$(this).attr('oldhref')).removeAttr('oldhref').removeClass('ZMaskedLink');
	});
	
	
	if(ZimplitPage.getElementById('ZimplitStyleOverride')) {$(ZimplitPage.getElementById('ZimplitStyleOverride')).remove();}
}


function ZparseSaveContent(){
 	function hasNotZMenuJs(theHTML){
		var theAnswer = true;
		if(IE){
			if((theHTML.indexOf('<SCRIPT src="Zmenu.js') != -1) || (theHTML.indexOf('<SCRIPT type=text/javascript src="Zmenu.js') != -1)){
				theAnswer = false;
			}
		} else if (!IE){
			if(theHTML.indexOf('<script src="Zmenu.js') != -1){
				theAnswer = false;
			}
		}
		return theAnswer;
	}
	prepareForSave();
	
	/* menu links must be rewritten to standard. not redirecting in zimplit */
	var menulinks = $(ZimplitPage).find('.mainMenu a').add($(ZimplitPage).find('.mainMenuLi a')).add($(ZimplitPage).find('.allMenu a')).add($(ZimplitPage).find('.subMenu a')).add($(ZimplitPage).find('.subMenu2 a'));
	menulinks.each(function(){
		var phpNameReg = ZphpName.replace(/\./gi,'\\.');
		var regMenuPhp1 = new RegExp(phpNameReg+"\\?action\\=load\\&amp\\;file\\=",'gi');
		var regMenuPhp2 = new RegExp(phpNameReg+"\\?action\\=load\\&file\\=",'gi');
		$(this).attr('href',$(this).attr('href').replace(regMenuPhp1,"").replace(regMenuPhp2,""));
	});
	
	var preContent = $(ZimplitPage.documentElement).html();
	
	if (hasNotZMenuJs(preContent)){preContent = preContent.replace(/\<\/body\>/gi, '<script src="'+ZimplitEditorLocation+'jquery.js" type="text/javascript"></script><script src="'+ZimplitEditorLocation+'ZimgZoomer.js" type="text/javascript"></script><script src="Zmenu.js?t='+Math.ceil(1000000*Math.random())+'" type="text/javascript"></script><script src="'+ZimplitEditorLocation+'ZZMenu.js" type="text/javascript"></script></body>');}
	preContent = preContent.replace(/(charset=)[^(\"|\'|\>)]+/i, '$1utf-8');
	preContent = preContent.replace(/zsrctemp\=/i, 'src=');
	
	preContent = preContent.replace(/(jQuery(\d+)=)[(\"|\')(\d+)(\"|\')]+/gi, '');
	preContent = preContent.replace(/<br>/gi, '<br/>');
	preContent = preContent.replace(/<BR>/gi, '<BR/>');
	
	preContent = preContent.replace(/(<meta [^>]+)>(?!<\/meta>)/g, '$1></meta>');
	preContent = preContent.replace(/(<link [^>]+)>(?!<\/link>)/g, '$1></link>');
	preContent = preContent.replace(/(<hr [^>]+)(?!\/)>(?!<\/hr>)/g, '$1 />');
	preContent = preContent.replace(/(<img [^>]+)(?!\/)>(?!<\/img>)/g, '$1 />');
	
	preContent = preContent.replace(/(<META [^>]+)>(?!<\/META>)/g, '$1></META>');
	preContent = preContent.replace(/(<LINK [^>]+)>(?!<\/LINK>)/g, '$1></LINK>');
	preContent = preContent.replace(/(<HR [^(>]+)(?!\/)>(?!<\/HR>)/g, '$1 />');
	preContent = preContent.replace(/(<IMG [^>]+)(?!\/)>(?!<\/IMG>)/g, '$1 />');

	// google search stuff
	preContent = preContent.replace(/<SPAN id\=ZGoogleSearchScript style\=\"DISPLAY\: none\"[^>]*><\/SPAN>/g, '<SPAN id=ZGoogleSearchScript style="DISPLAY: none">'+Zimplit.Sources.googleSearchScript()+'</SPAN>');
	if(IE){
		preContent = preContent.replace(/<SPAN class\=ZreplaceWithGSBoxScript theid\=\"([^\"]+)\" pagesrc="([^\"]+)"><\/SPAN>/g, '<script  type="text/javascript">ZLoadGSearch(document.getElementById("$1"),"$2");</script>');
		preContent = preContent.replace(/<SPAN class\=ZreplaceWithGSBoxScript pagesrc="([^\"]+)" theid\=\"([^\"]+)\"><\/SPAN>/g, '<script  type="text/javascript">ZLoadGSearch(document.getElementById("$2"),"$1");</script>');
		preContent = preContent.replace(/<SPAN class\=ZreplaceWithGMBoxScript text\=\"([^\"]+)\" zoom\=\"([^\"]+)\" pointy\=\"([^\"]+)\" pointx\=\"([^\"]+)\" theid="([^\"]+)"><\/SPAN>/g, '<script  type="text/javascript">ZLoadGMap(document.getElementById("$5"),$4,$3,$2,"$1");</script>');
	}
	preContent = preContent.replace(/<link href\=\"http:\/\/www.google.com\/uds\/api\/search\/1\.0\/[^\/]+\/default.css\" type\=\"text\/css\" rel\=\"stylesheet\"><\/link>/g, '');
	
	preContent = preContent.replace(/<style type\="text\/css">\@media print\{\.gmnoprint\{display\:none\}\}\@media screen\{\.gmnoscreen\{display\:none\}\}<\/style>/g,'');
	preContent = preContent.replace(/<script src\="http\:\/\/maps\.gstatic\.com\/[^>]+><\/script>/gi, '');
	
	if(IE){
		preContent = preContent.replace(/<SCRIPT src="http:\/\/www.google-analytics.com\/ga.js" type=text\/javascript><\/SCRIPT>/gi, '');
	} else if (!IE){
		preContent = preContent.replace(/<script src="http:\/\/www.google-analytics.com\/ga.js" type="text\/javascript"><\/script>/gi, '');
	}
	
	/* skype sucks for real.  makes zimplit refresh */
	if(!IE){
		preContent = preContent.replace(/<script charset="utf-8" id="injection_graph_func" src="chrome:\/\/skype_ff_toolbar_win\/content\/injection_graph_func.js"><\/script>/gi, '');
		preContent = preContent.replace(/<script id="_nameHighlight_injection"><\/script><link class="skype_name_highlight_style" href="chrome:\/\/skype_ff_toolbar_win\/content\/injection_nh_graph.css" type="text\/css" rel="stylesheet" charset="utf-8" id="_injection_graph_nh_css">/gi, '');
	}
	
	var theContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">' + preContent + '</html>';
	return theContent;
	
}

function ZgetCsses(htmlContent){
	var csses2 = [];
	var csses = htmlContent.match(/(href=("|'))[^("|')]+\.css/gi);
	if(csses.lenght == 1){
		csses2.push(csses.toString().replace(/href=\"/gi,""));
	} else {
		for(var i = 0; i < csses.length; i++){
			csses2.push(csses[i].toString().replace(/href=\"/gi,""));
		}
	}
	return csses2;
}


function ZSaveContent(){
	if(Zimplit.currentPage()== false){
	
			alert(langTexts["error_cannotsave"]);
	}else {
		var theContent = ZparseSaveContent();
		var theSaveFile = Zimplit.currentPage(); /*ZimplitPage.location.href.substring(ZimplitPage.location.href.lastIndexOf('/')+1,ZimplitPage.location.href.length);*/
		theContent = encodeURIComponent(theContent);
		theContent = theContent.replace(/\'/gi,"%27");
		$.post(ZphpName+"?action=saveE&file=" + theSaveFile , { html: theContent},
		function(data){
			if(data == ""){
				window.location.reload();
			} else {
				alert(data);
			}
		});
	}
}

// settings pop
	function ZsettingsPop(){
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$(document.body).prepend(Zimplit.Sources.ZSettingsPopup);
			$("#ZMainOverlay").show();
			$('#ZSettingsPopup').css('top', (($(window).height()/2)-($('#ZSettingsPopup').height()/2))+$(window).scrollTop() + 'px');
			$('#ZSettingsPopup').css('left', (($(window).width()/2)-($('#ZSettingsPopup').width()/2)) + 'px');
			$('#ZSettingsPopup').draggable();
	}
	
	function ZimgSettingsPop(){
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$(document.body).prepend(Zimplit.Sources.imgSettingsPop());
			$("#ZMainOverlay").show();
			$('#ZimgSettingsPopup').css('top', (($(window).height()/2)-($('#ZimgSettingsPopup').height()/2))+$(window).scrollTop() + 'px');
			$('#ZimgSettingsPopup').css('left', (($(window).width()/2)-($('#ZimgSettingsPopup').width()/2)) + 'px');
			$('#ZimgSettingsPopup').draggable();
	}
	
	function ZchangePicSettings(){	
		$.post(ZphpName+"?action=load1&file=Zsettings.js", { empty: 'empty'},function(dataBack){
			var PicZoomW = /(ZmaxpicZoomW = ")[^"]+(")/gi;
			var theContent = dataBack.replace(PicZoomW,"$1"+$('#ZimgSettingsPopupSmallX').val()+"$2");
			var PicZoomH = /(ZmaxpicZoomH = ")[^"]+(")/gi;
			theContent = theContent.replace(PicZoomH,"$1"+$('#ZimgSettingsPopupSmallY').val()+"$2");
			var PicW = /(ZmaxpicW = ")[^"]+(")/gi;
			theContent = theContent.replace(PicW,"$1"+$('#ZimgSettingsPopupLargeX').val()+"$2");
			var PicH = /(ZmaxpicH = ")[^"]+(")/gi;
			theContent = theContent.replace(PicH,"$1"+$('#ZimgSettingsPopupLargeY').val()+"$2");
			$.post(ZphpName+"?action=saveE&file=Zsettings.js", { html: encodeURIComponent(theContent)}, function(data2){
						setTimeout('document.location.reload()',500);
			});
		});
	}
	
	
	

// __settings pop functions

// img functions
	function ZimgPop(){
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		if(rng != null){
			$(document.body).prepend(Zimplit.Sources.imgPopup());
			$("#ZMainOverlay").show();
			$('#ZimgPopup').css('top', (($(window).height()/2)-($('#ZimgPopup').height()/2))+$(window).scrollTop() + 'px');
			$('#ZimgPopup').css('left', (($(window).width()/2)-($('#ZimgPopup').width()/2)) + 'px');
			$('#ZimgPopup').draggable();
			
			$('#ZimageForm').ajaxForm(function(data) { 
				if(data == 1){
					ZsetUndo();
					var imgAddr = $('#ZImageUploadAddr').val();
					var imgName =  imgAddr.substring(imgAddr.lastIndexOf('\\')+1 ,imgAddr.length);
					if(ZBlinker()){
						/* check if image is jpg, jpeg, png and if is zooming function then go for generated smaller thumbnail */
						if($('#ZtheImgPropsZoom').attr('checked') && (GDsupport == '1') && ((imgName.toLowerCase().indexOf('.jpg') != -1) || (imgName.toLowerCase().indexOf('.jpeg') != -1) ||(imgName.toLowerCase().indexOf('.png') != -1))){
							var newImageName = imgName.replace(/\./gi, '_thumb.'); // problem if multiple punctuations in file name. //
							if($(ZBlinker()).parents('a').length > 0){
								$(ZBlinker()).parents('a').eq(0).after('<img src="Z-pictures/'+newImageName+'" id="ZinsertedImage" alt="" />');
							} else {
								$(ZBlinker()).before('<img src="Z-pictures/'+newImageName+'" id="ZinsertedImage" alt="" />');
							}
						} else {						
							$(ZBlinker()).before('<img src="Z-pictures/'+imgName+'" id="ZinsertedImage" alt="" />');
						}
						ZClearBlinker();
						ZimplitPage.getElementById('ZinsertedImage').onclick = function(){  
							ZClearBlinker();
							$(this).after(_blinker);
							ZimageSelected = this;
						}
						
						function ZimgDimesnions(theimg){
							var zReturn = [];
							var zconst = 0;
							if (theimg.width() > theimg.height()){
								zconst = theimg.width()/ZmaxpicZoomW;
								zReturn.push(Math.ceil(theimg.width()/zconst));
								zReturn.push(Math.ceil(theimg.height()/zconst));
							} else {
								zconst = theimg.height()/ZmaxpicZoomH;
								zReturn.push(Math.ceil(theimg.width()/zconst));
								zReturn.push(Math.ceil(theimg.height()/zconst));
							}
							return zReturn;
						}
						
						
						
						
						if ($('#ZtheImgPropsAlignment').val() == 'Left'){
							$(ZimplitPage.getElementById('ZinsertedImage')).attr('align','left');	
						} else if ($('#ZtheImgPropsAlignment').val() == 'Right'){
							$(ZimplitPage.getElementById('ZinsertedImage')).attr('align','right');
							
						}
						
						
						
						ZimplitPage.getElementById('ZinsertedImage').onload = function(){
							function ZdoTheLastStuff(){
								if($('#ZtheImgPropsZoom').attr('checked')){
									var imgDim = ZimgDimesnions($(ZimplitPage.getElementById('ZinsertedImage')));
									$(ZimplitPage.getElementById('ZinsertedImage')).attr('width',imgDim[0]+'').attr('height',imgDim[1]+'');
									
									if(IE){ZimplitPage.getElementById('ZinsertedImage').outerHTML = '<a href="javascript: void(0);" class="ZclassOfZoomableImage" style="border:0px;" onclick="ZClickZoomImg(this);">'+ZimplitPage.getElementById('ZinsertedImage').outerHTML +'</a>&nbsp;';}
									if(!IE){$(ZimplitPage.getElementById('ZinsertedImage')).wrap("<a href=\"javascript: void(0);\" class=\"ZclassOfZoomableImage\" style=\"border:0px;\" onclick=\"ZClickZoomImg(this);\"></a>");}
								} else {
									$(ZimplitPage.getElementById('ZinsertedImage')).attr('hspace',ZimgHspace).attr('vspace',ZimgVspace);
								}
								
								$(ZimplitPage.getElementById('ZinsertedImage')).removeAttr('id');
								ZremovePopup('#ZimgPopup');
								ZMakeImagesActive()
							}
							
							ZdoTheLastStuff();
						};
						
					} else {
						alert(langTexts["error_nocursor"]);
					}
				} else {
					alert(data);
				}
	        });
		} else {
			alert(langTexts["error_nocursor"]);
		}
	}
	
	function ZimgPopPropOver(el, image){
		el.src = ZimplitEditorLocation+'images/' + image;
	}
	
	function ZimgPopPropOut(el, image){
		if (el.className == 'selected'){
			
		} else {
			el.src = ZimplitEditorLocation+'images/' + image;
		}
	}
	
	function ZChangeImgAlignment(el, alignment){
		$(el).parent().find('img').removeClass('selected').each(function(d){
			$(this).attr('src',$(this).attr('src').replace(/_a/gi,''));
		});
		$(el).find('img').addClass('selected').attr('src',$(el).find('img').attr('src').replace(/.gif/gi,'_a.gif'));
		$('#ZtheImgPropsAlignment').val(alignment);
		
	}

	function ZInsertImage(){

		return false;
	}
// img functions  theend

// src functions
	function ZSrcPop(){
		if(Zimplit.currentPage()== false){
			alert(langTexts["error_cannotshowsource"]);
		}else {
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$("#ZMainOverlay").show();
			var currentFile = Zimplit.currentPage();/*ZimplitPage.location.href.substring(ZimplitPage.location.href.lastIndexOf('/')+1,ZimplitPage.location.href.length);*/
			$(document.body).prepend(Zimplit.Sources.srcPop);
			$('#ZViewSrc').css('top', (($(window).height()/2)-($('#ZViewSrc').height()/2))+$(window).scrollTop() + 'px');
			$('#ZViewSrc').css('left', (($(window).width()/2)-($('#ZViewSrc').width()/2)) + 'px');
			$('#ZViewSrc').draggable();
			var htmlContent = ZparseSaveContent();
			ZInitEditorEls();
			var cssSrcs = ZgetCsses(htmlContent);
			$('#ZtheSourceW').val(htmlContent);
			$('#ZtheSourceF').val(currentFile);
			
			var headerHtml = '<a href="javascript:void(0);" onclick="ZgetSource(\'html\')">HTML</a>';
			for(var i in cssSrcs){
				headerHtml += '<a href="javascript:void(0);" onclick="ZgetSource(\''+cssSrcs[i]+'\')">'+cssSrcs[i]+'</a>';
			}
			$('#ZtheSourceH').html(headerHtml);
		}
		
	}
	
	function ZgetSource(thesrc){
		if(thesrc == 'html'){
			var srcCode = ZparseSaveContent();
			ZInitEditorEls();
			$('#ZtheSourceW').val(srcCode);
			var currentFile = Zimplit.currentPage(); //ZimplitPage.location.href.substring(ZimplitPage.location.href.lastIndexOf('/')+1,ZimplitPage.location.href.length);
			$('#ZtheSourceF').val(currentFile);
		} else {
			$.post(ZphpName+"?action=load1&file="+thesrc+"", { empty: 'empty'},
			function(dataBack){

				$('#ZtheSourceW').val(dataBack);
				$('#ZtheSourceF').val(thesrc);
			});
		}
		
	}
	
	function ZsaveSrc(theSrc,theFile){
		$.post(ZphpName+"?action=saveE&file="+theFile+"", { html: encodeURIComponent(theSrc).replace(/\'/gi,"%27") },
			function(dataBack){
				if(dataBack == ''){
					window.location.reload();
				} else {
					alert(dataBack);
				}
			});
	}

// src functions theend

// link functions 
	function ZlinkStartFunction(){
		var Zhref="http://";
		if(ZCurrentStyle()['link']){
			Zhref= $(ZCurrentStyle()['linkEL']).attr('oldhref');
		}
		$('#ZlinkAddr').val(Zhref);
		$('#ZlinkAddr').focus();
		if(IE){ZrememberRange = rng.duplicate();}
		if(!IE){ var selx = ZimplitPageOut.getSelection(); var rngx = getRangeObject(selx); ZrememberRange= rngx.cloneRange();  }
		
	}
	
	function ZlinkPop(){
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		var Zhref="http://";
		if(ZCurrentStyle()['link']){
			Zhref= $(ZCurrentStyle()['linkEL']).attr('oldhref');
		}
		$(document.body).prepend(Zimplit.Sources.linkPopup);
		$('#ZlinkPopup').css('top', $('#zimplitMenu').offset().top + 40 + 'px');
		$('#ZlinkPopup').css('left', $('#zimplitMenu').offset().left + 'px');
		$('#ZlinkPopup').draggable();
		$('#ZlinkAddr').val(Zhref);
		$('#ZlinkAddr').focus();
		if(IE){ZrememberRange = rng.duplicate();}
		if(!IE){ var selx = ZimplitPageOut.getSelection(); var rngx = getRangeObject(selx); ZrememberRange= rngx.cloneRange();  }
	}

	function ZInsertLink(linkAddr){
		ZsetUndo();
		if(ZCurrentStyle()['link']){
			if(linkAddr != ''){
				$(ZCurrentStyle()['linkEL']).attr('oldhref',linkAddr);
			} else {
				$(ZCurrentStyle()['linkEL']).replaceWith($(ZCurrentStyle()['linkEL']).html());
			}
			var temp= ZCurrentStyle();
			ZInitEditorEls();
		} else {
			if(IE){
				if(ZimageSelected){
					ZimageSelected.outerHTML = "<a href=\""+linkAddr+"\">"+ZimageSelected.outerHTML+"</a>";
					
					//ZimageSelected = null;
					var temp= ZCurrentStyle();
					ZInitEditorEls();
				} else if(ZrememberRange.htmlText != ""){
					var theHtml = ZgetSelectionContent(ZrememberRange);
					var thelinkRegexp1 = new RegExp("<a href=\""+linkAddr+"\" ><\\\/a>","g");
					var thelinkRegexp2 = new RegExp("<a href=\""+linkAddr+"\" >(\\s)+<\\\/a>","g");
					var theHtmlContent = theHtml.replace(/(<[^>]+>)/g,'</a>'+'$1'+'<a href="'+linkAddr+'" >').replace(thelinkRegexp1,'').replace(thelinkRegexp2,'');
					ZreplaceSelectionContent('<a href="'+linkAddr+'">' +theHtmlContent+ '</a>');
					ZInitEditorEls();
				}
			} 
			if(!IE){
				if(ZimageSelected){
					$(ZimageSelected).wrap("<a href=\""+linkAddr+"\"></a>");
					
					//ZimageSelected = null;
					var temp= ZCurrentStyle();
					ZInitEditorEls();
				} else {
					var tempHtml = ZFFGetBetweenSel();
					var theHtml = tempHtml[1];
					var thelinkRegexp1 = new RegExp("<a href=\""+linkAddr+"\" ><\\\/a>","g");
					var thelinkRegexp2 = new RegExp("<a href=\""+linkAddr+"\" >(\\s)+<\\\/a>","g");
					var theHtmlContent = theHtml.replace(/(<[^>]+>)/g,'</a>'+'$1'+'<a href="'+linkAddr+'" >').replace(thelinkRegexp1,'').replace(thelinkRegexp2,'');
					ZimplitPage.body.innerHTML = tempHtml[0] + '<a href="'+linkAddr+'">' +theHtmlContent+ '</a>' + tempHtml[2];
					ZInitEditorEls();
				}
			}
		}
		
		
		ZmenuSubmenuPopRemove();
		return false;
	}
// link functions theend

// better replacement functions
	function ZgetSelectionContent(range){
		if(IE){var rangeBegin = range.duplicate();
			var rangeEnd = range.duplicate();
			rangeBegin.collapse(true);
			rangeEnd.collapse(false);
			rangeEnd.pasteHTML('<span id=ZimplitTempReplaceEnd></span>');
			rangeBegin.pasteHTML('<span id=ZimplitTempReplaceBegin></span>');
		}
		
		if(!IE){
		
		}
		var tempHtml = ZimplitPage.body.innerHTML;
		var theHTML = tempHtml.substring(tempHtml.indexOf('<SPAN id=ZimplitTempReplaceBegin></SPAN>')+40, tempHtml.indexOf('<SPAN id=ZimplitTempReplaceEnd></SPAN>'));
		
		return theHTML;
	}


function ZreplaceSelectionContent(Zhtml){
	if(IE){
		var tempHtml = ZimplitPage.body.innerHTML;
		var htmlBegin = ZimplitPage.body.innerHTML.split('<SPAN id=ZimplitTempReplaceBegin></SPAN>')[0];
		var htmlEnd = ZimplitPage.body.innerHTML.split('<SPAN id=ZimplitTempReplaceEnd></SPAN>')[1];
		ZimplitPage.body.innerHTML = htmlBegin + Zhtml + htmlEnd;
		ZInitEditorEls();
	} 
}
// __better replacement functions


// newpage popup
	function ZNewPagePop(){
		if(Zimplit.currentPage()== false){
			alert(langTexts["error_cannotcreatenew"]);
		}else {
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$("#ZMainOverlay").show();
			$(document.body).prepend(Zimplit.Sources.copyPagePopup);
			$("#ZcopyPagePop").draggable();
			$('#ZcopyPagePop').css('top', (($(window).height()/2)-($('#ZcopyPagePop').height()/2))+$(window).scrollTop() + 'px');
			$('#ZcopyPagePop').css('left', (($(window).width()/2)-($('#ZcopyPagePop').width()/2)) + 'px');
			
			
			var theOptions = '';
			$.post(ZphpName+"?action=listfiles", { empty: 'empty'},
			function(data){
				var filesArray = data.split(';');
				for(var i=0; i < filesArray.length; i++){
					var fileAndTitle = filesArray[i].split('|');
					var thefile = fileAndTitle[0];
					var thetitle = fileAndTitle[1];
					if(thefile == Zimplit.currentPage()){
						theOptions += '<option selected="selected" value="'+thefile+'">'+thetitle+'('+thefile+')'+'</option>';
					} else {
						theOptions += '<option value="'+thefile+'">'+thetitle+'('+thefile+')'+'</option>';
					}
				}
				$('#ZCopyPageSrc').html(theOptions);
			});
		}
		
	}
	
	var newHtml="";
	var newName="";
	
	function ZnewPage(){
		if(Zimplit.currentPage()== false){
			alert(langTexts["error_cannotcreatenew"]);
		}else {
			newName = $('#ZCopyPageName').val();
			var tempHtmlName = newName.toLowerCase();
			for(var i=0; i < ZcharReplaces.length; i++){
				tempHtmlName = tempHtmlName.replace(ZcharReplaces[i].ch,ZcharReplaces[i].repl);
			}
			newHtml = tempHtmlName+ '.html';
			copyHtml = $('#ZCopyPageSrc').val();
			$.post(ZphpName+"?action=copyhtml&file="+copyHtml+"&newname="+newHtml+"&title="+encodeURIComponent(newName).replace(/\'/gi,"%27")+"", { empty: 'empty'},
			function(data){
				if(data == ''){
					var theCount =0;
					
						var SrcText = 'var ZMenuArray = []; \n';
						var theSaveFile = Zimplit.currentPage();
						
						for(var i in ZMenuArray){
							SrcText += 'ZMenuArray["'+i+'"] = [];\n'+
							'ZMenuArray["'+i+'"]["name"] = "'+ZMenuArray[i]["name"]+'";\n'+
							'ZMenuArray["'+i+'"]["parent"] = "'+ZMenuArray[i]["parent"]+'";\n'+
							'ZMenuArray["'+i+'"]["self"] = "'+i+'";\n'+
							'ZMenuArray["'+i+'"]["index"] = "'+ZMenuArray[i]["index"]+'";\n';
							if(ZMenuArray[i]['parent'] == theSaveFile){ 
								theCount++;
							}
						}
						
						
						
						
						SrcText += 'ZMenuArray["'+newHtml+'"] = [];\n'+
						'ZMenuArray["'+newHtml+'"]["name"] = "'+newName+'";\n'+
						'ZMenuArray["'+newHtml+'"]["parent"] = "'+theSaveFile+'";\n'+
						'ZMenuArray["'+newHtml+'"]["self"] = "'+newHtml+'";\n'+
						'ZMenuArray["'+newHtml+'"]["index"] = "'+(theCount+1)+'";\n';
						
						var scriptbottom = ZMenuScriptbottom;
						SrcText = SrcText;
						
						$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: SrcText + scriptbottom},
						function(data2){
							document.location = ZphpName+'?action=load&file='+newHtml+'&t='+Math.ceil(1000000*Math.random());
						
						});
						
						
					
					
				} else {
					alert(data);
				}
			});
		}
		
	}
// newpage popup eheend 

/* Add stuff pop */
	function ZAddPop(el){
		
		$(document.body).prepend(Zimplit.Sources.insertMenu());
		$("#ZinsertMenu").draggable();
		$("#ZinsertMenu").css('top',$(el).offset().top+64+'px').css('left',$(el).offset().left-32+'px');
	}
	
	function ZInsFilePop(){
		if(rng != null){
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$("#ZMainOverlay").show();
			$(document.body).prepend(Zimplit.Sources.insFilePopup());
			$("#ZinsFilePopup").draggable();
			$('#ZinsFilePopup').css('top', (($(window).height()/2)-($('#ZinsFilePopup').height()/2))+$(window).scrollTop() + 'px');
			$('#ZinsFilePopup').css('left', (($(window).width()/2)-($('#ZinsFilePopup').width()/2)) + 'px');
			
			$('#ZFileUpForm').ajaxForm(function(data) { 
				if(data == 1){
					ZsetUndo();
					var fileAddr = $('#ZFileUploadAddr').val();
					var fileName =  fileAddr.substring(fileAddr.lastIndexOf('\\')+1 ,fileAddr.length);
					if(ZBlinker()){
						$(ZBlinker()).before('<a oldhref="Z-files/'+fileName+'" class="ZMaskedLink" >'+fileName+'</a>');
						ZClearBlinker();
						ZremovePopup('#ZinsFilePopup');
					} else {
						alert(langTexts["error_nocursor"]);
					}
				} else {
					alert(data);
				}
	        });
		} else {
			alert(langTexts["error_nocursor"]);
		}

	}
/* __Add stuff pop */

// ZmenuStructure pop
	
	function ZSaveTheMenuStruc(){
		function returnNewMenuHtml(){
			
			function getTheparentPage(el){
				var parentPage ='';
				if(el.parentNode.className == 'ZMenuOuterCont'){
					if($(el).attr('zpage').toLowerCase() == 'index.html' || $(el).attr('zpage').toLowerCase() == 'index.htm'){
						parentPage = '\"\"';
					} else {
						parentPage = '"'+GlobZIndexfile+'"';
					}
				} else {
					parentPage = '\"'+$(el).parents('li[zpage]').eq(0).attr('zpage')+'\"';
				}
				
				return parentPage; 
			}
			
			function getIndexOfPage(el){
				var theansw = null;
				var cntr = 0;
				var LevelLis = $(el.parentNode).children('li[zpage]');
				LevelLis.each(function(){
					if($(el).attr("zpage") == $(this).attr("zpage")){
						theansw = cntr;
					}
					cntr++;
				});
				
				return theansw;
			}
			
			var strucHtml = 'var ZMenuArray = []; \nvar GlobZIndexfile = "'+GlobZIndexfile+'"; \n';
			
			
			$('#ZmenuStuc li[zpage]').each(function(){
				var pageN = $(this).attr("zpage");
				strucHtml += 'ZMenuArray["'+pageN+'"] = [];\n';
				strucHtml += 'ZMenuArray["'+pageN+'"]["name"] = "'+ZMenuArray[pageN]["name"]+'";\n';
				strucHtml += 'ZMenuArray["'+pageN+'"]["parent"] = '+getTheparentPage(this)+';\n';
				strucHtml += 'ZMenuArray["'+pageN+'"]["self"] = "'+pageN+'";\n';
				strucHtml += 'ZMenuArray["'+pageN+'"]["index"] = "'+getIndexOfPage(this)+'";\n';
				//strucHtml += $(this).attr("zpage")+' > ' +getTheparentPage(this) + "\n";
			});
			
			return strucHtml;
		}
		
		$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: encodeURIComponent(returnNewMenuHtml()) },
						function(dataBack){
							if(dataBack == ''){
								/*document.location = document.location.href;*/
								$.getScript('Zmenu.js');
								ZgenerateMenusIntoStrucPop();
							} else {
								alert(dataBack);
								theError = true;
							}
						});
	}
	
	function ZgenerateMenusIntoStrucPop(){
		// check if you are trying to do something wrong like placing an item into itselt or its children
		function isItselfOrChild(theEl,compareEl){
			var Zanswer = false;
			if($(theEl).attr('zpage') == $(compareEl).attr('zpage')){
				Zanswer = true;
			}
			var tempEl = theEl;
			do{
				tempEl = tempEl.parentNode;
				if($(tempEl).attr('zpage') == $(compareEl).attr('zpage')){
					Zanswer = true;
				}
			} while (tempEl.className != 'ZMenuOuterCont');
			return(Zanswer);
		}
		
		
		
		// arranging menu structure
		function sortZmenu2() {
			var sortedArray = []; 
			function ZSwapEls(el1, el2) { 
				var eltmp = sortedArray[el1]; 
				sortedArray[el1] = sortedArray[el2]; 
				sortedArray[el2] = eltmp; 
			} 
			for (var i in ZMenuArray){ 
				var tmparray = []; tmparray['index'] = ZMenuArray[i]['index']; 
				tmparray['self'] = ZMenuArray[i]['self']; 
				sortedArray.push(tmparray); 
			} 
			
			var ZshouldRepeat = false; 
			function sortingTurn(){ 
				if (ZshouldRepeat) { ZshouldRepeat = false; } 
				var lastsortEl = ''; var lastsortElNr = ''; 
				for (var i in sortedArray){ 
					if (lastsortEl != ''){
						if (sortedArray[i]['index'] < lastsortElNr){
							ZSwapEls(i,lastsortEl); ZshouldRepeat = true; 
						} else { 
							var lastsortEl = i; 
							var lastsortElNr = sortedArray[i]['index']; 
						}
					} else { 
						var lastsortEl = i; var lastsortElNr = sortedArray[i]['index']; 
					} 
				} 
				if (ZshouldRepeat) { sortingTurn(); }
			} 
			sortingTurn(); 
			return sortedArray; 
		}
		
		var sortedZmenu2= sortZmenu2(); 
		
		//alert(Zimplit.currentPage('fromEditorLink'));
		var thispage =  Zimplit.currentPage('fromEditorLink'); //ZimplitPage.location.href.substring(ZimplitPage.location.href.lastIndexOf('/')+1,ZimplitPage.location.href.length);
		function eContent(pageHtml,pageName){
			return '<ul class="ZEditPageDrop" style="display:none;"> '+
						//	'<li><a href="'+ZphpName+'?action=load&file='+pageHtml+'" ><img src="'+ZimplitEditorLocation+'images/menuEdit.gif" alt="" /> '+langTexts["properties_menustructure_edit"]+'</a></li>'+
							'<li><a href="javascript:void();" onclick="ZRenamePageAskPop(\''+pageHtml+'\', \''+pageName+'\');"><img src="'+ZimplitEditorLocation+'images/menuRename.gif" alt="" /> '+langTexts["properties_menustructure_rename"]+'</a></li>'+
							'<li><a href="javascript:void();" onclick="Zimplit.deletePage(\''+pageHtml+'\')"><img src="'+ZimplitEditorLocation+'images/strash.gif" alt="" />  Delete Page</a></li>'+
						'</ul>';
		}
		
		
		
		var openArr = '<a href="javascript:void(0);" onclick="ZMenuListOpenEl(this)"><img src="'+ZimplitEditorLocation+'images/menuOpen.gif" alt="" style="margin: 0; padding:0;" /></a>';
		function ZSubmenus(menuEl){
				var hasSubs = false;
				var elList = '';
				for(var j in sortedZmenu2){
					var xJ = sortedZmenu2[j]['self']; 
					if(ZMenuArray[xJ]['parent'] == menuEl){ 
						hasSubs = true;
						if(thispage == ZMenuArray[xJ]["self"]){
							elList += '<li class="ZMenusListEl" zpage="'+xJ+'"><a href="'+ZphpName+'?action=load&file='+xJ+'"  zpage="'+xJ+'"><b>'+ZMenuArray[xJ]["name"]+'</b></a>'+openArr+eContent(xJ,ZMenuArray[xJ]["name"])+'<div class="ZdragUnder" zpage="'+xJ+'"></div>'+'<ul class="ZsubmenusEl">'+ZSubmenus(xJ)+'</ul></li>';
						} else { 
							elList += '<li class="ZMenusListEl" zpage="'+xJ+'"><a href="'+ZphpName+'?action=load&file='+xJ+'"  zpage="'+xJ+'">'+ZMenuArray[xJ]["name"]+'</a>'+openArr+eContent(xJ,ZMenuArray[xJ]["name"])+'<div class="ZdragUnder" zpage="'+xJ+'"></div>'+'<ul class="ZsubmenusEl">'+ZSubmenus(xJ)+'</ul></li>';
						}
					}
				}
				if(hasSubs){elList = ''+ elList +''}
				return elList;
		}
		
		var theZmenu = '<ul class="ZMenuOuterCont">';
		for(var i in sortedZmenu2){
				var xI = sortedZmenu2[i]['self']; 
			if(ZMenuArray[xI]['parent'] == '' || ZMenuArray[xI]['parent'] == GlobZIndexfile){ 
				if(ZMenuArray[xI]['parent'] == GlobZIndexfile){
					if(thispage == ZMenuArray[xI]["self"]){
						theZmenu += '<li class="ZMenusListEl" zpage="'+xI+'"><a href="'+ZphpName+'?action=load&file='+xI+'" zpage="'+xI+'"><b>'+ZMenuArray[xI]["name"]+'</b></a>'+openArr+eContent(xI,ZMenuArray[xI]["name"])+'<div class="ZdragUnder" zpage="'+xI+'"></div>'+'<ul class="ZsubmenusEl">'+ZSubmenus(xI)+'</ul></li>';
					} else {
						theZmenu += '<li class="ZMenusListEl" zpage="'+xI+'"><a href="'+ZphpName+'?action=load&file='+xI+'" zpage="'+xI+'">'+ZMenuArray[xI]["name"]+'</a>'+openArr+eContent(xI,ZMenuArray[xI]["name"])+'<div class="ZdragUnder" zpage="'+xI+'"></div>'+'<ul class="ZsubmenusEl">'+ZSubmenus(xI)+'</ul></li>';
					}
				} else {
					if(thispage == ZMenuArray[xI]["self"]){
							theZmenu += '<li zpage="'+xI+'"><a href="'+ZphpName+'?action=load&file='+xI+'" zpage="'+xI+'"><b>'+ZMenuArray[xI]["name"]+'</b></a>'+openArr+eContent(xI,ZMenuArray[xI]["name"])+'<div class="ZdragUnder" zpage="'+xI+'"></div>'+'</li>';
					} else {
						theZmenu += '<li zpage="'+xI+'"><a href="'+ZphpName+'?action=load&file='+xI+'" zpage="'+xI+'">'+ZMenuArray[xI]["name"]+'</a>'+openArr+eContent(xI,ZMenuArray[xI]["name"])+'<div class="ZdragUnder" zpage="'+xI+'"></div>'+'</li>';
					}
				}
			}
		} 
		theZmenu += '</ul>';
		$('#ZmenuStuc').html(theZmenu);
		$('#ZmenuStuc ul').each(function(){
			$(this).children('li[zpage]:last').addClass('last');
		});
		
		
		// dag and drop
		$('#ZmenuStuc ul .ZMenusListEl').draggable({
			revert:true,
			
			start: function(){
				$(".ZEditPageDrop").hide();
			},
			stop: function(){
				$(".ZEditPageDrop").hide();
			},
			cursorAt: {
				top:0,
				left: 0
			} 
		});
		
		
		// drop ontop of page
		$('#ZmenuStuc ul li.ZMenusListEl a').droppable({
			accept: ".ZMenusListEl",
			hoverClass: 'droppable-hover',
			tolerance: 'pointer',
			drop: function(ev, ui) {
				if(!isItselfOrChild(this, ui.draggable)){
					$(this.parentNode).find('.ZsubmenusEl').eq(0).append($(ui.draggable));
				}
				$(".ZEditPageDrop").hide();
				
				$('#ZmenuStuc li.last').removeClass('last');
				$('#ZmenuStuc').each(function(){
					$(this).children('li[zpage]:last').addClass('last');
				});
				ZSaveTheMenuStruc();
				
			}
		});  
		
		$('#ZmenuStuc ul li .ZdragUnder').droppable({
			accept: ".ZMenusListEl",
			hoverClass: 'ZdragUnderhover',
			tolerance: 'pointer',
			drop: function(ev, ui) {
				if(!isItselfOrChild(this.parentNode, ui.draggable)){
					$(this.parentNode).after($(ui.draggable));
					
				}
				$(".ZEditPageDrop").hide();
				
				$('#ZmenuStuc li.last').removeClass('last');
	
				$('#ZmenuStuc ul').each(function(){
					$(this).children('li[zpage]:last').addClass('last');
				});
				ZSaveTheMenuStruc();
			}
		});
		
		$('.ZEditPageDrop').mouseleave(function(){
			$(this).hide();
		});
		
		
	}
	
	function ZmenuStrucPop(){
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		$("#ZMainOverlay").show();
		$(document.body).prepend(Zimplit.Sources.menuStructure);
		//$("#ZMenuStructure").draggable();
		$('#ZMenuStructure').css('top', (($(window).height()/2)-($('#ZMenuStructure').height()/2))+$(window).scrollTop() + 'px');
		$('#ZMenuStructure').css('left', (($(window).width()/2)-($('#ZMenuStructure').width()/2)) + 'px');
		$('#ZaddmenuPop').remove();
		
		ZgenerateMenusIntoStrucPop();
		
	}
	
	function ZMenuListOpenEl(el){
			$(".ZEditPageDrop").hide();
			if(IE){$(el).parent().children(".ZEditPageDrop").css('margin-left','-20px')}
			$(el).parent().children(".ZEditPageDrop").show();
			$('#ZmenuStuc ul li a.selected').removeClass("selected");
			$(el).addClass("selected").parent();
			
		}
	
	
		
	function ZRenamePageAskPop(thePage,newTitle){
		$(document.body).prepend(Zimplit.Sources.menuStructureAskName);
		$("#ZRenamePage").draggable();
		$('#ZRenamePage').css('top', (($(window).height()/2)-($('#ZRenamePage').height()/2))+$(window).scrollTop() + 'px');
		$('#ZRenamePage').css('left', (($(window).width()/2)-($('#ZRenamePage').width()/2)) + 'px');
		$('#ZRenamePageSrc').val(thePage);
		$('#ZRenamePageName').val(newTitle);
	}
	
	function ZRenamePage(thePage,newTitle){
		var theError = false;
		$.post(ZphpName+"?action=load1&file="+thePage+"", { empty: 'empty'},
		function(dataBack){
				var replacedTitleSrc = dataBack.replace(/<title>[^\<]+<\/title>/gi,'<title>'+newTitle+'</title>');
				
				$.post(ZphpName+"?action=saveE&file="+thePage+"", { html: encodeURIComponent(replacedTitleSrc).replace(/\'/gi,"%27") },
				function(dataBack){
					if(dataBack == ''){
						//window.location.reload();
					} else {
						alert(dataBack);
						theError = true;
					}
				});

				if(!theError){
					$.post(ZphpName+"?action=load1&file=Zmenu.js", { empty: 'empty'},
					function(dataBackMenu){
						var theMenuRegexp = new RegExp('ZMenuArray\\\["'+thePage+'"\\\]\\\["name"\\\] = "[^"]+"',"gi");
						var replacedMenuSrc = dataBackMenu.replace(theMenuRegexp,'ZMenuArray["'+thePage+'"]["name"] = "'+newTitle+'"');
						replacedMenuSrc = replacedMenuSrc.replace(/\'/gi,"%27");
						
						$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: encodeURIComponent(replacedMenuSrc) },
						function(dataBack){
							if(dataBack == ''){
								ZMenuArray[thePage]["name"] = newTitle;
								//ZimplitPage.ZMenuArray[thePage]["name"] = newTitle;
								ZgenerateMenusIntoStrucPop();
								$("#ZRenamePage").remove();
							} else {
								alert(dataBack);
								theError = true;
							}
						});
						
					});
				}
				
		});
	}
// _ZmenuStructure

var ZsubmenuCurrent = {
	active: false,
	source: '',
	clickEl: null,
	startFunction: function(){
		
	},
	run: function (){
		if (this.clickEl != null && this.source != '' && this.active){
			$(document.body).prepend(this.source);
			$('#ZmenuSubmenu').css('top', $(this.clickEl).offset().top + 0 + 'px');
			$('#ZmenuSubmenu').css('left', $(this.clickEl).offset().left + 32 + 'px');
			this.active = false;
			this.source = '';
			this.clickEl = null;
			this.startFunction();
		}
	},
	click: function(){
		void(0);
	}
}

function ZmenuSubmenuPop(clickEl,thesource, startFunction, clickFunction){
		$('#ZmenuSubmenu').remove();
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		ZsubmenuCurrent.active = true;
		ZsubmenuCurrent.source = thesource;
		ZsubmenuCurrent.clickEl = clickEl;
		ZsubmenuCurrent.startFunction = startFunction;
		ZsubmenuCurrent.click = clickFunction;
		setTimeout('ZsubmenuCurrent.run()',400);
	}
	
function ZmenuSubmenuAtOnce(clickEl,thesource, startFunction){
		$('#ZmenuSubmenu').remove();
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		ZsubmenuCurrent.active = true;
		ZsubmenuCurrent.source = thesource;
		ZsubmenuCurrent.clickEl = clickEl;
		ZsubmenuCurrent.startFunction = startFunction;
		ZsubmenuCurrent.run();
	}
	
function ZmenuSubmenuPopUp(clickEl) {
	if(clickEl == ZsubmenuCurrent.clickEl && ZsubmenuCurrent.active){
		ZsubmenuCurrent.click();
	}
	ZsubmenuCurrent.active = false;
	ZsubmenuCurrent.source = '';
	ZsubmenuCurrent.clickEl = null;
}

function ZmenuSubmenuPopRemove(){
	if(document.getElementById('ZmenuSubmenu')){
		ZsubmenuCurrent.active = false;
		ZsubmenuCurrent.source = '';
		ZsubmenuCurrent.clickEl = null;
		$('#ZmenuSubmenu').remove();
		$('.ZpopupScreen').not('#zimplitMenu').remove();
	}
}

// heading pop
	function ZheadingsPop(clickEl){
		$('#ZmenuSubmenu').remove();
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		$(document.body).prepend(Zimplit.Sources.headings);
		//$("#ZInsertheading").draggable();
		$('#ZmenuSubmenu').css('top', $(clickEl).offset().top + 0 + 'px');
		$('#ZmenuSubmenu').css('left', $(clickEl).offset().left + 32 + 'px');
	}
	
	function ZInsHeading(level){
		ZsetUndo();
		function ZFFDoTheTagH(Ztag){
			var sel2 = ZimplitPageOut.getSelection(); var rng2 = getRangeObject(sel2);
			startRangeNode = rng2.startContainer;
			endRangeNode = rng2.endContainer;
			var startIsTag = false;
			if (($(startRangeNode).parents(Ztag).length > 0)){ startIsTag = true;} /* tag allready started */
			var endIsTag = false;
			if (($(endRangeNode).parents(Ztag).length > 0)){ endIsTag = true;} /* end is in tag */
			
			var theHTML = ZFFGetBetweenSel();
			if(startIsTag && endIsTag){
				var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
				var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
				theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
				ZimplitPage.body.innerHTML = theHTML[0] +'</'+Ztag+'>'+ theHTML[1] +'<'+Ztag+'>'+ theHTML[2];
			} else if (startIsTag){
				var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
				var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
				theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
				
				var thetagRegexp1 = new RegExp("<"+Ztag+"><\\\/"+Ztag+">","g");
				var thetagRegexp2 = new RegExp("<"+Ztag+">(\\s)+<\\\/"+Ztag+">","g");
				var theHtmlContent = theHTML[1].replace(/(<[^>]+>)/g,'</'+Ztag+'>'+'$1'+'<'+Ztag+'>').replace(thetagRegexp1,'').replace(thetagRegexp2,'');
				ZimplitPage.body.innerHTML = theHTML[0] +''+ theHtmlContent +'</'+Ztag+'>'+ theHTML[2];
			} else if (endIsTag){
				var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
				var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
				theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
				
				var thetagRegexp1 = new RegExp("<"+Ztag+"><\\\/"+Ztag+">","g");
				var thetagRegexp2 = new RegExp("<"+Ztag+">(\\s)+<\\\/"+Ztag+">","g");
				var theHtmlContent = theHTML[1].replace(/(<[^>]+>)/g,'</'+Ztag+'>'+'$1'+'<'+Ztag+'>').replace(thetagRegexp1,'').replace(thetagRegexp2,'');
				ZimplitPage.body.innerHTML = theHTML[0] +'<'+Ztag+'>'+ theHtmlContent +''+ theHTML[2];
			} else {
				var thetagRegexp3 = new RegExp("<"+Ztag+">","g");
				var thetagRegexp4 = new RegExp("<\/"+Ztag+">","g");
				theHTML[1] = theHTML[1].replace(thetagRegexp3,'').replace(thetagRegexp4,'');
				
				var thetagRegexp1 = new RegExp("<"+Ztag+"><\\\/"+Ztag+">","g");
				var thetagRegexp2 = new RegExp("<"+Ztag+">(\\s)+<\\\/"+Ztag+">","g");
				var theHtmlContent = theHTML[1].replace(/(<[^>]+>)/g,'</'+Ztag+'>'+'$1'+'<'+Ztag+'>').replace(thetagRegexp1,'').replace(thetagRegexp2,'');
				ZimplitPage.body.innerHTML = theHTML[0] +'<'+Ztag+'>'+ theHtmlContent +'</'+Ztag+'>'+ theHTML[2];
			}
		}

		if (level == 0){ // normal text
			if(IE){
				var rng1 = ZimplitPage.selection.createRange();
				if (rng1.parentElement().tagName.toLowerCase() == 'h1'){
					rng1.pasteHTML('<span id="ZimplitTempReplace"></span>'+rng1.htmlText+'<span id="ZimplitTempReplaceEnd"></span>');
					rng1.parentElement().outerHTML = rng1.parentElement().outerHTML.replace(/\<span id=ZimplitTempReplace\>\<\/span\>/gi,'</h1>').replace(/\<span id=ZimplitTempReplaceEnd\>\<\/span\>/gi,'<h1>');
				} else if (rng1.parentElement().tagName.toLowerCase() == 'h2'){
					rng1.pasteHTML('<span id="ZimplitTempReplace"></span>'+rng1.htmlText+'<span id="ZimplitTempReplaceEnd"></span>');
					rng1.parentElement().outerHTML = rng1.parentElement().outerHTML.replace(/\<span id=ZimplitTempReplace\>\<\/span\>/gi,'</h2>').replace(/\<span id=ZimplitTempReplaceEnd\>\<\/span\>/gi,'<h2>');
				} else if (rng1.parentElement().tagName.toLowerCase() == 'h3'){
					rng1.pasteHTML('<span id="ZimplitTempReplace"></span>'+rng1.htmlText+'<span id="ZimplitTempReplaceEnd"></span>');
					rng1.parentElement().outerHTML = rng1.parentElement().outerHTML.replace(/\<span id=ZimplitTempReplace\>\<\/span\>/gi,'</h3>').replace(/\<span id=ZimplitTempReplaceEnd\>\<\/span\>/gi,'<h3>');
				}
				$(rng1.parentElement()).find('h1').each(function(){
					this.outerHTML = this.innerHTML; 
				});
				$(rng1.parentElement()).find('h2').each(function(){
					this.outerHTML = this.innerHTML; 
				});
				$(rng1.parentElement()).find('h3').each(function(){
					this.outerHTML = this.innerHTML; 
				});
			}
			if(!IE){ 
				var sel1 = ZimplitPageOut.getSelection(); var rng1 = getRangeObject(sel1); 
				var theHTML = ZFFGetBetweenSel();
				theHTML[1] =  theHTML[1].replace(/<h.>/gi,'').replace(/<\/h.>/gi,'');
				if(rng1.commonAncestorContainer.parentNode.tagName.toLowerCase() == 'h1'){
					theHTML[1] = '</h1>'+theHTML[1]+'<h1>';
				}
				if(rng1.commonAncestorContainer.parentNode.tagName.toLowerCase()  == 'h2'){
					theHTML[1] = '</h2>'+theHTML[1]+'<h2>';
				}
				if(rng1.commonAncestorContainer.parentNode.tagName.toLowerCase()  == 'h3'){
					theHTML[1] = '</h3>'+theHTML[1]+'<h3>';
				}
				ZimplitPage.body.innerHTML = theHTML[0]+theHTML[1]+theHTML[2];
				
				var temp= ZCurrentStyle(); 
				ZInitEditorEls();
			}
			$("#ZInsertheading").remove();
		} else { // insert heading
			if(IE){
				var rng1 = ZimplitPage.selection.createRange();
				if ((rng1.parentElement().tagName.toLowerCase() != 'h1') && (rng1.parentElement().tagName.toLowerCase() != 'h2') && (rng1.parentElement().tagName.toLowerCase() != 'h3')){
					var theHtml = ZgetSelectionContent(rng1);
					
					//  wrap around tags
					var theheadingRegexp1 = new RegExp("<h"+level+"><\\\/h"+level+">","g");
					var theheadingRegexp2 = new RegExp("<h"+level+">(\\s)+<\\\/h"+level+">","g");
					var theHtmlContent = theHtml.replace(/(<[^>]+>)/g,'</h'+level+'>'+'$1'+'<h'+level+'>').replace(theheadingRegexp1,'').replace(theheadingRegexp2,'');
					
					ZreplaceSelectionContent('<h'+level+'>'+theHtmlContent+'</h'+level+'>');
				}
			}
			
			if(!IE){
				var sel1 = ZimplitPageOut.getSelection(); var rng1 = getRangeObject(sel1); 
				if ((rng1.commonAncestorContainer.parentNode.tagName.toLowerCase() != 'h1') && (rng1.commonAncestorContainer.parentNode.tagName.toLowerCase() != 'h2') && (rng1.commonAncestorContainer.parentNode.tagName.toLowerCase() != 'h3')){
					
					ZFFDoTheTagH('h'+level+'');
 
					var temp= ZCurrentStyle(); 
					ZInitEditorEls();
				}
			}
			
			$("#ZInsertheading").remove();
		}
	}
// __heading pop
	
// addMenu Pop
	function ZaddmenuPop(){
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		$(document.body).prepend(Zimplit.Sources.addmenuPop);
		$("#ZaddmenuPop").draggable();
		$('#ZaddmenuPop').css('top', $('#zimplitMenu').offset().top + 70 + 'px');
		$('#ZaddmenuPop').css('left', $('#zimplitMenu').offset().left + 90 + 'px');
	}
	
	function Zaddmenu(level){
		ZsetUndo();
		
		var thispage =  Zimplit.currentPage();//ZimplitPage.location.href.substring(ZimplitPage.location.href.lastIndexOf('/')+1,ZimplitPage.location.href.length);

		function sortZmenu2() {
			var sortedArray = []; 
			function ZSwapEls(el1, el2) { 
				var eltmp = sortedArray[el1]; 
				sortedArray[el1] = sortedArray[el2]; 
				sortedArray[el2] = eltmp; 
			} 
			for (var i in ZMenuArray){ 
				var tmparray = []; tmparray['index'] = ZMenuArray[i]['index']; 
				tmparray['self'] = ZMenuArray[i]['self']; 
				sortedArray.push(tmparray); 
			} 
			
			var ZshouldRepeat = false; 
			function sortingTurn(){ 
				if (ZshouldRepeat) { ZshouldRepeat = false; } 
				var lastsortEl = ''; var lastsortElNr = ''; 
				for (var i in sortedArray){ 
					if (lastsortEl != ''){
						if (sortedArray[i]['index'] < lastsortElNr){
							ZSwapEls(i,lastsortEl); ZshouldRepeat = true; 
						} else { 
							var lastsortEl = i; 
							var lastsortElNr = sortedArray[i]['index']; 
						}
					} else { 
						var lastsortEl = i; var lastsortElNr = sortedArray[i]['index']; 
					} 
				} 
				if (ZshouldRepeat) { sortingTurn(); }
			} 
			sortingTurn(); 
			return sortedArray; 
		}
		var sortedZmenu2= sortZmenu2(); 
		function ZSubmenus2(menuEl) { 
			var hasSubs = false; 
			var elList = '';
			for(var j in sortedZmenu2){ 
				var xJ = sortedZmenu2[j]['self']; 
				if(ZMenuArray[xJ]['parent'] == menuEl){ 
					hasSubs = true; 
					if(thispage == ZMenuArray[xJ]["self"]){
						elList += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+xJ+'" class="activeA">'+ZMenuArray[xJ]["name"]+'</a>'+ZSubmenus2(xJ)+'</li>';
					} else {
						elList += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+xJ+'" >'+ZMenuArray[xJ]["name"]+'</a>'+ZSubmenus2(xJ)+'</li>';
					}
				}
			} 
			if(hasSubs && (menuEl != GlobZIndexfile)){ elList = '<ul>'+ elList +'</ul>' } 
			return elList; 
		}
		

		if(level==1){
			var theZmenu = '<div class="mainMenu">';
			for(var i in ZMenuArray){
				if(ZMenuArray[i]['parent'] == '' || ZMenuArray[i]['parent'] == GlobZIndexfile){ 
					if(thispage == ZMenuArray[i]["self"]){
						theZmenu += '<a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a> &nbsp;&nbsp;';
					} else {
						theZmenu += '<a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a> &nbsp;&nbsp;';
					}
				}
			}
			theZmenu += '</div>';
			
			if(!ZisSelection) {
				$(ZimplitPage.getElementById('ZimplitBlinker')).before(theZmenu);
			}
			
			$("#ZaddmenuPop").remove();
			ZStyleOverride();

		} else if (level==2){
			
			var theZmenu = '<ul class="subMenu">';
			for(var i in ZMenuArray){
				if(ZMenuArray[i]['self'] == thispage || ZMenuArray[i]['parent'] == ZMenuArray[thispage]['parent'] || (i == GlobZIndexfile && ZMenuArray[thispage]['parent'] == GlobZIndexfile)){ 
					if(ZMenuArray[i]['self'] == thispage){
						theZmenu += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a>'+ZSubmenus2(i)+'</li>';
					} else {
						theZmenu += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a></li>';
					}
				}
			}
			theZmenu += '</ul>';
			if(!ZisSelection) {
				$(ZimplitPage.getElementById('ZimplitBlinker')).before(theZmenu);
			}
			$("#ZaddmenuPop").remove();
			ZStyleOverride();
			
		} else if(level==3){
			var theZmenu = '<ul class="subMenu2">';
			
			
			if(ZMenuArray[thispage]['parent']== ''){
				for(var i in ZMenuArray){
					if (ZMenuArray[i]['parent']== ''){
						if(ZMenuArray[i]['self'] == thispage){
							theZmenu += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a></li>';
						} else {
							theZmenu += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a></li>';
						}
					} else if (ZMenuArray[i]['parent'] == GlobZIndexfile){
							if(ZMenuArray[i]['self'] == thispage){
								theZmenu += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a>'+ZSubmenus2(i)+'</li>';
							} else {
								theZmenu += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a></li>';
							}
					}
				}
			} else {
				for(var i in ZMenuArray){
					if(ZMenuArray[i]['parent'] == thispage){ 
						if(ZMenuArray[i]['self'] == thispage){
							theZmenu += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a>'+ZSubmenus2(i)+'</li>';
						} else {
							theZmenu += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a>'+ZSubmenus2(i)+'</li>';
						}
					}
				}
			}
			theZmenu += '</ul>';
			if(!ZisSelection) {
				$(ZimplitPage.getElementById('ZimplitBlinker')).before(theZmenu);
			}
			$("#ZaddmenuPop").remove();
			ZStyleOverride();
		} else if (level==4){ /* allMenu */

			var theZmenu = '<ul class="allMenu">';
			for(var i in ZMenuArray){
				if(ZMenuArray[i]['parent'] == '' || ZMenuArray[i]['parent'] == GlobZIndexfile){ 
					if(ZMenuArray[i]['parent'] == ''){
						if(thispage == ZMenuArray[i]["self"]){
							theZmenu += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a></li>';
						} else {
							theZmenu += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a></li>';
						}
					} else{
						if(thispage == ZMenuArray[i]["self"]){
							theZmenu += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a>'+ZSubmenus2(i)+'</li>';
						} else {
							theZmenu += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a>'+ZSubmenus2(i)+'</li>';
						}
					}
				}
			}
			theZmenu += '</ul>';
			
			if(!ZisSelection) {
				$(ZimplitPage.getElementById('ZimplitBlinker')).before(theZmenu);
			}
			
			$("#ZaddmenuPop").remove();
			ZStyleOverride();

		} else if (level==5){ /* mainMenuLi */
			var theZmenu = '<ul class="mainMenuLi">';
			for(var i in ZMenuArray){
				if(ZMenuArray[i]['parent'] == '' || ZMenuArray[i]['parent'] == GlobZIndexfile){ 

						if(thispage == ZMenuArray[i]["self"]){
							theZmenu += '<li class="activeLI"><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink activeA">'+ZMenuArray[i]["name"]+'</a></li>';
						} else {
							theZmenu += '<li><a target="_top" href="'+ZphpName+'?action=load&file='+i+'" class="ZMaskedLink">'+ZMenuArray[i]["name"]+'</a></li>';
						}
					
				}
			}
			theZmenu += '</ul>';
			
			if(!ZisSelection) {
				$(ZimplitPage.getElementById('ZimplitBlinker')).before(theZmenu);
			}
			
			$("#ZaddmenuPop").remove();
			ZStyleOverride();
		}
	}
	
// __addmenuPop

// bugPopup
	/*function ZBugPop(){
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		$("#ZMainOverlay").show();
		$(document.body).prepend(Zimplit.Sources.bugPop);
		$("#ZBugView").draggable();
		$('#ZBugView').css('top', (($(window).height()/2)-($('#ZBugView').height()/2))+$(window).scrollTop() + 'px');
		$('#ZBugView').css('left', (($(window).width()/2)-($('#ZBugView').width()/2)) + 'px');
		$('#ZbugFormDocLoc').val(document.location);
		$('#ZbugForm').ajaxForm(function(data) { 
			alert('Your problem sended!');
			ZremovePopup('#ZBugView');
		});
	}*/

// __bugPopup

// YouTubeVideo pop

	function ZInsYoutubePop(){
		if(rng != null){
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$("#ZMainOverlay").show();
			$(document.body).prepend(Zimplit.Sources.insYoutubePop());	
			$("#ZYoutubePopup").draggable();
			$('#ZYoutubePopup').css('top', (($(window).height()/2)-($('#ZYoutubePopup').height()/2))+$(window).scrollTop() + 'px');
			$('#ZYoutubePopup').css('left', (($(window).width()/2)-($('#ZYoutubePopup').width()/2)) + 'px');
		} else {
			alert(langTexts["error_nocursor"]);
		}
	}
	
	function ZInsYoutube(theUrl, doBorder, doTitle, title){
		if(doBorder){
			var youTubeMargin = 10;
		} else {
			var youTubeMargin = 0;
		}
		
		var titleHtml = '';
		if(doTitle){
			titleHtml = '<h2>'+title+'</h2>';
		} 
		
		if(theUrl.indexOf('http://www.youtube.com/watch?v=') > -1){
			var TheYoutubeVid = theUrl.split('watch?v=');
			var YoutubeVideoHtml = '<div class="ZYouTubeVideo" style="margin:'+youTubeMargin+'px;">'+titleHtml+'<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/'+ TheYoutubeVid[1]+'=en&fs=1"></param><param name="wmode" value="transparent"><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/'+ TheYoutubeVid[1]+'" type="application/x-shockwave-flash" allowfullscreen="true" wmode="transparent" width="425" height="344"></embed></object></div>';
			if(ZBlinker()){
				$(ZBlinker()).before(YoutubeVideoHtml);
				ZClearBlinker();
				ZremovePopup('#ZYoutubePopup');
			} else {
				alert(langTexts["error_nocursor"]);
			}
		} else {
			alert(langTexts["error_noyoutube"]);
		}
	}	

// __YouTubeVideo pop

/* FF paste pop */
	function ZFFPastePop(){
		$('.ZpopupScreen').not('#zimplitMenu').remove();
		$("#ZMainOverlay").show();
		$(document.body).prepend(Zimplit.Sources.FFPastePop);
		$("#ZFFpaste").draggable();
		$('#ZFFpaste').css('top', (($(window).height()/2)-($('#ZFFpaste').height()/2))+$(window).scrollTop() + 'px');
		$('#ZFFpaste').css('left', (($(window).width()/2)-($('#ZFFpaste').width()/2)) + 'px');
	}
	
	function ZFFPasteDo(){
		ZsetUndo();
		if(!ZisSelection) {
			$(ZimplitPage.getElementById('ZimplitBlinker')).before($('#ZFFpasteTxt').val().replace(/\n/gi,'<br/>'));
			ZremovePopup('#ZFFpaste');
			ZInitEditorEls();
		} else {
			ZFFSetSelectionContent($('#ZFFpasteTxt').val().replace(/\n/gi,'<br/>'));
			
			ZremovePopup('#ZFFpaste');
		}
		
	}
/* __FF paste pop */

/* add modules to page */
function ZinitModules(){
	$.post(ZphpName+"?action=checkFile&file=Z-scripts/addons/addonsConfig.js", { nuffing:''},
	function(data){
		if(data == 1){
			$.ajaxSetup({async: false});
			$.getScript('Z-scripts/addons/addonsConfig.js');
			for(Zcounter in Zaddons){
				var Zaddon = Zaddons[Zcounter];
				$.getScript(Zaddon);
			}	
			$.ajaxSetup({async: true});
		}
	});
}

function ZdrawModulesList(){
	var modHtml = '<div style=" margin-bottom: 5px;  clear:both; float:left; overflow: hidden; width: 120px;">';
	for (var Zcounter in Zmodules){
		var module = Zmodules[Zcounter];
		modHtml += '<a href="javascript:void(0);" onclick="ZmoduleProps('+Zcounter+');"><img src="'+module.icon+'" alt="" title="" />&nbsp;&nbsp;'+module.title+'</a>';
	}
	modHtml +='</div>';
	return modHtml;
}

function ZmoduleProps(theModule){	
	ZsetUndo();
	var module = Zmodules[theModule];
	$('.ZpopupScreen').not('#zimplitMenu').remove();
	$("#ZMainOverlay").show();
	
	$(document.body).prepend('<div id="ZmodulePropsPop" class="ZpopupScreen">'+
														'<div class="inner" style="width:500px;">'+
															'<div class="header">'+
																'<a href="javascript:void(0);" onclick="ZremovePopup(\'#ZmodulePropsPop\')" ><img src="'+ZimplitEditorLocation+'images/close.gif" class="closeBtn " alt="" /></a>'+
																module.title+
															'</div>'+
															'<div class="theContentArea" style="overflow: auto;padding: 10px;">'+
																'<div style="padding: 10px 0; font-size: 12px; line-height: 14px;">'+module.guide_text+'</div>'+
																module.zimplit_optionsview_html()+
																'<div style="margin-top: 5px; padding: 5px 0;border-top: 1px dotted #919194;">'+
																'<button name="submitOK" class="submitBtn" onclick="Zmodules['+theModule+'].on_submit();">'+langTexts["save"]+'</button>'+
																'<button name="submitCancel" class="submitBtn" onclick="ZremovePopup(\'#ZmodulePropsPop\')">'+langTexts["cancel"]+'</button>&nbsp;'+
																'</div>'+
															'</div>'+	
															
														'</div>'+
													'</div>');
		$("#ZmodulePropsPop").draggable();
		$('#ZmodulePropsPop').css('top', (($(window).height()/2)-($('#ZmodulePropsPop').height()/2))+$(window).scrollTop() + 'px');
		$('#ZmodulePropsPop').css('left', (($(window).width()/2)-($('#ZmodulePropsPop').width()/2)) + 'px');
		
		if(typeof module.zimplit_optionsview_after != 'undefined'){
			module.zimplit_optionsview_after();
		}
		
}

/* endOf modules function */

function ZdeletePage(){
	if(Zimplit.currentPage()== false){
			alert(langTexts["error_cannotdelete"]);
	}else {
		var theFile = Zimplit.currentPage();
		if((theFile != 'index.html') && (theFile != 'index.htm')){
			var asker = confirm(langTexts["confirm_delete"]+theFile+'?');
			
			if(asker == true){
				var SrcText = 'var ZMenuArray = []; \n';
				
				var contrun = true;
				
				for(var i in ZMenuArray){
					if(ZMenuArray[i]['parent'] == theFile){ 
						
						alert(langTexts["error_cannotdeletepage"]);
						contrun = false;
					}
					if(i != theFile){
						SrcText += 'ZMenuArray["'+i+'"] = [];\n'+
						'ZMenuArray["'+i+'"]["name"] = "'+ZMenuArray[i]["name"]+'";\n'+
						'ZMenuArray["'+i+'"]["parent"] = "'+ZMenuArray[i]["parent"]+'";\n'+
						'ZMenuArray["'+i+'"]["self"] = "'+i+'";\n'+
						'ZMenuArray["'+i+'"]["index"] = "'+ZMenuArray[i]["index"]+'";\n';
					}
				}
				
				var scriptbottom = ZMenuScriptbottom;
				SrcText += scriptbottom;
				if(contrun){
					$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: encodeURIComponent(SrcText).replace(/\'/gi,"%27")},
					function(data2){
						$.post(ZphpName+"?action=delete&file="+theFile, { empty: 'empty'},
						function(data3){
							document.location = ZphpName+'?action=load&file='+GlobZIndexfile+''+'&t='+Math.ceil(1000000*Math.random());
						});		
					});
				}
				
			}
		} else {
			alert(langTexts["error_cannotdeleteindex"]);
		}
	}
}


function ZremovePopup (PopName){
	$("#ZMainOverlay").hide();
	$(PopName).remove();
	
}
	
/* saf */	
function ZStyleOverride(){
	ZimplitPageOut.ZinsMenuL();
	ZMakeMenusNiceAndClickable();
	
	if(!ZimplitPage.getElementById('ZimplitStyleOverride')){
		
		var zstylesForOverride =	'.ZMaskedLink {text-decoration: underline;}'+
									'.mainMenu, .subMenu, .subMenu2, .mainMenuLi, .allMenu {background: url("'+ZimplitEditorLocation+'images/menuBg.png"); padding: 2px;}'+
									'.ZmenuDelBtn {display:inline; position: absolute; z-index: 3;}'+
									'.ZmenuDelBtn img {border:0;}'+
									'#ZMainOverlay {position: absolute; top:0px; left: 0px; background: #000000; filter:alpha(opacity=60); -moz-opacity: 0.60; opacity: 0.60; z-index: 10; width: 100%;}'+
									'#ZimplitBlinker{width:2px;height:1em;margin:0; padding:0;position: absolute; border:0; background:0; display: inline; clear:none; float: none; margin-left: -2px;}'+
									'#ZResizeImageBtn {position: absolute; display: block; margin:0; padding:0; background: url("'+ZimplitEditorLocation+'images/imgResize.gif"); width: 11px; height:11px;}'+
									'.'+ZEditableAreaClass+' { border: 3px dotted #4fa0de; }'+
									'.ZDeletableEl, .ZDeletableEl2 { border: 3px dotted #aaaaaa; }';					
		if(IE){
			var zstylesForOverride ='<style id="ZimplitStyleOverride">'+zstylesForOverride+'</style>';
			$(ZimplitPage.body).prepend(zstylesForOverride);
		} else {
			var styleEl = ZimplitPage.createElement('style');
			$(styleEl).attr('id','ZimplitStyleOverride');
			$(styleEl).html(zstylesForOverride);
			$(ZimplitPage).find('head').append(styleEl);
			//$(ZimplitPage.body).prepend(zstylesForOverride);
		}
		
		if(OTHERBROWSER){ZimplitMenu.css('position','fixed');}
	}
	ZgenerateMenuDelButtons();
	$(ZimplitPage).find('.ZDeletableEl').each(function(d) { $(this).prepend('<a href="javascript: void(0);" onclick="window.top.ZDeletePageMenu(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="delete this block" title="delete this block" /></a>');  });
	$(ZimplitPage).find('.ZDeletableEl2').each(function(d) { $(this).prepend('<a href="javascript: void(0);" onclick="window.top.ZDeleteParentParentEl(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="delete this block" title="delete this block" /></a>');  });
}

function ZgenerateMenuDelButtons(){
	$(ZimplitPage).find('.ZmenuDelBtn').remove();
	$(ZimplitPage).find('.mainMenu').each(function(d) { $(this).prepend('<a href="javascript: void(0);" onclick="window.top.ZDeletePageMenu(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="" /></a>');  });
	$(ZimplitPage).find('.mainMenuLi').each(function(d) { $(this).prepend('<a href="javascript: void(0);" onclick="window.top.ZDeletePageMenu(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="" /></a>');  });
	$(ZimplitPage).find('.allMenu:not(.ZverticalDropdown,.ZhorizontalDropdown)').each(function(d) { $(this).prepend('<a href="javascript: void(0);" onclick="window.top.ZDeletePageMenu(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="" /></a>');  });
	$(ZimplitPage).find('.ZmenuWrapper').each(function(d) { $(this).append('<a href="javascript: void(0);" onclick="window.top.ZDeletePageMenu(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="" /></a>');  });
	
	$(ZimplitPage).find('.subMenu').each(function(d) { $(this).prepend('<a href="javascript: void(0);" onclick="window.top.ZDeletePageMenu(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="" /></a>');  });
	$(ZimplitPage).find('.subMenu2').each(function(d) { $(this).prepend('<a href="javascript: void(0);" onclick="window.top.ZDeletePageMenu(this);" class="ZmenuDelBtn"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="" /></a>');  });

}

function ZDeletePageMenu(theEl){
	$(theEl).parent().remove();
}

function ZDeleteParentParentEl(theEl){
	$(theEl).parent().parent().remove();
}

function ZKeyCode(e) {
	if(!e) var e = ZimplitPageOut.event;
	return (IE)? e.keyCode : e.which;
}

function ZMakeImagesActive(){
	if(ZeditableAreasMode){
		var theImages = $(ZimplitPage.body).find('.'+ZEditableAreaClass+' img');
	 } else {
		var theImages = $(ZimplitPage.body).find('img');
	 }
		theImages .each(function(d){
			if(this.id != "ZimplitBlinker"){
				this.onclick = function(){  
					ZClearBlinker();
					$(this).after(_blinker);
					ZimageSelected = this;
					ZaddImageButtons(ZimageSelected);
					var temp = ZCurrentStyle();
				}
			}
		});
	  
}

var doTheResize= false;

var imgWprev  = 0;
var imgHprev = 0;

function ZaddImageButtons(imgEl){
	$('#ZlinkPopup').css('top', $('#zimplitMenu').offset().top + 40 + 'px');
	$('#ZlinkPopup').css('left', $('#zimplitMenu').offset().left + 'px');
	
	
	var imgBX = $(imgEl).offset().left + $(imgEl).width();
	var imgBY = $(imgEl).offset().top + $(imgEl).height();
	$(ZimplitPage).find('#ZResizeImageBtn').remove();
	var rezizerBtnHTML = '<div onmousedown="window.parent.ZrezizeTheImage();" onmouseup="window.parent.doTheResize= false;"  id="ZResizeImageBtn" ></div>';
	$(ZimplitPage.body).prepend(rezizerBtnHTML);
	
	var rezBtn = $(ZimplitPage).find('#ZResizeImageBtn');
	rezBtn.css('top', imgBY+'px').css('left',imgBX+'px');
	var rezBtn1 = ZimplitPage.getElementById('ZResizeImageBtn');
	
	
	rezBtn1.ondrag=function(){return false;};
	rezBtn1.onselectstart=function(){return false;};
	
	imgWprev  = $(imgEl).width();
	imgHprev = $(imgEl).height();
	
	doTheResize= true;
	
}


function ZrezizeTheImage(){
	if(ZimageSelected && doTheResize){
		var imgEl = $(ZimageSelected);
		var rezBtn = $(ZimplitPage).find('#ZResizeImageBtn');
		
		
		var imgW = Zimplit.globals.mouse.x  - $(imgEl).offset().left;
		var imgH = (imgW /imgWprev) * imgHprev;
		
		if ((imgW > 10) && (imgH > 10)){
			$(imgEl).css('width',imgW+'px').css('height',imgH+'px');
			var imgBX = $(imgEl).offset().left + $(imgEl).width();
			var imgBY = $(imgEl).offset().top + $(imgEl).height();
			rezBtn.css('top', imgBY+'px').css('left',imgBX+'px');
		}
		setTimeout('ZrezizeTheImage()',100);
		
	}  else {
		$(ZimplitPage).find('#ZResizeImageBtn').remove();
	}
	
}




function ZsetUndo(){
	if(ZUndoArray.length > ZundoLevels){ var lostU = ZUndoArray.shift();}
	ZUndoArray.push($(ZimplitPage.body).html());
	ZRedoArray = [];
}

function ZgetUndo(){
		if (ZUndoArray.length > 0){
			ZRedoArray.push($(ZimplitPage.body).html());
			ZimplitPage.body.innerHTML = ZUndoArray.pop();
		}
		
}

function ZgetRedo(){
	if (ZRedoArray.length > 0){
		if(ZUndoArray.length > ZundoLevels){ var lostU = ZUndoArray.shift();}
		ZUndoArray.push($(ZimplitPage.body).html());
		ZimplitPage.body.innerHTML = ZRedoArray.pop();
	}
	
}

function ZdoUndo(){
	ZgetUndo();
	ZStyleOverride();
}

function ZdoRedo(){
	ZgetRedo();
	ZStyleOverride();
}


function ZregainUTF8(){
	var preContent = $(ZimplitPage.documentElement).html();
	var theEncoding = preContent.match(/(charset=)[^(\"|\'|\>)]+/gi);
	theEncoding = theEncoding.toString().toLowerCase().split('=')[1];
	if(theEncoding != 'utf-8'){
		ZSaveContent();
	}
}


function ZInitEditorEls(){
	$(ZimplitPage.body).find('a[href]:not(.ZMaskedLink)').each(function(d){
		$(this).attr('oldhref',$(this).attr('href')).removeAttr('href').addClass('ZMaskedLink');
	});
	
	$(ZimplitPage.body).find('a.ZMaskedLink2').each(function(d){
		var addr = $(this).attr('oldhref');
		
		if(addr.lastIndexOf("/") != -1) {
			var addr2 = addr.substring(addr.lastIndexOf("/")+1, addr.length);
		} else {
			var addr2 = addr;
		}
		$(this).attr('href',''+ZphpName+'?action=load&file='+addr2).attr('target','_top');
		$(this).removeClass('ZMaskedLink');
	});
	
	
	ZimplitPageOut.ZinsMenuL();
	ZMakeMenusNiceAndClickable();
	ZStyleOverride();
	ZMakeImagesActive();
	
}

function ZMakeMenusNiceAndClickable(){
	$(ZimplitPage).find('.mainMenu a').each(function(d){
		var theHref = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/')+1 ,$(this).attr('href').length);
		$(this).attr('href',ZphpName+'?action=load&file='+theHref).attr('target','_top');
	});
	$(ZimplitPage).find('.mainMenuLi a').each(function(d){
		var theHref = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/')+1 ,$(this).attr('href').length);
		$(this).attr('href',ZphpName+'?action=load&file='+theHref).attr('target','_top');
	});
	$(ZimplitPage).find('.allMenu a').each(function(d){
		var theHref = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/')+1 ,$(this).attr('href').length);
		$(this).attr('href',ZphpName+'?action=load&file='+theHref).attr('target','_top');
	});
	
	
	$(ZimplitPage).find('.subMenu a').each(function(d){
		var theHref = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/')+1 ,$(this).attr('href').length);
		$(this).attr('href',ZphpName+'?action=load&file='+theHref).attr('target','_top');
	});
	$(ZimplitPage).find('.subMenu2 a').each(function(d){
		var theHref = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/')+1 ,$(this).attr('href').length);
		$(this).attr('href',ZphpName+'?action=load&file='+theHref).attr('target','_top');
	});
	
	$(ZimplitPage).find('.ZSwitchDirlink a').each(function(d){
		var theHref = $(this).attr('href')+ZphpName;
		$(this).attr('href',theHref).attr('target','_top');
	});
	
}

var notreloaded = true;

function ZDoTheReload(){
	if(notreloaded){
		notreloaded = false;
		document.getElementById('zimplitPage').contentWindow.location.reload();
	} else {
	
		ZimplitPage = document.getElementById('zimplitPage').contentWindow.document;
		ZimplitPageOut = document.getElementById('zimplitPage').contentWindow;
		document.getElementById('zimplitPage').onload = function(){void(0);};
		
		if (!OPERA) {ZCheckMenuJSCode();}
		ZcheckForEditableAreas();
		
		ZInitEditorEls();
		ZinitPageEvents();
		ZregainUTF8();
		ZsetUndo();
		
		
		$("#zimplitPage").height($(window).height());
		$("#ZMainOverlay").height($(document).height());
		ZnotifyEmptyEditableAreas();
		ZinitModules();
		
		
	}
}

function ZIfWindowIsResized(){
	var sideheight = $(window).height()-10;
	var innersideheight = $("#ZimplitSideMenu .outerBorder .inner").eq(0).height()+58;
	sideheight = (innersideheight > sideheight)?innersideheight:sideheight;
	$("#ZimplitSideMenu .outerBorder").height(sideheight);
	$("#ZimplitSideMenu .sideScroller").css('margin-top',($(window).height()/2)-49);
	$("#zimplitPage").height(sideheight);
	$("#ZMainOverlay").height($(window).height());
}





function ZCheckMenuJSCode(){
	function hasNotZMenuJs(theHTML){
		var theAnswer = true;
		if(IE){
			if((theHTML.indexOf('<SCRIPT src="Zmenu.js') != -1)|| (theHTML.indexOf('<SCRIPT type=text/javascript src="Zmenu.js') != -1)){
				theAnswer = false;
			}
		} else if (!IE){
			if(theHTML.indexOf('<script src="Zmenu.js') != -1){
				theAnswer = false;
			}
		}
		return theAnswer;
	}
	
	var preContent = $(ZimplitPage.documentElement).html();
	var hasNotJS = hasNotZMenuJs(preContent);
	if (hasNotJS){
		ZSaveContent();
	}
}



/* new functions gathered here. all function swill be in some time gathered here together too to make things more obvious and simpler to develop */
var Zimplit = {
	globals: {
		canWriteHtml: false,
		listMode: false,
		mouse:{
			x:0,
			y:0
		}
	},
	
	objectNames:{
		googleSearchScript: "ZGoogleSearchScript",
		googleSearchBox: "ZGoogleSearchBox",
		googleSearchDivIdPrefix: "GSId_",
		googleMapBox: "ZGoogleMapBox",
		googleMapDivIdPrefix: "GMId_",
		sessCookie: "ZeditorData"
	},
	
	cookies: {
		create: function(name,value,days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = name+"="+value+expires+"; path=/";
		},

		read: function(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		},
		erase: function(name) {
			createCookie(name,"",-1);
		},
		
		txt2data: function(txt){
			var theArr = [];
			var tmpArr = txt.split(';');
			$(tmpArr).each(function(){
				var tmpDataEl = this.split(':');
				theArr[tmpDataEl[0]] = tmpDataEl[1];
			});
			return theArr;
		},
		
		data2txt: function(arr){
			var dataTxt = '';
			for(var i in arr){
				dataTxt += i+':'+arr[i]+';';
			}
			return dataTxt;
		},
		
		setData: function(dataKey,data){
			var currentData = [];
			if(Zimplit.cookies.read(Zimplit.objectNames.sessCookie) != null){
				currentData = Zimplit.cookies.txt2data(Zimplit.cookies.read(Zimplit.objectNames.sessCookie));
			}
			currentData[dataKey]= data;
			var dataTxt = Zimplit.cookies.data2txt(currentData);
			
			Zimplit.cookies.create(Zimplit.objectNames.sessCookie, dataTxt);
		},
		
		getData: function(dataKey){
			if(Zimplit.cookies.read(Zimplit.objectNames.sessCookie) != null){
				var currentData = Zimplit.cookies.txt2data(Zimplit.cookies.read(Zimplit.objectNames.sessCookie));
				if(typeof currentData[dataKey] != 'undefined'){
					return currentData[dataKey];
				} else { return null;}
			} else {
				return null;
			}
		}
		 
	},
	
	/* page functions */
	
	currentPage: function(mode){
		if(typeof mode != 'undefined'){
			if(mode == 'fromEditorLink'){
				if(document.location.href.indexOf('file=') > -1){
					var dloc = document.location.href.split('file=')[1];
					if(dloc.indexOf('?') > -1){
						dloc= dloc.split('?')[0];
					}
				} else {
					dloc = GlobZIndexfile;
				}
				
				return dloc;
			}
		} else {
			var ifrsource = $('#zimplitPage').attr('src').split('?')[0];
			var sourcefromdom = ZimplitPage.location.href.substring(ZimplitPage.location.href.lastIndexOf('/')+1,ZimplitPage.location.href.length).split('?')[0];
			if(ifrsource==sourcefromdom){
				return ifrsource;
			} else {
				alert(langTexts["error_badlocation"]);
				return false;
			}
		}
	},
	

	
	edit:{
		toggleList: function() {
			Zimplit.listMode=(Zimplit.listMode)?false:true;
			var curCursor = Zimplit.blinker.selection.get(); 
			
			function SetList(){
				if(ZisSelection){
					var theHtml = curCursor.html;
					theHtml = '<ul><li>'+theHtml.replace(/\<br?(\/)\>/gi,'</li><li>')+'</li></ul>';
					if(!IE){
						theHtml = new Array(curCursor.src_before,theHtml,curCursor.src_after);
					}
					Zimplit.blinker.selection.set(theHtml);			
				} else {
					if(ZcheckBlinkerIsInEditable()){
						var blinkerspilt = Zimplit.blinker.split();
						blinkerspilt.element.innerHTML = blinkerspilt.src_before+'<ul><li>'+ _blinker +'</li></ul>'+ blinkerspilt.src_after;
					}	
				}
			}
			
			function UnsetList(){
				
				if(ZisSelection){
					var theHtml = curCursor.html;
					theHtml = theHtml.replace(/\<li\>/gi,'').replace(/\<\/li\>/gi,'').replace(/\<ul\>/gi).replace(/\<\/ul\>/gi);
					Zimplit.blinker.selection.set(theHtml);
				} else {
					if(ZcheckBlinkerIsInEditable()){
						if (($(ZimplitPage.getElementById('ZimplitBlinker')).parents('ul').length > 0)){
							var blinkerspilt = Zimplit.blinker.split('global');
							blinkerspilt.element.innerHTML = blinkerspilt.src_before+'</li></ul>'+ _blinker +'<ul><li>'+ blinkerspilt.src_after;
						}
					}
				}
				
			}
			
			if(Zimplit.listMode){SetList();} else {UnsetList();}
			var temp= ZCurrentStyle();
		},
		
		textColor: function(theColor){
			var curCursor = Zimplit.blinker.selection.get(); 
			if(ZisSelection){
				var theHtml = curCursor.html;
				theHtml = theHtml.replace(/(<[^>]+>)/g,'</span>'+'$1'+'<span style="color:#'+theColor+'">');
				theHtml = '<span style="color:#'+theColor+'">'+theHtml+'</span>';
				theHtml = Zimplit.stringF.removeEmptySpans(theHtml);
				if(!IE){
					theHtml = new Array(curCursor.src_before,theHtml,curCursor.src_after);
				}
				Zimplit.blinker.selection.set(theHtml);			
			}
		},
		
		textFont: function(theFont){
			var curCursor = Zimplit.blinker.selection.get(); 
			if(ZisSelection){
				var theHtml = curCursor.html;
				theHtml = theHtml.replace(/(<[^>]+>)/g,'</span>'+'$1'+'<span style="font-family:'+theFont+'">');
				theHtml = '<span style="font-family:'+theFont+'">'+theHtml+'</span>';
				theHtml = Zimplit.stringF.removeEmptySpans(theHtml);
				if(!IE){
					theHtml = new Array(curCursor.src_before,theHtml,curCursor.src_after);
				}
				Zimplit.blinker.selection.set(theHtml);			
			}
		},
		
		textSize: function(theSize){
			var curCursor = Zimplit.blinker.selection.get(); 
			if(ZisSelection){
				var theHtml = curCursor.html;
				theHtml = theHtml.replace(/(<[^>]+>)/g,'</span>'+'$1'+'<span style="font-size:'+theSize+'px; line-height:'+theSize+'px">');
				theHtml = '<span style="font-size:'+theSize+'px; line-height:'+theSize+'px">'+theHtml+'</span>';
				theHtml = Zimplit.stringF.removeEmptySpans(theHtml);
				if(!IE){
					theHtml = new Array(curCursor.src_before,theHtml,curCursor.src_after);
				}
				Zimplit.blinker.selection.set(theHtml);			
			}
		}
		
	},
	
	stringF:{
		splitBefore: function (s,sp){
			var p = s.indexOf(sp);
			var r = new Array();
			r.push(s.substring(0,p));
			r.push(s.substring(p,s.length));
			return r;
		},
		
		removeEmptySpans: function(theHtml){
			return theHtml.replace(/<span[^>]*><\/span>/gi,'');
		}
	},
	
	F: {
		convertToFileName: function(s,ext){
			var tempS = s.toLowerCase();
			for(var i=0; i < ZcharReplaces.length; i++){
				tempS  = tempS.replace(ZcharReplaces[i].ch,ZcharReplaces[i].repl);
			}
			tempS  = tempS + '.'+ ext;
			return tempS;
		}
	},
	
	
	
	deletePage: function (fileName){
		var thispage = Zimplit.currentPage();
		var theFile = fileName;
		if((theFile != 'index.html') && (theFile != 'index.htm')){
			var asker = confirm(langTexts["confirm_delete"]+theFile+'?');
			if(asker == true){
				var SrcText = 'var ZMenuArray = []; \n';
				var contrun = true;
				
				for(var i in ZMenuArray){
					if(ZMenuArray[i]['parent'] == theFile){ 
						alert(langTexts["error_cannotdeletepage"]);
						contrun = false;
					}
					if(i != theFile){
						SrcText += 'ZMenuArray["'+i+'"] = [];\n'+
						'ZMenuArray["'+i+'"]["name"] = "'+ZMenuArray[i]["name"]+'";\n'+
						'ZMenuArray["'+i+'"]["parent"] = "'+ZMenuArray[i]["parent"]+'";\n'+
						'ZMenuArray["'+i+'"]["self"] = "'+i+'";\n'+
						'ZMenuArray["'+i+'"]["index"] = "'+ZMenuArray[i]["index"]+'";\n';
					}
				}
				
				var scriptbottom = ZMenuScriptbottom;
				SrcText += scriptbottom;
				if(contrun){
					if (thispage == theFile){
						$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: encodeURIComponent(SrcText).replace(/\'/gi,"%27")},
						function(data2){
							$.post(ZphpName+"?action=delete&file="+theFile, { empty: 'empty'},
							function(data3){
								document.location = ZphpName+'?action=load&file='+GlobZIndexfile+''+'&t='+Math.ceil(1000000*Math.random());
							});		
						});
					} else {
						$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: encodeURIComponent(SrcText).replace(/\'/gi,"%27")},
							function(data2){
								$.post(ZphpName+"?action=delete&file="+theFile, { empty: 'empty'},
								function(data3){
									$.getScript('Zmenu.js');
									ZgenerateMenusIntoStrucPop();
								});		
							});
					}
				}
				
			}
		} else {
			alert(langTexts["error_cannotdeleteindex"]);
		}	
	},
	
	newPage: function(){
		if(Zimplit.currentPage()== false){
			alert(langTexts["error_cannotcreatenew"]);
		}else {
			newName = $('#ZCopyPageName').val();
			newHtml = Zimplit.F.convertToFileName(newName, 'html');
			var copyHtml = $('#ZCopyPageSrc').val();
			var urlVal = $('#ZNewPageUrl').val();
			if(urlVal != '' && urlVal != 'http://'){
				if((urlVal.substring(0,7).toLowerCase() != 'http://')&&(urlVal.substring(0,8).toLowerCase() != 'https://')){
					urlVal = 'http://'+urlVal;
				}
				var reqString = ZphpName+"?action=downloadHtmlTemplate&file="+urlVal+"&page="+newHtml;
			} else {
				var reqString = ZphpName+"?action=copyhtml&file="+copyHtml+"&newname="+newHtml+"&title="+encodeURIComponent(newName).replace(/\'/gi,"%27");
			}
			$.post(reqString, { empty: 'empty'},
			function(data){
				if(data == ''|| (urlVal != '' && urlVal != 'http://')){
					var theCount =0;
					
						var SrcText = 'var ZMenuArray = []; \n';
						var theSaveFile = Zimplit.currentPage();
						
						for(var i in ZMenuArray){
							SrcText += 'ZMenuArray["'+i+'"] = [];\n'+
							'ZMenuArray["'+i+'"]["name"] = "'+ZMenuArray[i]["name"]+'";\n'+
							'ZMenuArray["'+i+'"]["parent"] = "'+ZMenuArray[i]["parent"]+'";\n'+
							'ZMenuArray["'+i+'"]["self"] = "'+i+'";\n'+
							'ZMenuArray["'+i+'"]["index"] = "'+ZMenuArray[i]["index"]+'";\n';
							if(ZMenuArray[i]['parent'] == theSaveFile){ 
								theCount++;
							}
						}

						SrcText += 'ZMenuArray["'+newHtml+'"] = [];\n'+
						'ZMenuArray["'+newHtml+'"]["name"] = "'+newName+'";\n'+
						'ZMenuArray["'+newHtml+'"]["parent"] = "'+theSaveFile+'";\n'+
						'ZMenuArray["'+newHtml+'"]["self"] = "'+newHtml+'";\n'+
						'ZMenuArray["'+newHtml+'"]["index"] = "'+(theCount+1)+'";\n';
						
						var scriptbottom = ZMenuScriptbottom;
						SrcText = SrcText;
						
						$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: SrcText + scriptbottom},
						function(data2){
							document.location = ZphpName+'?action=load&file='+newHtml+'&t='+Math.ceil(1000000*Math.random());
						});

				} else {
					alert(data);
				}
			});
		}
		
	},
	
	/* END_OF page functions */
	
	
	
	getId: function(idName,where){	
		if(where == 'page'){return ZimplitPage.getElementById(idName);} else if (where == 'editor'){return document.getElementById(idName);} else { return null; }
	},
	
	getClassNames: function(el){
		return $(el).attr('class').split(' ');
	},
	
	check: {
		htmlHasNotZmenuJs: function (theHTML){
			var theAnswer = true;
			if(IE){
				if((theHTML.indexOf('<SCRIPT src="Zmenu.js') != -1) || (theHTML.indexOf('<SCRIPT type=text/javascript src="Zmenu.js') != -1)){
					theAnswer = false;
				}
			} else if (!IE){
				if(theHTML.indexOf('<script src="Zmenu.js') != -1){
					theAnswer = false;
				}
			}
			return theAnswer;
		},
		
		clickInUnEditable: function(selObj){
			var rng = selObj.range;
			var theAnswer = false;
			var uneditableEls = Zuneditables.split(',');
			for (var j in uneditableEls){
				if(IE){if ('.'+ rng.parentElement().className == uneditableEls[j]){theAnswer = true;}}
				if(!IE){if ('.' + rng.commonAncestorContainer.parentNode.className == uneditableEls[j]){theAnswer = true;}}
			}
			if(IE){if ($(rng.parentElement()).parents().filter(Zuneditables).length != 0){theAnswer = true;}}
			if(!IE){if ($(rng.commonAncestorContainer.parentNode).parents().filter(Zuneditables).length != 0){theAnswer = true;}}
			return theAnswer;
		}
	},
	
	prepare: {
		iframeForSave: function (iFrameWindow){
			Zimplit.prepare.domForSave(iFrameWindow);
			var answer = Zimplit.prepare.parseAsTextForSave(iFrameWindow);
			return answer;
		//	return $(iFrameWindow.documentElement).html();
		},
		
		domForSave : function(iFrameWindow){
			ZClearBlinker();
			Zimplit.prepare.removeSkypeNumbers(iFrameWindow);
			Zimplit.prepare.googleSearcForSave(iFrameWindow);

			/* firebug ads some stuff user does not want to see probably */
			$(iFrameWindow).find('#_firebugConsole').remove();
			$(iFrameWindow).find('#_firebugConsole').remove();
			
			$(iFrameWindow).find('.subMenu2andUp').html('');
			$(iFrameWindow).find('.ZmenuDelBtn').remove();
			$(iFrameWindow).find('#ZResizeImageBtn').remove();
			$(iFrameWindow).find('.ZelementToBeDeleted').remove();
			$(iFrameWindow).find('.'+ZEmptyEditableAreaNotifierClass).remove();
			
			$(iFrameWindow).find('#ZinsertedImage').removeAttr('id');
			
			$(iFrameWindow).find('.ZSwitchDirlink a').each(function(d){
				$(this).attr('href', $(this).attr('href').substring(0, $(this).attr('href').lastIndexOf('/')+1));
			});
			
		// return all masked links
			$(iFrameWindow.body).find('a[oldhref]').each(function(d){
				$(this).attr('href',$(this).attr('oldhref')).removeAttr('oldhref').removeClass('ZMaskedLink');
			});

			if(iFrameWindow.getElementById('ZimplitStyleOverride')) {$(iFrameWindow.getElementById('ZimplitStyleOverride')).remove();}
			
			/* menu links must be rewritten to standard. not redirecting in zimplit */
			var menulinks = $(iFrameWindow).find('.mainMenu a').add($(iFrameWindow).find('.mainMenuLi a')).add($(iFrameWindow).find('.allMenu a')).add($(iFrameWindow).find('.subMenu a')).add($(iFrameWindow).find('.subMenu2 a'));
			menulinks.each(function(){
				var phpNameReg = ZphpName.replace(/\./gi,'\\.');
				var regMenuPhp1 = new RegExp(phpNameReg+"\\?action\\=load\\&amp\\;file\\=",'gi');
				var regMenuPhp2 = new RegExp(phpNameReg+"\\?action\\=load\\&file\\=",'gi');
				$(this).attr('href',$(this).attr('href').replace(regMenuPhp1,"").replace(regMenuPhp2,""));
			});
			
		},
		
		parseAsTextForSave: function (iFrameWindow){
			var preContent = $(iFrameWindow.documentElement).html();
			
			if (Zimplit.check.htmlHasNotZmenuJs(preContent)){preContent = preContent.replace(/\<\/body\>/gi, '<script src="'+ZimplitEditorLocation+'jquery.js" type="text/javascript"></script><script src="'+ZimplitEditorLocation+'ZimgZoomer.js" type="text/javascript"></script><script src="Zmenu.js?t='+Math.ceil(1000000*Math.random())+'" type="text/javascript"></script><script src="'+ZimplitEditorLocation+'ZZMenu.js" type="text/javascript"></script></body>');}
			preContent = preContent.replace(/(charset=)[^(\"|\'|\>)]+/i, '$1utf-8');
			preContent = preContent.replace(/zsrctemp\=/i, 'src=');
			
			preContent = preContent.replace(/(jQuery(\d+)=)[(\"|\')(\d+)(\"|\')]+/gi, '');
			preContent = preContent.replace(/<br>/gi, '<br/>');
			preContent = preContent.replace(/<BR>/gi, '<BR/>');
			
			preContent = preContent.replace(/(<meta [^>]+)>(?!<\/meta>)/g, '$1></meta>');
			preContent = preContent.replace(/(<link [^>]+)>(?!<\/link>)/g, '$1></link>');
			preContent = preContent.replace(/(<hr [^>]+)(?!\/)>(?!<\/hr>)/g, '$1 />');
			preContent = preContent.replace(/(<img [^>]+)(?!\/)>(?!<\/img>)/g, '$1 />');
			
			preContent = preContent.replace(/(<META [^>]+)>(?!<\/META>)/g, '$1></META>');
			preContent = preContent.replace(/(<LINK [^>]+)>(?!<\/LINK>)/g, '$1></LINK>');
			preContent = preContent.replace(/(<HR [^(>]+)(?!\/)>(?!<\/HR>)/g, '$1 />');
			preContent = preContent.replace(/(<IMG [^>]+)(?!\/)>(?!<\/IMG>)/g, '$1 />');

			// google search stuff
			preContent = preContent.replace(/<SPAN id\=ZGoogleSearchScript style\=\"DISPLAY\: none\"[^>]*><\/SPAN>/g, '<SPAN id=ZGoogleSearchScript style="DISPLAY: none">'+Zimplit.Sources.googleSearchScript()+'</SPAN>');
			if(IE){
				preContent = preContent.replace(/<SPAN class\=ZreplaceWithGSBoxScript theid\=\"([^\"]+)\" pagesrc="([^\"]+)"><\/SPAN>/g, '<script  type="text/javascript">ZLoadGSearch(document.getElementById("$1"),"$2");</script>');
				preContent = preContent.replace(/<SPAN class\=ZreplaceWithGSBoxScript pagesrc="([^\"]+)" theid\=\"([^\"]+)\"><\/SPAN>/g, '<script  type="text/javascript">ZLoadGSearch(document.getElementById("$2"),"$1");</script>');
				preContent = preContent.replace(/<SPAN class\=ZreplaceWithGMBoxScript text\=\"([^\"]+)\" zoom\=\"([^\"]+)\" pointy\=\"([^\"]+)\" pointx\=\"([^\"]+)\" theid="([^\"]+)"><\/SPAN>/g, '<script  type="text/javascript">ZLoadGMap(document.getElementById("$5"),$4,$3,$2,"$1");</script>');
			}
			preContent = preContent.replace(/<link href\=\"http:\/\/www.google.com\/uds\/api\/search\/1\.0\/[^\/]+\/default.css\" type\=\"text\/css\" rel\=\"stylesheet\"><\/link>/g, '');
			
			preContent = preContent.replace(/<style type\="text\/css">\@media print\{\.gmnoprint\{display\:none\}\}\@media screen\{\.gmnoscreen\{display\:none\}\}<\/style>/g,'');
			preContent = preContent.replace(/<script src\="http\:\/\/maps\.gstatic\.com\/[^>]+><\/script>/gi, '');
			
			if(IE){
				preContent = preContent.replace(/<SCRIPT src="http:\/\/www.google-analytics.com\/ga.js" type=text\/javascript><\/SCRIPT>/gi, '');
			} else if (!IE){
				preContent = preContent.replace(/<script src="http:\/\/www.google-analytics.com\/ga.js" type="text\/javascript"><\/script>/gi, '');
			}
			
			/* skype sucks for real.  makes zimplit refresh */
			if(!IE){
				preContent = preContent.replace(/<script charset="utf-8" id="injection_graph_func" src="chrome:\/\/skype_ff_toolbar_win\/content\/injection_graph_func.js"><\/script>/gi, '');
				preContent = preContent.replace(/<script id="_nameHighlight_injection"><\/script><link class="skype_name_highlight_style" href="chrome:\/\/skype_ff_toolbar_win\/content\/injection_nh_graph.css" type="text\/css" rel="stylesheet" charset="utf-8" id="_injection_graph_nh_css">/gi, '');
			}
			
			var theContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">' + preContent + '</html>';
			return theContent;
		},
		
		removeSkypeNumbers: function (iFrameWindow){
			/* get numbers back */
			$(iFrameWindow).find('.skype_tb_injection').each(function(){
				var thephonenr = $(this).attr('context');
				$(this).before(thephonenr).remove();
			});
			
			/* remove stupid skype elements */
			$(iFrameWindow.documentElement.getElementsByTagName('head')[0]).find('#injection_graph_css').remove();
		},
		
		googleSearcForSave: function (iFrameWindow){
			/* clear google search content */
			if((!iFrameWindow.getElementById(Zimplit.objectNames.googleSearchScript))&& ($(iFrameWindow).find('.'+Zimplit.objectNames.googleSearchBox).length > 0)){
				$(iFrameWindow.body).prepend('<span id="'+Zimplit.objectNames.googleSearchScript+'" style="display: none;"></span>');
			}
			if(iFrameWindow.getElementById(Zimplit.objectNames.googleSearchScript)){
				iFrameWindow.getElementById(Zimplit.objectNames.googleSearchScript).innerHTML= Zimplit.Sources.googleSearchScript();
			}
			$(iFrameWindow).find('.'+Zimplit.objectNames.googleSearchBox).html('');
			$(iFrameWindow.documentElement.getElementsByTagName('head')[0]).find('style').each(function (){
				if (this.innerHTML == '.ZGoogleSearchBox .gsc-control { width : 100%; }'){
					$(this).remove();
				}
			});	
		}
		
	},
	
	makeIframe: function (){
		var theDate = new Date();
		var timestamp = theDate.getTime();
		var tempframeName = 'ZtempcontentIframe'+timestamp;
		$(document.body).prepend('<iframe id="'+tempframeName+'" name="'+tempframeName+'Name"></iframe>');
		var iframedoc = frames[tempframeName+"Name"].document;
		iframedoc.open();
		var returnObj = {
			dom: iframedoc,
			id: tempframeName 
		}
		return returnObj;
	},
		
		
	menus: {
		sortMenu: function() { 
			var sortedArray = [];
			for (var i in ZMenuArray){ 
				var tmparray = []; 
				tmparray['index'] = parseInt(ZMenuArray[i]['index']); 
				tmparray['self'] = ZMenuArray[i]['self']; 
				sortedArray.push(tmparray); 
			} 
			sortedArray.sort(function(a, b){return (parseInt(a['index']) - parseInt(b['index']));});
			return sortedArray; 
		},
		
		getSubMenus: function (menuEl,sortedZmenu) {
			var thispage = Zimplit.currentPage();
			var hasSubs = false;
			var elList = '';
			for(var j in sortedZmenu){
				var xJ = sortedZmenu[j]['self'];
				if(ZMenuArray[xJ]['parent'] == menuEl){
					hasSubs = true;
					if(thispage == ZMenuArray[xJ]["self"]){
						elList += '<li class="activeLI"><a href="'+xJ+'" class="activeA">'+ZMenuArray[xJ]["name"]+'</a>'+Zimplit.menus.getSubMenus(xJ,sortedZmenu)+'</li>';
					} else {
						elList += '<li><a href="'+xJ+'" >'+ZMenuArray[xJ]["name"]+'</a>'+Zimplit.menus.getSubMenus(xJ,sortedZmenu)+'</li>';
					}
				}
			} 
			if(hasSubs && (menuEl != GlobZIndexfile)){ elList = '<ul>'+ elList +'</ul>' } 
			return elList;
		},

		insert:{
			allMenu: function(element,mode,styles){
				var thispage = Zimplit.currentPage();
				var sortedZmenu = Zimplit.menus.sortMenu(); 
				var theZmenuAll = ''; 
				for(var i in sortedZmenu){ 
					var xI = sortedZmenu[i]['self']; 
					if(ZMenuArray[xI]['parent'] == '' || ZMenuArray[xI]['parent'] == GlobZIndexfile){
						if(ZMenuArray[xI]['parent'] == ''){
							if(thispage == xI){
								theZmenuAll += '<li class="activeLi ZfirstPage ZfirstLevel"><a href="'+xI+'" class="activeA ZfirstLevel">'+ZMenuArray[xI]["name"]+'</a></li>'; 
							} else {
								theZmenuAll += '<li class="ZfirstPage ZfirstLevel"><a href="'+xI+'" class="ZfirstLevel">'+ZMenuArray[xI]["name"]+'</a></li>'; 
							}
						} else {
							if(thispage == xI){
								theZmenuAll += '<li class="activeLi ZfirstLevel"><a href="'+xI+'" class="activeA ZfirstLevel">'+ZMenuArray[xI]["name"]+'</a>'+Zimplit.menus.getSubMenus(xI,sortedZmenu)+'</li>'; 
							} else {
								theZmenuAll += '<li class="ZfirstLevel"><a href="'+xI+'" class="ZfirstLevel">'+ZMenuArray[xI]["name"]+'</a>'+Zimplit.menus.getSubMenus(xI,sortedZmenu)+'</li>'; 
							}
						}
					} 
				}
				
				if(element == null){
					if(typeof mode != 'undefined'){
						if(mode == 'horizontalDropdown' && typeof styles != 'undefined'){
							return '<ul class="allMenu ZhorizontalDropdown" renderdata="'+styles+'">'+theZmenuAll+'</ul>';		
						}
						
						/* horizontal dropdown menu. styles must be defined in this case can be empty though */
						if(mode == 'verticalDropdown' && typeof styles != 'undefined'){
							return '<ul class="allMenu ZverticalDropdown" renderdata="'+styles+'">'+theZmenuAll+'</ul>';
						}
					} else {
						return theZmenuAll;
					}
					
				} else {
					if(typeof mode != 'undefined'){
						/* horizontal dropdown menu. styles must be defined in this case can be empty though */
						if(mode == 'horizontalDropdown' && typeof styles != 'undefined'){
							$(element).html('<ul class="allMenu ZhorizontalDropdown" renderdata="'+styles+'">'+theZmenuAll+'</ul>');
							Zimplit.menus.horizontalDropdown.init($(element).find('ul.allMenu.ZhorizontalDropdown'));
						}
						
						/* horizontal dropdown menu. styles must be defined in this case can be empty though */
						if(mode == 'verticalDropdown' && typeof styles != 'undefined'){
							$(element).html('<ul class="allMenu ZverticalDropdown" renderdata="'+styles+'">'+theZmenuAll+'</ul>');
							Zimplit.menus.verticalDropdown.init($(element).find('ul.allMenu.ZverticalDropdown'));
						}
					}
				}
				
			}
		},
		
		
		horizontalDropdown: {
			className: 'ZhorizontalDropdown',
			IE: (document.all && (navigator.appVersion.indexOf('MSIE 8')==-1))?true:false,
			style:{
				ul_main: {'display':'block', 'margin':'0', 'padding':'0', 'list-style-type': 'none', 'line-height': '1.5em', 'clear':'both'},
				li_main: {'display':'block', 'float':'left', 'white-space': 'nowrap',  'margin':'0', 'padding':'0', 'overflow':'hidden'},
				a_main: {'display': 'block', 'white-space': 'nowrap', 'padding':'5px', 'margin':'0 1px 0 0', 'text-decoration':'none'},
				ul: {'display': 'block', 'position': 'absolute', 'list-style-type':'none', 'margin':'-0.1em 0 0 0', 'padding':'5px'},
				ul_ul: {'display': 'block', 'list-style-type': 'none', 'margin':'-5px 0 0 0', 'padding':'5px', 'position':'absolute', 'oveflow':'hidden'}
			},
			menu:{
				openMain: function (){
					$(this).children('ul').css('visibility', 'visible');
				},
				closeMain: function(){
					$(this).children('ul').css('visibility','hidden');
					
				},
				openSub: function (){
					var w = $(this).parent().width();
					var h= $(this).height();
					if(Zimplit.menus.horizontalDropdown.IE){
						$(this).children('ul').css('visibility', 'visible');
					} else {
						$(this).children('ul').css({'margin-left':w+'px'}).css('visibility', 'visible');
					}
				}
				
			},
			getWidestA: function(el){
				var w = 0;
				$(el).parent().parent().children('li').children('a').each(function(){
					var tempW = $(this).width();
					w = (tempW>w)?tempW:w;
				});
				return w;
			},
			
			init: function (melement){
				var Els = (typeof melement != 'undefined')?$(melement):$('.'+Zimplit.menus.horizontalDropdown.className);
				Els.each(function (){
					/*prepare styles*/
					var tmpStyles = $(this).attr('renderdata').split(';');
					var theStyles =[];
					for(var i in tmpStyles){
						var tmpStyleSplitter = tmpStyles[i].split(':');
						theStyles[tmpStyleSplitter[0]] = tmpStyleSplitter[1];
					}
					
					/* do default styles and hide elements */
					$(this).css(Zimplit.menus.horizontalDropdown.style.ul_main);
					$(this).children('li').css(Zimplit.menus.horizontalDropdown.style.li_main).each(function(){
						$(this).children('a').css(Zimplit.menus.horizontalDropdown.style.a_main);
						$(this).children('ul').css(Zimplit.menus.horizontalDropdown.style.ul).css('visibility','hidden');
					});
					$(this).find('ul').css('list-style-type','none');
					$(this).find('li').css({'list-style-image':'none', 'overflow':'hidden', 'line-height':'1em'});
					$(this).find('ul ul li').css({'display':'block'});
					$(this).find('ul ul').css(Zimplit.menus.horizontalDropdown.style.ul_ul).css('visibility','hidden');
					$(this).find('ul a').css({'display':'block','clear':'both','overflow':'hidden','float':'left','text-decoration':'none'}).each(function (){
						if($(this).parent().find('ul').length > 0){
							$(this).append(' >');
						}
					});
					if(Zimplit.menus.horizontalDropdown.IE){
						$(this).find('ul a').each(function (){
							var w = Zimplit.menus.horizontalDropdown.getWidestA(this);
							$(this).width(w+15);
						});
					}
					
					/* configure specific styles */
					if (typeof theStyles['textsize'] != 'undefined'){
						$(this).css('font-size',theStyles['textsize']);
					}
					
					if (typeof theStyles['linkcolor'] != 'undefined'){
						$(this).find('a').css('color',theStyles['linkcolor']);							
					}

					if (typeof theStyles['bgcolor'] != 'undefined'){
						$(this).find('ul ul').css('background',theStyles['bgcolor']);
						$(this).children('li').children('a').css('background',theStyles['bgcolor']);
						$(this).children('li').children('ul').css('background',theStyles['bgcolor']);
						
						if (typeof theStyles['hovercolor'] != 'undefined'){
							$(this).find('li').hover(function(){$(this).css('background',theStyles['hovercolor']);},function(){$(this).css('background',theStyles['bgcolor'] );});
						}
					}
					if (typeof theStyles['border'] != 'undefined'){
						$(this).find('ul ul').css('border',theStyles['border']);
						$(this).children('li').children('ul').css('border',theStyles['border']);
					}

					/* bind actions */
					$(this).children('li').bind('mouseover',Zimplit.menus.horizontalDropdown.menu.openMain).bind('mouseout',Zimplit.menus.horizontalDropdown.menu.closeMain);
					$(this).find('ul li').css({'display':'block','clear':'both', 'height':'1em'}).bind('mouseover',Zimplit.menus.horizontalDropdown.menu.openSub).bind('mouseout',Zimplit.menus.horizontalDropdown.menu.closeMain);
				});
			}
		},
		
		verticalDropdown: {
			className: 'ZverticalDropdown',
			IE: (document.all && (navigator.appVersion.indexOf('MSIE 8')==-1))?true:false,
			style:{
				ul_main: {'display':'block','float':'left', 'margin':'0', 'padding':'0', 'list-style-type': 'none', 'background':'#aabbcc','line-height':'1.5em', 'clear':'both'},
				li_main: {'display':'block','float':'none','white-space': 'nowrap',  'margin':'0 0 1px 0', 'padding':'2px 0','overflow':'hidden'},
				a_main: {'display': 'inline', 'white-space': 'nowrap', 'padding':'5px',  'margin':'5px', 'text-decoration':'none'},
				ul: {'display': 'block','position': 'absolute', 'list-style-type': 'none', 'margin':'0 0 0 0', 'padding':'3px', 'background':'#abcabc'},
				ul_ul: {'display': 'block', 'list-style-type': 'none', 'margin':'0 0 0 0', 'padding':'3px', 'position':'absolute' ,  'background':'#abcabc', 'oveflow':'hidden'}
			},
			menu:{
				openMain: function (){
				var w = $(this).parent().width();
				var h= $(this).height();
					if(Zimplit.menus.verticalDropdown.IE){
						$(this).children('ul').css('visibility', 'visible');
					} else {
						$(this).children('ul').css({'margin-left':w+'px','margin-top':'-1.5em'}).css('visibility', 'visible');
					}
				},
				closeMain: function(){
					$(this).children('ul').css('visibility','hidden');
					
				},
				openSub: function (){
					var w = $(this).parent().width();
					var h= $(this).height();
					if(Zimplit.menus.verticalDropdown.IE){
						$(this).children('ul').css('visibility', 'visible');
					} else {
						$(this).children('ul').css({'margin-left':w+'px'}).css('visibility', 'visible');
					}
				}
				
			},
			getWidestA: function(el){
				var w = 0;
				$(el).parent().parent().children('li').children('a').each(function(){
					var tempW = $(this).width();
					w = (tempW>w)?tempW:w;
				});
				return w;
			},
			
			init: function (melement){
				var Els = (typeof melement != 'undefined')?$(melement):$('.'+Zimplit.menus.verticalDropdown.className);
				Els.each(function (){
					/*prepare styles*/
					var tmpStyles = $(this).attr('renderdata').split(';');
					var theStyles =[];
					for(var i in tmpStyles){
						var tmpStyleSplitter = tmpStyles[i].split(':');
						theStyles[tmpStyleSplitter[0]] = tmpStyleSplitter[1];
					}
					
					/* do default styles and hide elements */
					$(this).css(Zimplit.menus.verticalDropdown.style.ul_main);
					$(this).children('li').css(Zimplit.menus.verticalDropdown.style.li_main).each(function(){
						$(this).children('a').css(Zimplit.menus.verticalDropdown.style.a_main);
						$(this).children('ul').css(Zimplit.menus.verticalDropdown.style.ul).css('visibility','hidden');
					});
					$(this).find('ul').css('list-style-type','none');
					$(this).find('li').css({'list-style-image':'none', 'overflow':'hidden', 'display':'block','float':'none', 'line-height':'1.1em', 'padding':'2px 0'});
					$(this).find('ul ul li').css({'display':'block'});
					$(this).find('ul ul').css(Zimplit.menus.verticalDropdown.style.ul_ul).css('visibility','hidden');
					$(this).find('ul a').css({'display':'block','clear':'both','overflow':'hidden','float':'left','text-decoration':'none'}).each(function (){
						if($(this).parent().find('ul').length > 0){
							$(this).append(' >');
						}
					});
					if(Zimplit.menus.verticalDropdown.IE){
						$(this).find('ul a').each(function (){
							var w = Zimplit.menus.verticalDropdown.getWidestA(this);
							$(this).width(w+15);
						});
					}
					
					/* configure specific styles */
					if (typeof theStyles['textsize'] != 'undefined'){
						$(this).css('font-size',theStyles['textsize']);
					}
					
					if (typeof theStyles['linkcolor'] != 'undefined'){
						$(this).find('a').css('color',theStyles['linkcolor']);
						
					}
					
					if (typeof theStyles['bgcolor'] != 'undefined'){
						$(this).find('ul').css('background',theStyles['bgcolor']);
						$(this).css('background',theStyles['bgcolor']);
						if (typeof theStyles['hovercolor'] != 'undefined'){
							$(this).find('li').hover(function(){$(this).css('background',theStyles['hovercolor']);},function(){$(this).css('background',theStyles['bgcolor'] );});
						}
					}
					if (typeof theStyles['border'] != 'undefined'){
						$(this).find('ul ul').css('border',theStyles['border']);
						$(this).children('li').children('ul').css('border',theStyles['border']);
					}

					/* bind actions */
					$(this).children('li').bind('mouseover',Zimplit.menus.verticalDropdown.menu.openMain).bind('mouseout',Zimplit.menus.verticalDropdown.menu.closeMain);
					$(this).find('ul li').css({'display':'block','clear':'both', 'height':'1em'}).bind('mouseover',Zimplit.menus.verticalDropdown.menu.openSub).bind('mouseout',Zimplit.menus.verticalDropdown.menu.closeMain);
				});
			}
		}
	},
	
	
	
	
	template: {
		rewriteView: function (el){
			el.contentWindow.ZChangeTemplate = function(templaddr){
				window.top.Zimplit.template.change(templaddr);
				
			}
			$(el.contentWindow.document).find('#main').hide();
			$(el.contentWindow.document).find('#contentbox').attr('style','width:770px;').find('.LeftBox').hide();
			$(el.contentWindow.document).find('#contentbox .RightBox').attr('style','width:760px;');
			$(el.contentWindow.document).find('#ZdesignFromUrlForm').hide();
			$(el.contentWindow.document).find('#ZimplitRootBody').css('background','none');
			$('#ZTemplateViewLoader').hide();
			$('#ZTemplateViewArea').show();
		},
		
		getContentClass: function(el){
			var returnClass = null;
			var theClasses = Zimplit.getClassNames(el);
			for(var i in theClasses){
				if(theClasses[i].indexOf('ZContentType_') >-1){
					returnClass = theClasses[i];
				}
			}
			return returnClass;
		},
		
		
		doSubTemplates: function (html_files, defaultHtml){
			if(html_files.length>0){
				var theHtml = html_files.shift();
				var theDate = new Date();
				var timestamp = theDate.getTime();
				$.ajax({
					url: theHtml+'?t='+timestamp,
					type: 'GET',
					dataType: 'html',
					async: false,
					success: function(data4){
						/* find old data */
						var contentDataHtml =[];
						$(data4).find('.ZEditableArea').each(function(){
							var contentClassHtml = Zimplit.template.getContentClass(this);
							if(contentClassHtml  != null) {
								var chtml1 = $(data4).find('.'+contentClassHtml).html();
								contentDataHtml.push({content: contentClassHtml , data: chtml1});
							}
						});

						var ifr = Zimplit.makeIframe();
						ifr.dom.write(defaultHtml);
						
						
						function handler(event) {
							var ifr = event.data.iframe;
							var contentDataHtml= event.data.content;
							var theHtml = event.data.htmlfile;
							var defaultHtml =event.data.srchtml;
							var html_files = event.data.files;
							for( var j in contentDataHtml){
								$(ifr.dom.body).find('.'+contentDataHtml[j].content).html(contentDataHtml[j].data);
							}
							var theSrc2 = Zimplit.prepare.iframeForSave(ifr.dom);
							
							$('#'+ifr.id).remove();
							var theFile2 =theHtml;
						
							/*save*/
							$.ajax({
								url: ZphpName+"?action=saveE&file="+theFile2+"",
								type: 'POST',
								data: {html: encodeURIComponent(theSrc2).replace(/\'/gi,"%27")},
								dataType: 'html',
								async: false,
								success: function(dataBack2){
									/* in futre catch errors here if present */
									Zimplit.template.doSubTemplates(html_files,defaultHtml);
								}
							});
						}
						
						$("#"+ifr.id).bind("load", {iframe: ifr,content:contentDataHtml,htmlfile:theHtml,srchtml:defaultHtml,files:html_files}, handler);
						//$('#'+ifr.id).get(0).onload= function(ifr,contentDataHtml,theHtml,defaultHtml,html_files){
						ifr.dom.close();
													
						
					}
				});
			} else {
				window.location.reload();
			}
			
		},
		
		
		
		withNewPage: function (pageName){
			$('#ZTemplateViewLoader').show();
			$('#ZTemplateViewArea').hide();
			var thispage = Zimplit.currentPage();
			
			$.ajax({
				type: 'GET',
				url: ZphpName+'?action='+actionFunction+'&file='+templaddr,
				dataType: 'html',
				async: false,
				success: function(data2) {
				
				}
			});
			
		},

		change: function(templaddr, mode){
			$('#ZTemplateViewLoader').show();
			$('#ZTemplateViewArea').hide();
			
			/* get all html files in menu without index.html */
			var html_files = [];
			for (var i in ZMenuArray){
				if(ZMenuArray[i]["self"] != 'index.html'){
					html_files.push(ZMenuArray[i]["self"]);
				}
			}
			
			/* load old index file to read its contents for substitution to new template*/
			$.ajax({
				url: 'index.html',
				type: 'GET',
				dataType: 'html',
				async: false,
				success: function(data){
					var contentData =[];
					
					/* get index file old contents */ 
					$(data).find('.ZEditableArea').each(function(){
						var contentClass = Zimplit.template.getContentClass(this);
						if(contentClass != null) {
							var chtml = $(data).find('.'+contentClass).html();
							contentData.push({content: contentClass, data: chtml});
						}
					});
					
					/* download the new template */
					
					var actionFunction = 'gettemplate';
					if (mode){
						if(mode=='userdefined'){ 
					
							templaddr = $('#downloadAPage').val();
							actionFunction = 'downloadHtmlTemplate';
							if((templaddr.substring(0,7).toLowerCase() != 'http://')&&(templaddr.substring(0,8).toLowerCase() != 'https://')){
								templaddr = 'http://'+templaddr;
							}
						}
					}

					$.ajax({
						type: 'GET',
						url: ZphpName+'?action='+actionFunction+'&file='+templaddr,
						dataType: 'html',
						async: false,
						success: function(data2) {
						//	if(data2 == '1'){
								
								/* get new html and its contents to insert old data */
								var theDate = new Date();
								var timestamp = theDate.getTime();
								$.ajax({
									url: 'index.html?t='+timestamp,
									type: 'GET',
									dataType: 'html',
									async: false,
									success: function(indexHtml){
								
										var iframe1 = Zimplit.makeIframe();
										iframe1.dom.write(indexHtml);
									
										function handler(event) {
											var iframe1 = event.data.iframe;
											var contentData= event.data.content;
											var oDoc = $('#'+iframe1.id).get(0).contentWindow.document;
											
											for( var j in contentData){
												$(oDoc.body).find('.'+contentData[j].content).html(contentData[j].data);
											}
											var theSrc = Zimplit.prepare.iframeForSave(oDoc);
											
											$('#'+iframe1.id).remove();
											var theFile ='index.html';
										
											$.ajax({
												url: ZphpName+"?action=saveE&file="+theFile+"",
												type: 'POST',
												data: {html: encodeURIComponent(theSrc).replace(/\'/gi,"%27")},
												dataType: 'html',
												async: false,
												success: function(dataBack){
													/* function to rewrite all subpages to new template with old content */
										
													Zimplit.template.doSubTemplates(html_files,indexHtml);
												}
											});
										}
										
										$("#"+iframe1.id).bind("load", {iframe: iframe1,content:contentData}, handler);
										iframe1.dom.close();
						
									}
								});
								
								
						//	} else { alert(data2);}
						}
					});
					
				}
			});

			/*
			
			*/
		}
	},
	
	popups: {
		changeTemplate: function(){
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$(document.body).prepend(Zimplit.Sources.changeTemplatePop());
			$("#ZMainOverlay").show();
			$('#ZChangeTemplate').css('top', (($(window).height()/2)-($('#ZChangeTemplate').height()/2))+$(window).scrollTop() + 'px');
			$('#ZChangeTemplate').css('left', (($(window).width()/2)-($('#ZChangeTemplate').width()/2)) + 'px');
			$('#ZChangeTemplate').draggable();
		},
		
		 templatesView: function(){
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$(document.body).prepend(Zimplit.Sources.templateView());
			$("#ZMainOverlay").show();
			var thetop = (($(window).height()/2)-($('#ZTemplateView').height()/2))+$(window).scrollTop();
			thetop = (thetop<10)?10:thetop;
			
			$('#ZTemplateView').css('top', thetop + 'px');
			$('#ZTemplateView').css('left', (($(window).width()/2)-($('#ZTemplateView').width()/2)) + 'px');
		 },
		 
		 fileManager: function(){
			$('.ZpopupScreen').not('#zimplitMenu').remove();
			$(document.body).append(Zimplit.Sources.fileManager());
			$("#ZMainOverlay").show();
			Zimplit.files.drawList();
			$('#ZFileManager').css('top', (($(window).height()/2)-($('#ZFileManager').height()/2))+$(window).scrollTop() + 'px');
			
			$('#ZFileManager').css('left', (($(window).width()/2)-($('#ZFileManager').width()/2)) + 'px');
		 }
	},
	
	files:{
		drawList: function(theFolder,path){
			var fileicons = [
				{ext: '.htm', pic: 'fileIconhtml.gif'},
				{ext: '.css', pic: 'fileIconcss.gif'},
				{ext: '.js', pic: 'fileIconscript.gif'},
				{ext: '.gif', pic: 'fileIconimg.gif'},
				{ext: '.jpg', pic: 'fileIconimg.gif'},
				{ext: '.jpeg', pic: 'fileIconimg.gif'},
				{ext: '.png', pic: 'fileIconimg.gif'},
				{ext: '.bmp', pic: 'fileIconimg.gif'}
			];
			var theFolder = (theFolder)?theFolder:'';
			var path = (path)?path+'/':'';
			if(theFolder == '.'){path='';};
			if(theFolder == '..'){
				path=path.split('/../')[0];
				path = path.substring(0,path.lastIndexOf('/'))+'/';
			};
			
			if(path=='/'){path= '';}
			var theFolderAction = (path != '')?'&file='+path:'' ;
			//if(theFolderAction == '&file='){theFolderAction = '';}
			$.ajax({
				type: 'GET',
				url: ZphpName+'?action=listAllFiles'+theFolderAction,
				dataType: 'html',
				async: false,
				success: function(data) {
					var filesArrTmp = data.split(';');
					var filesArr = [];
					var dirsArr = [];
					for(var i in filesArrTmp){
						var fileTmp = filesArrTmp[i].split('|');
						if(fileTmp[1] == 'dir'){
							dirsArr.push(fileTmp[0]);
						} else {
							filesArr.push(fileTmp[0]);
						}
					}
					
					var theHtml = '';
					for (var i in dirsArr){
						var deldir = (dirsArr[i]!='.' && dirsArr[i] != '..')?'<a href="javascript:void(0);" onclick="Zimplit.files.deleteFile(\''+dirsArr[i]+'\',\''+path+'\',\'FileManager\');"><img src="'+ZLinksToImages.imgSmallTrash+'" alt="'+langTexts["properties_filemanager_deletedir"]+'" title="'+langTexts["properties_filemanager_deletedir"]+'" /></a>':'';
						theHtml += '<div class="ZFMIcon">'+
												'<a href="javascript:void(0);" onclick="Zimplit.files.drawList(\''+dirsArr[i]+'\',\''+path+dirsArr[i]+'\');">'+
													'<img src="'+ZimplitEditorLocation+'images/directoryIcon.gif" alt="" />'+
												'</a> '+	
												deldir+	
												'<br/>'+
												dirsArr[i]+
											'</div>';
					}
					for (var i in filesArr){
						var ficon = 'fileIcon.gif';
						var isPic = false;
						if((filesArr[i].toLowerCase().indexOf('.jpg')>-1)||(filesArr[i].toLowerCase().indexOf('.jpeg')>-1)||(filesArr[i].toLowerCase().indexOf('.gif')>-1)||(filesArr[i].toLowerCase().indexOf('.png')>-1)||(filesArr[i].toLowerCase().indexOf('.bmp')>-1)){
							isPic = true;
						}
						for(var j in fileicons){
							if(filesArr[i].toLowerCase().indexOf(fileicons[j].ext)>-1){
								ficon = fileicons[j].pic;
							}
						}
						
						var Filelink = 'javascript:void(0);';
						var onCLink = '';
						if(isPic){
							if(IE){
								onCLink = 'window.open(\''+path+filesArr[i]+'\', \'_blank\' ,\''+langTexts["properties_filemanager_imgpreview"]+'\',\'menubar=0,resizable=1,width=350,height=250\');';
							} else {
								onCLink = 'window.open(\''+path+filesArr[i]+'\' ,\''+langTexts["properties_filemanager_imgpreview"]+'\',\'menubar=0,resizable=1,width=350,height=250\');';
							}
						}
						
						
						theHtml += '<div class="ZFMIcon">'+
												'<a href="'+Filelink+'" onclick="'+onCLink+'">'+
													'<img src="'+ZimplitEditorLocation+'images/'+ficon+'" alt="" />'+
												'</a> '+	
												'<a href="javascript:void(0);" onclick="Zimplit.files.rename(\''+filesArr[i]+'\',\''+path+'\',\'FileManager\');">'+
													'<img src="'+ZimplitEditorLocation+'images/menuRename.gif" alt="'+langTexts["properties_filemanager_renamefile"]+'" title="'+langTexts["properties_filemanager_renamefile"]+'" style="vertical-align:middlle;" />'+
												'</a> '+
												'<a href="javascript:void(0);" onclick="Zimplit.files.deleteFile(\''+filesArr[i]+'\',\''+path+'\',\'FileManager\');">'+
													'<img src="'+ZLinksToImages.imgSmallTrash+'" alt="'+langTexts["properties_filemanager_deletefile"]+'" title="'+langTexts["properties_filemanager_deletefile"]+'" style="vertical-align:middlle;" />'+
												'</a>'+
												'<br/>'+
												'<a href="'+Filelink+'" onclick="'+onCLink+'">'+
													filesArr[i]+
												'</a>'+
											'</div>';
					}
					$('#ZFileManagerArea').html(theHtml);
					$('#ZFileManagerPath').html(langTexts["properties_filemanager_currentpath"]+' '+path);
				}
			});
		},
		
		deleteFile: function(fileaddr,curpath,method){
			var doDelete = confirm(langTexts["confirm_delete"]+" "+fileaddr,+"?")
			if(doDelete){
				if(method == 'FileManager'){
					$.ajax({
						type: 'GET',
						url: ZphpName+"?action=delete&file="+curpath+fileaddr,
						dataType: 'html',
						async: true,
						success: function(data) {
							if(data != '1'){
								alert(data);
							} else {
								Zimplit.files.drawList('',curpath.substring(0,curpath.lastIndexOf('/')));
							}
						}
					});
				}
			}
		},
		
		rename: function(fileaddr,curpath,method){
			if(method == 'FileManager'){
				var newName = prompt(langTexts["properties_filemanager_renamefile"]+": ", fileaddr);
				if(newName != null){
					$.ajax({
						type: 'GET',
						url: ZphpName+"?action=rename&oldname="+curpath+fileaddr+"&newname="+curpath+newName,
						dataType: 'html',
						async: true,
						success: function(data) {
							if(data != '1'){
								alert(data);
							} else {
								Zimplit.files.drawList('',curpath.substring(0,curpath.lastIndexOf('/')));
							}
						}
					});
				}
			}
		}
	},

	initFunctions: {
	
		checkBrowserCompability: function(){
			if(OPERA){ alert(langTexts["error_browser_opera"]); }
		},
	
		checkMenuJsExistance: function (){
			/* if you dont have a menu js created jet it will be now
				new php does not require this (allready implemented into php) but it does nor hurt to recheck*/
			$.post(ZphpName+"?action=new&file=Zmenu.js", { empty: 'empty'}, function(data){
				if(data == 1){
					var SrcText = 'var ZMenuArray = []; \n';
					$.post(ZphpName+"?action=listfiles", { empty: 'empty'},
					function(data){
						var filesArray = data.split(';');
						for(var i=0; i < filesArray.length; i++){
							var fileAndTitle = filesArray[i].split('|');
							var thefile = fileAndTitle[0];
							var thetitle = fileAndTitle[1];
							if(thefile == GlobZIndexfile){
								SrcText += 'ZMenuArray["'+thefile+'"] = [];\n'+
										'ZMenuArray["'+thefile+'"]["name"] = "'+thetitle+'";\n'+
										'ZMenuArray["'+thefile+'"]["parent"] = "";\n'+
										'ZMenuArray["'+thefile+'"]["self"] = "'+thefile+'";\n'+
										'ZMenuArray["'+thefile+'"]["index"] = "'+i+'";\n';
							}
						}
						var scriptbottom = ZMenuScriptbottom;
						SrcText += scriptbottom;
						$.post(ZphpName+"?action=saveE&file=Zmenu.js", { html: encodeURIComponent(SrcText).replace(/\'/gi,"%27")},
						function(data2){
							document.location.reload();
						});
					});
				}
			});
		},
		
		checkSettingsJsExistance: function (){
			/* if you dont have a settings js created jet it will be now
				new php does not require this (allready implemented into php) but it does nor hurt to recheck*/
			$.post(ZphpName+"?action=new&file=Zsettings.js", { empty: 'empty'}, function(data){
				if(data == 1){
					var theContent = 	'ZmaxpicZoomW = "150"; \n'+
												'ZmaxpicZoomH = "150"; \n'+
												'ZmaxpicW = "800"; \n'+
												'ZmaxpicH = "800"; \n';				
					$.post(ZphpName+"?action=saveE&file=Zsettings.js", { html: encodeURIComponent(theContent)}, function(data2){
							window.location.reload();
					});
				}
			});
		},
		
		isHtmlWritable: function(){
			var theFile = $('#zimplitPage').attr('src').split('?')[0];
			$.ajaxSetup({async: false});
			$.post(ZphpName+"?action=iswriteble&file="+theFile+"", { empty: 'empty'}, function(data){
				if(data == 1){
					alert(langTexts["error_htmlnotwriteble"]+' '+theFile);
					Zimplit.globals.canWriteHtml=false;
				} else { 
					Zimplit.globals.canWriteHtml=true;
				}
			});
		},
		
		/* draw editor main menu */
		drawMenu: function(){
			
			$(document.body).prepend(Zimplit.Sources.editor);
			ZimplitMenu = $('#zimplitMenu');
			ZimplitMenu.draggable({
				start: function(){
					ZmenuSubmenuPopRemove();
				}
			});
			Zimplit.eventFunctions.mouseScroll();
			
		}
		
	},
	
	eventFunctions: {
	
		/* scrolling window moves the menu */
		mouseScroll: function(){
			if(!OTHERBROWSER){
				window.onscroll = function(){ 
					if($(window).scrollTop() > (ZimplitMenu.offset().top +10)){
						ZimplitMenu.css('top',$(window).scrollTop()+ 10 + 'px');
					}
					if(($(window).scrollTop() + $(window).height() - 60) < (ZimplitMenu.offset().top)){
						ZimplitMenu.css('top',$(window).scrollTop() + $(window).height() -60  + 'px');
					}
				}
			} else {
				
			}
		},

		clickOnPage: function(){
			ZmenuSubmenuPopRemove();
			var curentCursor = Zimplit.blinker.selection.get();
			Zimplit.blinker.clear();
			
			Zimplit.check.clickInUnEditable(curentCursor);
		}
		
	},
	
	blinker: {
		selection: {
			get: function (){
				var sel = null; 
				var theHtml = new Array();
				var  rng = null;
				if(IE){ 
					rng = ZimplitPage.selection.createRange();
					theHtml[1] = rng.htmlText;
					theHtml[0] = null;
					theHtml[2] = null;
				} else { 
					sel = ZimplitPageOut.getSelection(); 
					rng = getRangeObject(sel); 
					theHtml = ZFFGetBetweenSel();
					
				}
				return {selection:sel, range:rng, html: theHtml[1], src_before: theHtml[0], src_after: theHtml[2]};
			},
			
			
		
			set: function(content){
				if(IE){
					rng = ZimplitPage.selection.createRange();
					rng.pasteHTML(content+_blinker);
					rng.collapse(false);
					ZisSelection = false;
				}
				if(!IE){
					ZimplitPage.body.innerHTML = content[0]+content[1]+content[2];
					//ZreplaceSelectionContent(content);
				//	ZFFSetSelectionContent(content);
					ZisSelection = false;				
				}
			}
		},
		
		split: function (mode){
			var edmode = (mode)?mode:'';
			
			var answ = new Object();

			if(edmode == 'global'){
				if(ZeditableAreasMode){
					answ.element = ($(ZBlinker()).parents('.'+ZEditableAreaClass).length > 0)?$(ZBlinker()).parents('.'+ZEditableAreaClass).get(0): null;
				} else {
					answ.element = ZimplitPage.body;
				}
			} else {
				var blinkerParentEl = ZBlinker().parentNode;
				answ.element = ($(blinkerParentEl).hasClass(ZEditableAreaClass)||(ZimplitPage.body == blinkerParentEl))? blinkerParentEl : null;
				answ.element = (answ.element == null)? blinkerParentEl.parentNode : answ.element;
			}
			/*if ((ZeditableAreasMode&&($(ZBlinker()).parents('.'+ZEditableAreaClass).length == 0))|| ($(ZBlinker()).parents(ZimplitPage.body).length == 0)){
				answ.element = null;
			}*/
			
			if(answ.element != null){
				var contentSrc = answ.element.innerHTML;
				var content = [];
		
				var blinkerSrc = (IE)?ZBlinker().outerHTML:$(ZBlinker()).outerHTML();
				if(contentSrc.indexOf(blinkerSrc) > -1){
					content = contentSrc.split(blinkerSrc);
				}
				answ.src_before = content[0];
				answ.src_after = content[1];
				return answ;
			} else {
				
			}
		},
	
		
		clear: function(){
			if(ZimplitPage.getElementById('ZimplitBlinker')) {$(ZimplitPage.getElementById('ZimplitBlinker')).remove();}
		},
		
		insert: function (theHtml, mode){
			
			var doit = true;
			var thenotallowedEl ='';
			if (typeof mode != 'undefined'){
				if(mode == 'block'){	
					var notAllowedTags = new Array('a','span','ul');
					$(ZBlinker()).parents().each(function(){
						for(var tag in notAllowedTags){
							if(this.tagName.toLowerCase() == notAllowedTags[tag]){
								doit = false;
								thenotallowedEl = this.tagName;
								
							}
						}
					});
				}
			}
			if(ZcheckBlinkerIsInEditable()&&ZBlinker()){
				if(doit){
					$(ZBlinker()).before(theHtml);
				} else {
					$(ZBlinker()).parents(thenotallowedEl+':last').eq(0).before(theHtml);
				}
			}
		}
	}
}
var ZlogoSmall = <?php if(file_exists('logo/logo_2.gif')){echo '\'<img src="\'+ZimplitEditorLocation+\'logo/logo_2.gif" alt="" />\'';} else {echo "''";}?>;

<?php
	include('zimplit_views.js');
	echo "\n";
	include('zimplit_gui.js');
?>

function ZinitPageEvents(){
	 window.onresize = ZIfWindowIsResized;
	if(OPERA){ZimplitPage.body.contentEditable = true; }
	 ZimplitPage.onmouseup = function() { 
		window.parent.ZClickInEditable();	
		 doTheResize= false;
	}
	
	ZimplitPage.onkeydown = function(e) {
		if(IE){if (window.parent.ZisFunctionKey(ZKeyCode(e)) || ZimplitPageOut.event.ctrlKey) { window.parent.ZFunctionKey(ZKeyCode(e));  return false; }}
		if(!IE){ if (window.parent.ZisFunctionKey(ZKeyCode(e)) || e.ctrlKey) { window.parent.ZFunctionKey(ZKeyCode(e)); return false;  }}
		
	}
	
	ZimplitPage.onkeypress = function(e) {
		if(IE){if(!window.parent.ZisFunctionKey2(ZKeyCode(e))) { window.parent.ZInsertChar(ZKeyCode(e));   return false;}}
		if(!IE){if(!window.parent.ZisFunctionKey2(ZKeyCode(e)) && (!e.ctrlKey)) { window.parent.ZInsertChar(ZKeyCode(e));  } return false;}
		
	}
	
	// just in case
	ZimplitPage.onkeyup = function(e) {return false;};
	
	// getting mouse position
   $(ZimplitPage).mousemove(function(e){
	if(typeof Zimplit != 'undefined'){
      Zimplit.globals.mouse.x= e.pageX;
	  Zimplit.globals.mouse.y = e.pageY;
	 }
   }); 
   
   if(!IE){
	
		document.onkeydown = function(e) {
			if(!e) var e = window.event;
			if(ZKeyCode(e)==8 || ZKeyCode(e)==13) {
				var regRule1 = /input/i;
				var ans1 = (regRule1.test(e.target)) ? true : false;
				var regRule2 = /textarea/i;
				var ans2 = (regRule2.test(e.target)) ? true : false;
				if(ans1 || ans2){
					
				} else {
				
					return false;
					
				}
			}
		}
		
		document.onkeyup = function(e) {
			if(!e) var e = window.event;
				if(ZKeyCode(e)==8 || ZKeyCode(e)==13) {
				var regRule1 = /input/i;
				var ans1 = (regRule1.test(e.target)) ? true : false;
				var regRule2 = /textarea/i;
				var ans2 = (regRule2.test(e.target)) ? true : false;
				if(ans1 || ans2){
				
				} else {
				
					return false;
				}
			}
		}
		
		document.onkeypress = function(e) {
				if(ZKeyCode(e)==8 || ZKeyCode(e)==13) {
				var regRule1 = /input/i;
				var ans1 = (regRule1.test(e.target)) ? true : false;
				var regRule2 = /textarea/i;
				var ans2 = (regRule2.test(e.target)) ? true : false;
				if(ans1 || ans2){
				
				} else {
					
					return false;
				}
			}
		}
		
	}
   
}


var endImgResize = false;

function ready() {
	Zimplit.initFunctions.checkBrowserCompability();
	Zimplit.initFunctions.isHtmlWritable();
	
	Zimplit.initFunctions.checkMenuJsExistance();
	Zimplit.initFunctions.checkSettingsJsExistance();
	
	Zimplit.GUI.overlay.init();
	Zimplit.initFunctions.drawMenu();
	Zimplit.GUI.sideMenu.init();
	
}	
<?php } else {echo '';} ?>
