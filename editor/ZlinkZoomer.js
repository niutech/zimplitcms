var ZShowingSlidesLink = false;
var ZShowingSlidesLinkTime =4000;

var IE = document.all?true:false;
var FF =/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)?true:false;

function ZgetAllZoomableLinks(){
	var zoomableEls = [];
	$('.zoomlink').each(function(){ 
		var Zdata = { 
			pic: $(this).attr('imageaddr'),
			el: this
		}
		zoomableEls.push(Zdata); 
	});
	return zoomableEls;
}

var ZZoomlinks = ZgetAllZoomableLinks();



function ZdrawGoArrowsLinks(el){
	var Znextpic = -1;
	var Zlasttpic = -1;
	for(var Zcountpic = 0;  Zcountpic < ZZoomlinks.length; Zcountpic++){
		
		if (ZZoomlinks[Zcountpic].pic == $(el).attr('imageaddr')){
			
			if(Zcountpic > 0){
				Zlasttpic = Zcountpic-1;
			}
			if(Zcountpic < (ZZoomlinks.length-1)){
				Znextpic = Zcountpic+1;
			}
			
		}
	}

	
	var arrowHtml = '';
	if(Zlasttpic > -1){
		arrowHtml += '<a style="padding:2px 4px;display:block; float:left;text-decoration:none;color: #666666; font: bold 14px/16px courier;" href="javascript: void(0);" onclick="ZchangeImgLink(ZZoomlinks[\''+Zlasttpic+'\'].el);">&lt;&lt;  </a>';
	}
	if(Znextpic > -1){
		arrowHtml += '<a style="padding:2px 4px;display:block; float:right;text-decoration:none;color: #666666; font: bold 14px/16px courier;" href="javascript: void(0);" onclick="ZchangeImgLink(ZZoomlinks[\''+Znextpic+'\'].el);">&gt;&gt;  </a>';
	}
	if(ZShowingSlidesLink){
		arrowHtml += '<a id="ZslideshowButton" style="text-decoration:none;color: #666666; font: bold 14px/16px courier;position:relative; top:2px;" href="javascript:void(0);" onclick="ZstartSlideShowLink();"> || </a>';
	} else {
		arrowHtml += '<a id="ZslideshowButton" style="text-decoration:none;color: #666666; font: bold 14px/16px courier;position:relative; top:2px;" href="javascript:void(0);" onclick="ZstartSlideShowLink();"> &gt; </a>';
	}
	
	return arrowHtml;
}


function ZClickZoomLink(el){
$(document.body).prepend('<div id="ZImgZoomOverlay" onclick="ZClickZoomImgCloseLink();" style="width: 100%; height:'+$(document).height()+'px; background: #000000; filter:alpha(opacity=80); -moz-opacity: 0.80; opacity: 0.80; position: absolute; top:0px; left:0px; z-index: 10;">&nbsp;</div><div id="ZtheZoomImage" style="position: absolute; display:none; left:0px; top:'+($(window).scrollTop()+30)+'px; z-index: 15;  width: 100%; text-align:center;"><div style="margin: 0 auto; background: #FFFFFF; padding: 1px 1px; border: 1px solid #DDDDDD;"><a href="javascript:void(0);" id="ZclickcloseBtn" onclick="ZClickZoomImgCloseLink();" style="color: #666666; font: bold 14px/16px arial;text-decoration:none; text-align: right; display:block;padding: 0 5px; background: #EEEEEE;">X</a><div id="ZZoomImgItself"><img id="ZZoomImgItselfPic" src="'+$(el).attr('imageaddr')+'" alt="" /></div><div id="ZPicArrowsBox" style="overflow:hidden;">'+ZdrawGoArrowsLinks(el)+'</div></div></div>'); 

ZchangeImgLink(el);
if(IE || FF) {
} else {
	$('#ZtheZoomImage').fadeIn();
}
	
	setTimeout('ZwaitWithTheResizeLink();',100);

}

function ZwaitWithTheResizeLink(){

	if((document.getElementById('ZZoomImgItselfPic')) &&(document.getElementById('ZZoomImgItselfPic').complete)){
		
		$('#ZtheZoomImage div').width($('#ZtheZoomImage').find('img').width());
		$('#ZZoomImgItself').width($('#ZtheZoomImage').find('img').width());
		$('#ZZoomImgItself').height($('#ZtheZoomImage').find('img').height());
		$('#ZZoomImgItself').css('z-index','1000');
		$('#ZZoomImgItself img').css('visibility','visible').hide();
		if(IE || FF) {
			$('#ZtheZoomImage').fadeIn();
		} else {
			
		}
		$('#ZZoomImgItself img').fadeIn();
		$('#ZImgZoomOverlay').height($(document).height());
	} else {
		setTimeout('ZwaitWithTheResizeLink();',100);
	}
}

function ZchangeImgLink(el){
	$('#ZZoomImgItself img').fadeOut('fast', function callback(sss){
		$('#ZZoomImgItself').html('<img id="ZZoomImgItselfPic" src="'+$(el).attr('imageaddr')+'" alt="" />');
		$('#ZtheZoomImage img').css('visibility','hidden');
		$('#ZPicArrowsBox').html(ZdrawGoArrowsLinks(el));
	
		
		setTimeout('ZwaitWithTheResizeLink();',100);
	
	});
}


function ZstartSlideShowLink(){
	if(ZShowingSlidesLink){
		ZShowingSlidesLink = false;
		$('#ZslideshowButton').html(' &gt; ');
	} else {
		ZShowingSlidesLink = true;
		$('#ZslideshowButton').html(' || ');
		setTimeout('ZnextSlideShowLink();',ZShowingSlidesLinkTime);
	}
	
}

function ZnextSlideShowLink(){
	
	if(ZShowingSlidesLink){
		var Znextpic = -1;
		for(var Zcountpic = 0;  Zcountpic < ZZoomlinks.length; Zcountpic++){
			if ($('#ZtheZoomImage').find('img').attr('src').indexOf(ZZoomlinks[Zcountpic].pic) != -1){
				if(Zcountpic < (ZZoomlinks.length-1)){
					Znextpic = Zcountpic+1;
				} else {
					Znextpic = 0;
				}
				ZchangeImgLink(ZZoomlinks[Znextpic].el);
				
				setTimeout('ZnextSlideShowLink();',ZShowingSlidesLinkTime);
			}
		}
		if(Znextpic > -1){
			
		} else {
			ZShowingSlidesLink = false;
		}
	}
}

function ZClickZoomImgCloseLink(){
	ZShowingSlidesLink = false;
	$('#ZImgZoomOverlay, #ZtheZoomImage').remove();
}