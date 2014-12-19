var ZShowingSlides = false;
var ZShowingSlidesTime =4000;

var IE = document.all?true:false;
var FF =/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)?true:false;

function ZgetAllZoomables(){
	var zoomableEls = [];
	$('a').each(function(ZZoomPic){ 
		if ($(this).attr('onclick')){ 
			if ($(this).attr('onclick').toString().indexOf('ZClickZoomImg(this)') != -1){
				if((this.innerHTML != '') && $(this).find('img').attr('src')){
					var Zdata = { 
						pic: $(this).find('img').attr('src').replace(/_thumb/gi,''),
						el: this
					}
					zoomableEls.push(Zdata); 
				}
			}
			
			
		}
	});
	return zoomableEls;
}

var ZZoompics = ZgetAllZoomables();

function ZdrawGoArrows(el){
	var Znextpic = -1;
	var Zlasttpic = -1;
	for(var Zcountpic = 0;  Zcountpic < ZZoompics.length; Zcountpic++){
		
		if (ZZoompics[Zcountpic].pic == $(el).find('img').attr('src').replace(/_thumb/gi,'')){
			
			if(Zcountpic > 0){
				Zlasttpic = Zcountpic-1;
			}
			if(Zcountpic < (ZZoompics.length-1)){
				Znextpic = Zcountpic+1;
			}
			
		}
	}
	
	var arrowHtml = '';
	if(Zlasttpic > -1){
		arrowHtml += '<a style="padding:2px 4px;display:block; float:left;text-decoration:none;color: #666666; font: bold 14px/16px courier;" href="javascript: void(0);" onclick="ZchangeImg(ZZoompics[\''+Zlasttpic+'\'].el);">&lt;&lt;  </a>';
	}
	if(Znextpic > -1){
		arrowHtml += '<a style="padding:2px 4px;display:block; float:right;text-decoration:none;color: #666666; font: bold 14px/16px courier;" href="javascript: void(0);" onclick="ZchangeImg(ZZoompics[\''+Znextpic+'\'].el);">&gt;&gt;  </a>';
	}
	if(ZShowingSlides){
		arrowHtml += '<a id="ZslideshowButton" style="text-decoration:none;color: #666666; font: bold 14px/16px courier;position:relative; top:2px;" href="javascript:void(0);" onclick="ZstartSlideShow();"> || </a>';
	} else {
		arrowHtml += '<a id="ZslideshowButton" style="text-decoration:none;color: #666666; font: bold 14px/16px courier;position:relative; top:2px;" href="javascript:void(0);" onclick="ZstartSlideShow();"> &gt; </a>';
	}
	return arrowHtml;
}


function ZClickZoomImg(el){
$(document.body).prepend('<div id="ZImgZoomOverlay" onclick="ZClickZoomImgClose();" style="width: 100%; height:'+$(document).height()+'px; background: #000000; filter:alpha(opacity=80); -moz-opacity: 0.80; opacity: 0.80; position: absolute; top:0px; left:0px; z-index: 10;">&nbsp;</div><div id="ZtheZoomImage" style="position: absolute; display:none; left:0px; top:'+($(window).scrollTop()+30)+'px; z-index: 15;  width: 100%; text-align:center;"><div style="margin: 0 auto; background: #FFFFFF; padding: 1px 1px; border: 1px solid #DDDDDD;"><a href="javascript:void(0);" id="ZclickcloseBtn" onclick="ZClickZoomImgClose();" style="color: #666666; font: bold 14px/16px arial;text-decoration:none; text-align: right; display:block;padding: 0 5px; background: #EEEEEE;">X</a><div id="ZZoomImgItself"><img id="ZZoomImgItselfPic" src="'+$(el).find('img').attr('src').replace(/_thumb/gi,'')+'" alt="" /></div><div id="ZPicArrowsBox" style="overflow:hidden;">'+ZdrawGoArrows(el)+'</div></div></div>'); 

ZchangeImg(el);
if(IE || FF) {
} else {
	$('#ZtheZoomImage').fadeIn();
}
	
	setTimeout('ZwaitWithTheResize();',100);

}

function ZwaitWithTheResize(){

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
		setTimeout('ZwaitWithTheResize();',100);
	}
}

function ZchangeImg(el){
	$('#ZZoomImgItself img').fadeOut('fast', function callback(sss){
		$('#ZZoomImgItself').html('<img id="ZZoomImgItselfPic" src="'+$(el).find('img').attr('src').replace(/_thumb/gi,'')+'" alt="" />');
		$('#ZtheZoomImage img').css('visibility','hidden');
		$('#ZPicArrowsBox').html(ZdrawGoArrows(el));
	
		
		setTimeout('ZwaitWithTheResize();',100);
	
	});
}


function ZstartSlideShow(){
	if(ZShowingSlides){
		ZShowingSlides = false;
		$('#ZslideshowButton').html(' &gt; ');
	} else {
		ZShowingSlides = true;
		$('#ZslideshowButton').html(' || ');
		setTimeout('ZnextSlideShow();',ZShowingSlidesTime);
	}
	
}

function ZnextSlideShow(){
	
	if(ZShowingSlides){
		var Znextpic = -1;
		for(var Zcountpic = 0;  Zcountpic < ZZoompics.length; Zcountpic++){
			if ($('#ZtheZoomImage').find('img').attr('src').replace(/_thumb/gi,'').indexOf(ZZoompics[Zcountpic].pic) != -1){
				if(Zcountpic < (ZZoompics.length-1)){
					Znextpic = Zcountpic+1;
				} else {
					Znextpic = 0;
				}
				ZchangeImg(ZZoompics[Znextpic].el);
				
				setTimeout('ZnextSlideShow();',ZShowingSlidesTime);
			}
		}
		if(Znextpic > -1){
			
		} else {
			ZShowingSlides = false;
		}
	}
}

function ZClickZoomImgClose(){
	ZShowingSlides = false;
	$('#ZImgZoomOverlay, #ZtheZoomImage').remove();
}