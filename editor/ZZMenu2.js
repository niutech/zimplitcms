/* the location of this document */ zdocloc = "http://www.zimplit.org/designs.php"; 
	if (zdocloc.charAt(zdocloc.length -1) == '/'){ 
		var thispage = GlobZIndexfile; /* if doclocation without html file */ 
	} else { 
		if(document.location.href.indexOf('#') != -1){
			var thispage = document.location.href.substring(document.location.href.lastIndexOf('/')+1,document.location.href.indexOf('#')); 
		} else { 
			var thispage = document.location.href.substring(document.location.href.lastIndexOf('/')+1,document.location.href.length); 
		} 
	} /* __the location of this document */ 
	
var thispage = "designs.php";	

function sortZmenu() { 
	var sortedArray = []; 
	function ZSwapEls(el1, el2) { 
		var eltmp = sortedArray[el1]; 
		sortedArray[el1] = sortedArray[el2]; 
		sortedArray[el2] = eltmp; 
	} 
	for (var i in ZMenuArray){ 
		var tmparray = []; 
		tmparray['index'] = parseInt(ZMenuArray[i]['index']); 
		tmparray['self'] = ZMenuArray[i]['self']; 
		sortedArray.push(tmparray); 
	} 
	
	var ZshouldRepeat = false; 
	function sortingTurn(){ 
		if (ZshouldRepeat) { 
			ZshouldRepeat = false; 
		} var lastsortEl = ''; 
		var lastsortElNr = ''; 
		for (var i in sortedArray){ 
			if (lastsortEl != ''){ 
				if (sortedArray[i]['index'] < lastsortElNr){
					ZSwapEls(i,lastsortEl); ZshouldRepeat = true; 
				} else {
					var lastsortEl = i; var lastsortElNr = sortedArray[i]['index']; 
				} 
			} else {
				var lastsortEl = i;
				var lastsortElNr = sortedArray[i]['index']; 
			} 
		} 
		if (ZshouldRepeat) { sortingTurn(); } 
	} 
	sortingTurn(); 
	return sortedArray; 
} 

var sortedZmenu = sortZmenu(); 
function ZSubmenus(menuEl) {
	var hasSubs = false;
	var elList = '';
	for(var j in sortedZmenu){
		var xJ = sortedZmenu[j]['self'];
		if(ZMenuArray[xJ]['parent'] == menuEl){
			hasSubs = true;
			if(thispage == ZMenuArray[xJ]["self"]){
				elList += '<li class="activeLI"><a href="'+xJ+'" class="activeA">'+ZMenuArray[xJ]["name"]+'</a>'+ZSubmenus(xJ)+'</li>';
			} else {
				elList += '<li><a href="'+xJ+'" >'+ZMenuArray[xJ]["name"]+'</a>'+ZSubmenus(xJ)+'</li>';
			}
		}
	} 
	if(hasSubs && (menuEl != GlobZIndexfile)){ elList = '<ul>'+ elList +'</ul>' } 
	return elList; 
} 

function ZinsMenuL(){ 
	var theZmenu1 = ''; 
	var theZmenu2 = ''; 
	var theZmenu3 = ''; 
	var theZmenu4 = ''; 
	
	/* menu L1 */ theZmenu1 = ''; 
	for(var i in sortedZmenu){ 
		var xI = sortedZmenu[i]['self']; 
		if(ZMenuArray[xI]['parent'] == '' || ZMenuArray[xI]['parent'] == GlobZIndexfile){
			if(thispage == xI){
				if( ZMenuArray[xI]['parent'] == ''){
					theZmenu1 += '<a href="'+xI+'" class="activeA ZrootPage">'+ZMenuArray[xI]["name"]+'</a> &nbsp;&nbsp;'; 
				} else {
					theZmenu1 += '<a href="'+xI+'" class="activeA">'+ZMenuArray[xI]["name"]+'</a> &nbsp;&nbsp;'; 
				}
			} else {
				if( ZMenuArray[xI]['parent'] == ''){
					theZmenu1 += '<a href="'+xI+'" class="ZrootPage">'+ZMenuArray[xI]["name"]+'</a> &nbsp;&nbsp;'; 
				} else {
					theZmenu1 += '<a href="'+xI+'">'+ZMenuArray[xI]["name"]+'</a> &nbsp;&nbsp;'; 
				}
			}
		} 
	} 
	/* __menu L1*/ 
	
	/* menu L1Li */ theZmenu1_li = ''; 
	for(var i in sortedZmenu){ 
		var xI = sortedZmenu[i]['self']; 
		if(ZMenuArray[xI]['parent'] == '' || ZMenuArray[xI]['parent'] == GlobZIndexfile){
			if(thispage == xI){
				if(ZMenuArray[xI]['parent'] == ''){
					theZmenu1_li += '<li class="activeLi ZrootPage"><a href="'+xI+'" class="activeA ZrootPage">'+ZMenuArray[xI]["name"]+'</a></li>'; 
				} else {
					theZmenu1_li += '<li class="activeLi"><a href="'+xI+'" class="activeA">'+ZMenuArray[xI]["name"]+'</a></li>'; 
				}
			} else {
				if(ZMenuArray[xI]['parent'] == ''){
					theZmenu1_li += '<li class="ZrootPage" ><a href="'+xI+'" class="ZrootPage">'+ZMenuArray[xI]["name"]+'</a></li>';
				} else {
					theZmenu1_li += '<li><a href="'+xI+'">'+ZMenuArray[xI]["name"]+'</a></li>';
				}
			}
		} 
	} 
	/* __menu L1Li*/ 
	
	/* all menu*/ theZmenuAll = ''; 
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
					theZmenuAll += '<li class="activeLi ZfirstLevel"><a href="'+xI+'" class="activeA ZfirstLevel">'+ZMenuArray[xI]["name"]+'</a>'+ZSubmenus(xI)+'</li>'; 
				} else {
					theZmenuAll += '<li class="ZfirstLevel"><a href="'+xI+'" class="ZfirstLevel">'+ZMenuArray[xI]["name"]+'</a>'+ZSubmenus(xI)+'</li>'; 
				}
			}
		} 
	} 
	/* __all menu*/ 
	
	/* menu L2 */ theZmenu2 = ''; 
	for(var i in sortedZmenu){ 
		var xI = sortedZmenu[i]['self']; 
		if(ZMenuArray[xI]['self'] == thispage || ZMenuArray[xI]['parent'] == ZMenuArray[thispage]['parent'] || (xI == GlobZIndexfile && ZMenuArray[thispage]['parent'] == GlobZIndexfile)){ 
			if(xI == thispage){ 
				theZmenu2 += '<li class="activeLI"><a href="'+xI+'" class="activeA">'+ZMenuArray[xI]['name']+'</a>'+ZSubmenus(xI)+'</li>'; 
			} else { 
				theZmenu2 += '<li><a href="'+xI+'">'+ZMenuArray[xI]['name']+'</a></li>'; 
			} 
		} 
	} /* __menu L2 */ 
	
	/* menu L3 */ theZmenu3 =''; 
	if(ZMenuArray[thispage]['parent']== ''){ 
		for(var i in sortedZmenu){ 
			var xI = sortedZmenu[i]['self']; 
			if (ZMenuArray[xI]['parent']== ''){ 
				if(thispage==ZMenuArray[xI]['self']){
					theZmenu3 += '<li class="activeLi"><a href="'+xI+'"  class="activeA">'+ZMenuArray[xI]["name"]+'</a></li>'; 
				} else {
					theZmenu3 += '<li><a href="'+xI+'">'+ZMenuArray[xI]["name"]+'</a></li>'; 
				}
			} else if (ZMenuArray[xI]['parent'] == GlobZIndexfile){
				if(ZMenuArray[xI]['self'] == thispage){
					theZmenu3 += '<li class="activeLi"><a href="'+xI+'" class="activeA">'+ZMenuArray[xI]["name"]+'</a>'+ZSubmenus(xI)+'</li>'; 
				} else { 
					theZmenu3 += '<li><a href="'+xI+'" >'+ZMenuArray[xI]["name"]+'</a></li>'; 
				} 
			} 
		} 
	} else {
		for(var i in sortedZmenu){ 
			var xI = sortedZmenu[i]['self']; 
			if(ZMenuArray[xI]['parent'] == thispage){ 
				theZmenu3 += '<li><a href="'+xI+'">'+ZMenuArray[xI]['name']+'</a>'+ZSubmenus(xI)+'</li>'; 
			} 
		} 
	} /* __menu L3 */ 
	
	/* second level and up */
	
	
	function ZgetHigherLevelOfThis(){
			var thehigherlevel = '';
			function ZgettingHigherLevel(ZlevelData){
				if (ZMenuArray[ZlevelData]['parent'] == ''){
				
				} else if (ZMenuArray[ZlevelData]['parent'] == GlobZIndexfile) {
					thehigherlevel = ZlevelData;
				} else {
					ZgettingHigherLevel(ZMenuArray[ZlevelData]['parent']);
				}
			}
			ZgettingHigherLevel(thispage);
			return thehigherlevel;
		}
		
		var ZhigherLevel = ZgetHigherLevelOfThis();
	
	for(var i in sortedZmenu){ 
		
		var xI = sortedZmenu[i]['self']; 
		if(ZMenuArray[xI]['parent'] == '' || ZMenuArray[xI]['parent'] == GlobZIndexfile){
			if(ZMenuArray[xI]['parent'] == ''){
				
			} else {
				if(xI == ZhigherLevel){
					theZmenu4 += ZSubmenus(xI); 
				}
			}
		} 
	} 
	/* __second level and up*/ 
	
	if (document.location.href.indexOf('zimplit.php') == -1){
		$('.mainMenu').each(function (d){ $(this).html(theZmenu1); }); 
		$('.allMenu').each(function (d){ $(this).html(theZmenuAll); }); 
		$('.mainMenuLi').each(function (d){ $(this).html(theZmenu1_li); }); 
		$('.subMenu').each(function (d){ $(this).html(theZmenu2); }); 
		$('.subMenu2').each(function (d){ $(this).html(theZmenu3); }); 
		$('.subMenu2andUp').each(function (d){ $(this).html(theZmenu4); }); 
	} 
} 
ZinsMenuL();  

function ZdrawNavibar(elID){
		var loc = document.location.pathname;
		var naviStirng = '';
		loc = loc.substring(loc.lastIndexOf("/")+1, loc.length);
		if ((loc == '') || (ZMenuArray[loc]["parent"] == '')){ 
			loc = GlobZIndexfile;
			naviStirng = '<a href="'+loc+'">'+ZMenuArray[loc]["name"] + '</a> ';
		} else {
			naviStirng = '<a href="'+loc+'">'+ZMenuArray[loc]["name"] + '</a> ';
			do{
				loc = ZMenuArray[loc]["parent"];
				naviStirng = '<a href="'+loc+'">'+ZMenuArray[loc]["name"] + '</a> &gt;&gt; ' +naviStirng;
			} while(ZMenuArray[loc]["parent"] != '');
		}
		document.getElementById(elID).innerHTML = naviStirng;
	}