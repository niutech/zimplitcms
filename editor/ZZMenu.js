/* the location of this document */ var zdocloc = document.location.href; 
	if (zdocloc.charAt(zdocloc.length -1) == '/'){ 
		var thispage = GlobZIndexfile; /* if doclocation without html file */ 
	} else { 
		if(document.location.href.indexOf('#') != -1){
			var thispage = document.location.href.substring(document.location.href.lastIndexOf('/')+1,document.location.href.indexOf('#')); 
		} else { 
			var thispage = document.location.href.substring(document.location.href.lastIndexOf('/')+1,document.location.href.length); 
		} 
	} /* __the location of this document */ 
	thispage = thispage.split('?')[0];
	
if (typeof Zimplit == 'undefined'){ 
	Zimplit = new Object();
}
if (typeof Zimplit.menus == 'undefined'){ Zimplit.menus = new Object();}
	
Zimplit.menus.horizontalDropdown = {
	className: 'ZhorizontalDropdown',
	IE: (document.all && (navigator.appVersion.indexOf('MSIE 8')==-1))?true:false,
	style:{
		ul_main: {'display':'block', 'margin':'0', 'padding':'0', 'list-style-type': 'none', 'line-height': '1.5em', 'clear':'both'},
		li_main: {'display':'block', 'float':'left', 'white-space': 'nowrap',  'margin':'0', 'padding':'0', 'overflow':'hidden'},
		a_main: {'display': 'block', 'white-space': 'nowrap', 'padding':'5px', 'margin':'0 0 0 0', 'text-decoration':'none'},
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
					$(this).find('li').hover(function(){$(this).css('background',theStyles['hovercolor']);} , function(){$(this).css('background',theStyles['bgcolor']);});
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
}

Zimplit.menus.verticalDropdown = {
	className: 'ZverticalDropdown',
	IE: (document.all && (navigator.appVersion.indexOf('MSIE 8')==-1))?true:false,
	style:{
		ul_main: {'display':'block','float':'left', 'margin':'0', 'padding':'0', 'list-style-type': 'none', 'background':'#aabbcc','line-height':'1.5em','clear':'both'},
		li_main: {'display':'block','float':'none','white-space': 'nowrap',  'margin':'0 0 1px 0', 'padding':'2px 0','overflow':'hidden','clear':'both'},
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


function sortZmenu() { 
	var sortedArray = [];
	for (var i in ZMenuArray){ 
		var tmparray = []; 
		tmparray['index'] = parseInt(ZMenuArray[i]['index']); 
		tmparray['self'] = ZMenuArray[i]['self']; 
		sortedArray.push(tmparray); 
	} 
	sortedArray.sort(function(a, b){return (parseInt(a['index']) - parseInt(b['index']));});
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
		Zimplit.menus.horizontalDropdown.init();
		Zimplit.menus.verticalDropdown.init();
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