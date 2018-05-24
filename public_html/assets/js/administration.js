class CreateSubjectPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	
	Header() 
	{
		return "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-list-alt\"></span>&emsp;Create subject</h4>"; 
	}
	
	Body() 
	{ 
	  return "" + 
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-font\"></i></span>" +
			  "<input id=\"create-subject-name\" type=\"text\" class=\"form-control\" name=\"create-subject-name\" placeholder=\"Name\">" +
			  "</div>" + 
			  "<div class=\"input-group\">" + 
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-pencil\"></i></span>" +
			  "<textarea rows = \"2\" id=\"create-subject-description\" class=\"form-control\" name=\"create-subject-description\" placeholder=\"Description\" style=\"resize: none;\">" +
			  "</textarea>" +
			  "</div>";
	}
	
	Footer() 
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #create-subject-name')[0].value, " +
				"$('#" + this.popups[this.current].id + " #create-subject-description')[0].value);\">Create</button>" +	
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

class CreateSectionPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	
	Header() 
	{
		return "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-list-alt\"></span>&emsp;Create section</h4>"; 
	}
	
	Body() 
	{ 
	  return "" + 
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-font\"></i></span>" +
			  "<input id=\"create-section-name\" type=\"text\" class=\"form-control\" name=\"create-section-name\" placeholder=\"Name\">" +
			  "</div>" + 
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-header\"></i></span>" +
			  "<input id=\"create-section-subject\" type=\"text\" class=\"form-control\" name=\"create-section-subject\" placeholder=\"Subject\">" +
			  "</div>" +
			  "<div class=\"input-group\">" + 
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-pencil\"></i></span>" +
			  "<textarea rows = \"2\" id=\"create-section-description\" class=\"form-control\" name=\"create-section-description\" placeholder=\"Description\" style=\"resize: none;\">" +
			  "</textarea>" +
			  "</div>";
	}
	
	Footer() 
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #create-section-name')[0].value, " +
				"$('#" + this.popups[this.current].id + " #create-section-subject')[0].value, " + 
				"$('#" + this.popups[this.current].id + " #create-section-description')[0].value);" +
				"\">Create</button>" +	
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

var createSubjectPopupFeed, createSectionPopupFeed;

$(document).ready(function()
{
	createSubjectPopupFeed = new CreateSubjectPopupFeed("createSubject");
	createSubjectPopupFeed.Subscribe(mainPopup);
	createSectionPopupFeed = new CreateSectionPopupFeed("createSection");
	createSectionPopupFeed.Subscribe(mainPopup);
});