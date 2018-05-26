class LoginPopupFeed extends PopupFeed
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
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-log-in\"></span>&emsp;Log in</h4>";
	}
	Body()
	{
		return "" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>" +
				"<input id=\"login-username\" type=\"text\" class=\"form-control\" name=\"login-username\" placeholder=\"Username\">" +
			"</div>" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>" +
				"<input id=\"login-password\" type=\"password\" class=\"form-control\" name=\"login-password\" placeholder=\"Password\">" +
			"</div>";
	}
	Footer()
	{
		return "" +
			"<div class=\"row\">" +
				"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
					"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #login-username')[0].value, $('#" + this.popups[this.current].id + " #login-password')[0].value);\">Log in</button>" +
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

class RegisterPopupFeed extends PopupFeed
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
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-check\"></span>&emsp;Register</h4>";
	}
	Body()
	{
		return "" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-font\"></i></span>" +
				"<input id=\"register-firstname\" type=\"text\" class=\"form-control\" name=\"register-firstname\" placeholder=\"First name (eg. Vladimir)\">" +
			"</div>" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-bold\"></i></span>" +
				"<input id=\"register-lastname\" type=\"text\" class=\"form-control\" name=\"register-lastname\" placeholder=\"Last name (eg. Sivčev)\">" +
			"</div>" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>" +
				"<input id=\"register-username\" type=\"text\" class=\"form-control\" name=\"register-username\" placeholder=\"Username (eg. vladimirsi)\">" +
			"</div>" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>" +
				"<input id=\"register-password\" type=\"password\" class=\"form-control\" name=\"register-password\" placeholder=\"Password (eg. @Th!nkBoutAStr0ngP4ss)\">" +
			"</div>" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-envelope\"></i></span>" +
				"<input id=\"register-email\" type=\"email\" class=\"form-control\" name=\"register-email\" placeholder=\"E-mail (eg. vladimirsi@nordeus.com)\">" +
			"</div>" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>" +
				"<input id=\"register-birthdate\" type=\"text\" class=\"form-control\" name=\"register-birthdate\" placeholder=\"Birthdate (eg. 1996-02-06)\">" +
			"</div>";
	}
	Footer()
	{
		return "" +
			"<div class=\"row\">" +
				"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
					"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #register-firstname')[0].value, $('#" + this.popups[this.current].id + " #register-lastname')[0].value, $('#" + this.popups[this.current].id + " #register-username')[0].value, $('#" + this.popups[this.current].id + " #register-password')[0].value, $('#" + this.popups[this.current].id + " #register-email')[0].value, $('#" + this.popups[this.current].id + " #register-birthdate')[0].value);\">Sign up</button>" +
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

class AlertPopupFeed extends PopupFeed
{
	constructor(initialContent)
	{
		super();
		this.content = initialContent;
	}
	Body()
	{
		return this.content;
	}
}

class View
{
	AsView()
	{
		return "";
	}
}

var mainPopup;
var alertPopup;

var loginPopupFeed;
var registerPopupFeed;
var alertPopupFeed;

$(document).ready(function()
{
	mainPopup = new Popup(Config.mainPopupId);
	alertPopup = new AlertPopup(Config.alertPopupId);
	
	loginPopupFeed = new LoginPopupFeed("login");
	loginPopupFeed.Subscribe(mainPopup);
	
	registerPopupFeed = new RegisterPopupFeed("register");
	registerPopupFeed.Subscribe(mainPopup);
	
	alertPopupFeed = new AlertPopupFeed(Alert.New("success", "<b>Success!</b> The job is done.", true, "modal"));
	alertPopupFeed.Subscribe(alertPopup);
});