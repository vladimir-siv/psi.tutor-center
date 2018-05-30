class AboutPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	
	Header() 
	{
		return "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
				"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-blackboard\"></span>&emsp;Change description</h4>"; 
	}
	
	Body() 
	{ 
	  return "" + 
			  "<div class=\"input-group\">" + 
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-pencil\"></i></span>" +
			  "<textarea rows=\"2\" id=\"about-description\" class=\"form-control\" name=\"about-description\" placeholder=\"Description\">" +
			  "</textarea>" +
			  "</div>";
	}
	
	Footer() 
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #about-description')[0].value);" +
				"\">Change</button>" +	
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

class DetailsPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	
	Header() 
	{
		return "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-blackboard\"></span>&emsp;Change details</h4>"; 
	}
	
	Body() 
	{
		return "" + 
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-font\"></i></span>" +
			  "<input id=\"detail-first-name\" type=\"text\" class=\"form-control\" name=\"detail-first-name\" placeholder=\"First name\">" +
			  "</div>" +
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-bold\"></i></span>" +
			  "<input id=\"detail-last-name\" type=\"text\" class=\"form-control\" name=\"detail-last-name\" placeholder=\"Last name\">" +
			  "</div>" +
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>" +
			  "<input id=\"detail-e-mail-name\" type=\"text\" class=\"form-control\" name=\"detail-e-mail-name\" placeholder=\"E-Mail\">" +
			  "</div>" +
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-italic\"></i></span>" +
			  "<input id=\"detail-birth-date-name\" type=\"text\" class=\"form-control\" name=\"detail-birth-date-name\" placeholder=\"Birth date\">" +
			  "</div>";
	}
	
	Footer() 
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', " +
				"$('#" + this.popups[this.current].id + " #detail-first-name')[0].value, " +
				"$('#" + this.popups[this.current].id + " #detail-last-name')[0].value, " + 
				"$('#" + this.popups[this.current].id + " #detail-e-mail-name')[0].value, " + 
				"$('#" + this.popups[this.current].id + " #detail-birth-date-name')[0].value);" +
				"\">Change</button>" +	
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

var aboutPopupFeed;
var detailsPopupFeed;

$(document).ready(function()
{
	aboutPopupFeed = new AboutPopupFeed("changeAbout");
	aboutPopupFeed.Subscribe(mainPopup);
	detailsPopupFeed = new DetailsPopupFeed("changeDatails");
	detailsPopupFeed.Subscribe(mainPopup);
});