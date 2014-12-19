var IE = document.all?true:false;
if((typeof(window.top.isintheZeditor) !="undefined")&& IE){

} else {
	google.load('search', '1');
	//google.load('maps', '2.x'); 
}

function ZLoadGSearch(elem,page){
	if((typeof(window.top.isintheZeditor) !="undefined")&& IE){
		elem.innerHTML = '<b>Google search box. Sorry can not display it in IE when in editor.</b>';
	} else {
		var searchControl = new google.search.SearchControl();
		var options = new google.search.SearcherOptions();
		options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
		var siteSearch = new google.search.WebSearch();
		siteSearch.setUserDefinedLabel(page);
		siteSearch.setUserDefinedClassSuffix("siteSearch");
		siteSearch.setSiteRestriction(page);
		searchControl.addSearcher(siteSearch,options);
		searchControl.draw(elem);
	}
}

function ZLoadGMap(elem,pointx,pointy,zoom,text){
		if((typeof(window.top.isintheZeditor) !="undefined")&& IE){
			elem.innerHTML = '<b>Google search box. Sorry can not display it in IE when in editor.</b>';
		} else {
			elem.style.height = '350px';
			ZimplitGooglemap = new GMap2(elem);
			ZimplitGooglemap.setCenter(new GLatLng(pointy,pointx), zoom);
			ZimplitGooglemap.setUIToDefault();
			ZimplitGooglemapPoints = new GMarker(new GLatLng(pointy,pointx));
			ZimplitGooglemap.addOverlay(ZimplitGooglemapPoints);
			ZimplitGooglemap.openInfoWindow(new GLatLng(pointy,pointx),document.createTextNode(text));
		}
}