class AboutTutorPopupFeed extends PopupFeed
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
			  "<textarea rows=\"2\" id=\"tutor-description\" class=\"form-control\" name=\"tutor-description\" placeholder=\"Description\">" +
			  "</textarea>" +
			  "</div>";
	}
	
	Footer() 
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #tutor-description')[0].value);" +
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

class TutorDetailsPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	
	Header() 
	{
		return "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-blackboard\"></span>&emsp;Change details/h4>"; 
	}
	
	Body() 
	{
		return "" + 
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-font\"></i></span>" +
			  "<input id=\"tutor-first-name\" type=\"text\" class=\"form-control\" name=\"tutor-first-name\" placeholder=\"First name\">" +
			  "</div>" +
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-bold\"></i></span>" +
			  "<input id=\"tutor-last-name\" type=\"text\" class=\"form-control\" name=\"tutor-last-name\" placeholder=\"Last name\">" +
			  "</div>" +
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>" +
			  "<input id=\"tutor-e-mail-name\" type=\"text\" class=\"form-control\" name=\"tutor-e-mail-name\" placeholder=\"E-Mail\">" +
			  "</div>" +
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-italic\"></i></span>" +
			  "<input id=\"tutor-birth-date-name\" type=\"text\" class=\"form-control\" name=\"tutor-birth-date-name\" placeholder=\"Birth date\">" +
			  "</div>";
	}
	
	Footer() 
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #tutor-first-name')[0].value, " +
				"$('#" + this.popups[this.current].id + " #tutor-last-name')[0].value, " + 
				"$('#" + this.popups[this.current].id + " #tutor-e-mail-name')[0].value, " + 
				"$('#" + this.popups[this.current].id + " #tutor-birth-date-name')[0].value);" +
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

var aboutTutorPopupFeed;
var tutorDetailsPopupFeed;

$(document).ready(function()
{
	aboutTutorPopupFeed = new AboutTutorPopupFeed("changeAboutTutor");
	aboutTutorPopupFeed.Subscribe(mainPopup);
	tutorDetailsPopupFeed = new TutorDetailsPopupFeed("changeTutorDatails");
	tutorDetailsPopupFeed.Subscribe(mainPopup);
});