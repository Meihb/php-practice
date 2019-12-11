var now_pathname=window.location.pathname.replace('/project/friends/admin/',''),this_href;
$("#dcLeft>#menu a").each(function(index, element) {
	this_href=this.getAttribute('href');
  if(this_href!='index.php'&&this_href===now_pathname){
		$(this).attr('href','javascript:void(0);').parent().addClass("cur");
		return false;
		}
});