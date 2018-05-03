class ReviewPopupFeed extends PopupFeed
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
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-star\"></span>&emsp;Write a review</h4>";
	}
	Body()
	{
		return "" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-star\"></i></span>" +
				"<input id=\"review-grade\" type=\"text\" class=\"form-control\" name=\"review-grade\" placeholder=\"Grade\">" +
			"</div>" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-comment\"></i></span>" +
				"<input id=\"review-description\" type=\"text\" class=\"form-control\" name=\"review-description\" placeholder=\"Description\">" +
			"</div>";
	}
	Footer()
	{
		return "" +
			"<div class=\"row\">" +
				"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
					"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #review-grade')[0].value, $('#" + this.popups[this.current].id + " #review-description')[0].value);\">Submit</button>" +
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

var reviewPopupFeed;

$(document).ready(function()
{
	reviewPopupFeed = new ReviewPopupFeed("review");
	reviewPopupFeed.Subscribe(mainPopup);
});

function review(popupid, grade, description)
{
	alert("'" + grade + ":" + description + "'");
}