Zimplit.GUI = {
	sideMenu:{
		init: function(){
			$('#ZFramesCont').prepend(Zimplit.Sources.sidemenu);
			$("#ZimplitSideMenu .outerBorder").height($(document).height());
			$("#ZimplitSideMenu .sideScroller").css('margin-top',($(window).height()/2)-49);
			if(Zimplit.cookies.getData('sidemenuStatus')== 'open'){
				Zimplit.GUI.sideMenu.show();
			}
		},
		
		toggle: function(){
			if($('#ZimplitSideMenu').hasClass('open')){
				Zimplit.GUI.sideMenu.hide();
			} else {
				Zimplit.GUI.sideMenu.show();
			}
		},
		
		show: function(){
			$('#ZimplitSideMenu').animate({'width':'187px'}, function(){
				ZgenerateMenusIntoStrucPop();
				$('#ZmenuStuc').show();
				$('#ZimplitSideMenu').addClass('open');
				if(ZimplitMenu.offset().left < 210){
					ZimplitMenu.css('left','210px');
				}
				Zimplit.cookies.setData('sidemenuStatus','open');
				ZIfWindowIsResized();
			});
		},
		
		hide: function(){
			$('#ZimplitSideMenu').animate({'width':'65px'}, function(){
				$('#ZmenuStuc').hide();
				$('#ZimplitSideMenu').removeClass('open');
				$('#ZimplitSideMenu .bigContent').hide();
				Zimplit.cookies.setData('sidemenuStatus','closed');
				ZIfWindowIsResized()	
			});
		},
		
		btnToggle: function(el){
			if(!$('#ZimplitSideMenu').hasClass('open')){
				Zimplit.GUI.sideMenu.toggle();
			}
			$(el).toggle('slow',function(){
				ZIfWindowIsResized();
			});
		}
	},
	
	overlay: {
		init: function(){
			$(document.body).prepend('<div id="ZMainOverlay" style="display:none;"></div>');
			$("#ZMainOverlay").height($(document).height());
		}
	},

	loadHelp: function(helpLoc){
		$('#ZhelpIframe').attr('src', 'http://client.zimplit.com/manuals/English_manual_version_2.php?client=publicUser#'+helpLoc);
		$('#ZPageiframeContainer').hide();
		$('#ZPageiframeContainer2').show();
		$('#ZhelpIframe').height($(window).height()-30);
		$('#ZcloseHelp').show();
		ZimplitMenu.hide();
	},
	
	hideHelp: function(){
		$('#ZPageiframeContainer2').hide();
		$('#ZcloseHelp').hide();
		$('#ZPageiframeContainer').show();
		ZimplitMenu.show();
	}
}