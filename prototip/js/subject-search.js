class SearchSubjectsPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	Header()
	{
		return "" +
			"<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-search\"></span>&emsp;Search subject</h4>";
	}
	Body()
	{
		return "" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-filter\"></i></span>" +
				"<input id=\"search-filter\" type=\"text\" class=\"form-control\" name=\"search-filter\" placeholder=\"Search filter\" onkeydown=\"if (event.keyCode == 13 || event.which == 13) " + this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #search-filter')[0].value);\">" +
			"</div>";
	}
	Footer()
	{
		return "" +
			"<div class=\"row\">" +
				"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
					"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #search-filter')[0].value);\">Search</button>" +
				"</div>" +
				"<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-4\"></div>" +
				"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
					"<button type=\"button\" class=\"btn btn-danger btn-sm btn-block\" data-dismiss=\"modal\" aria-label=\"close\">Close</button>" +
				"</div>" +
			"</div>";
	}
	Info()
	{
		return "";
	}
}

var searchSubjectsPopupFeed;

$(document).ready(function()
{
	searchSubjectsPopupFeed = new SearchSubjectsPopupFeed("searchSubject");
	searchSubjectsPopupFeed.Subscribe(mainPopup);
});

function searchSubject(popupid, value)
{
	searchSubjectsPopupFeed.Toggle(0);
	
	var rows = $("#section-main > .row");
	rows.show();
	
	rows.find("p[name=\"id\"] span.result").replaceWith(function() { return $(this).html(); });
	
	if (value != "")
	{
		var filtered = rows.has("p[name=\"id\"]:contains(\"" + value + "\")");
		rows.not(filtered).hide();
		filtered.find("p[name=\"id\"]").html(function() { return $(this).html().replace(value, "<span class=\"result\" style=\"background-color: orange;\">" + value + "</span>"); });
	}
}