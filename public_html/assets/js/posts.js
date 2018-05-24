class Reply extends View
{
	constructor(id, username, message, postedOn, isOP)
	{
		super();
		this.id = id;
		this.username = username;
		this.message = message;
		this.postedOn = postedOn;
		this.isOP = isOP;
	}
	
	AsView()
	{
		if (this.isOP) return "" +
			"<article name=\"reply\" class=\"border-boxed expanded no-margin padding-sm\">" +
				"<div class=\"row\">" +
					"<div class=\"col-lg-1 col-md-1 col-sm-2 col-xs-4 text-right\">" +
						(this.id === acceptedAnswer ?
							"<img src=\"res/accept.png\" class=\"valign-top margin-bottom-sm\" width=\"50\" height=\"50\">"
							:
							(isActorOP && typeof acceptedAnswer === "undefined" ? "<img src=\"res/accept.png\" class=\"cursor-pointer opacity-3 opacity-hover-9 valign-top margin-bottom-sm\" width=\"50\" height=\"50\" onclick=\"accept(" + this.id + ");\">" : "")
						) +
						(isActorModerator ? "<img src=\"res/reject.png\" class=\"cursor-pointer opacity-3 opacity-hover-9 valign-top margin-bottom-sm\" width=\"50\" height=\"50\" onclick=\"remove(" + this.id + ");\">" : "") +
					"</div>" +
					"<div class=\"col-lg-10 col-md-10 col-sm-8 col-xs-4\">" +
						"<div class=\"border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs\">" +
							this.message +
						"</div>" +
					"</div>" +
					"<div class=\"col-lg-1 col-md-1 col-sm-2 col-xs-4 text-left\">" +
						"<a href=\"profile.html?id=" + this.username + "\" class=\"font-times-new-roman hover-text-decor-none\">" +
							"<img src=\"storage/users/" + this.username + "/avatar.png\" width=\"60\" height=\"60\"><br>" +
							this.username +
						"</a>" +
						"<p class=\"font-times-new-roman\">Posted on: <i>" + this.postedOn + "</i></p>" +
					"</div>" +
				"</div>" +
			"</article>";
		else return "" +
			"<article name=\"reply\" class=\"border-boxed expanded no-margin padding-sm\">" +
				"<div class=\"row\">" +
					"<div class=\"col-lg-1 col-md-1 col-sm-2 col-xs-4 text-right\">" +
						"<a href=\"profile.html?id=" + this.username + "\" class=\"font-times-new-roman hover-text-decor-none\">" +
							"<img src=\"storage/users/" + this.username + "/avatar.png\" width=\"60\" height=\"60\"><br>" +
							this.username +
						"</a>" +
						"<p class=\"font-times-new-roman\">Posted on: <i>" + this.postedOn + "</i></p>" +
					"</div>" +
					"<div class=\"col-lg-10 col-md-10 col-sm-8 col-xs-4\">" +
						"<div class=\"border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs\">" +
							this.message +
						"</div>" +
					"</div>" +
					"<div class=\"col-lg-1 col-md-1 col-sm-2 col-xs-4 text-left\">" +
						(this.id === acceptedAnswer ?
							"<img src=\"res/accept.png\" class=\"valign-top margin-bottom-sm\" width=\"50\" height=\"50\">"
							:
							(isActorOP && typeof acceptedAnswer === "undefined" ? "<img src=\"res/accept.png\" class=\"cursor-pointer opacity-3 opacity-hover-9 valign-top margin-bottom-sm\" width=\"50\" height=\"50\" onclick=\"accept(" + this.id + ");\">" : "")
						) +
						(isActorModerator ? "<img src=\"res/reject.png\" class=\"cursor-pointer opacity-3 opacity-hover-9 valign-top margin-bottom-sm\" width=\"50\" height=\"50\" onclick=\"remove(" + this.id + ");\">" : "") +
					"</div>" +
				"</div>" +
			"</article>";
	}
}

class SubmitTokensPopupFeed extends PopupFeed
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
			"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-usd\"></span>&emsp;Submit tokens</h4>";
	}
	Body()
	{
		return "" +
			"<div class=\"input-group\">" +
				"<span class=\"input-group-addon\"><i class=\"	glyphicon glyphicon-inbox\"></i></span>" +
				"<input id=\"submit-amount\" type=\"text\" class=\"form-control\" name=\"submit-amount\" placeholder=\"Amount\">" +
			"</div>";
	}
	Footer()
	{
		return "" +
			"<div class=\"row\">" +
				"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
					"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #submit-amount')[0].value);\">Submit</button>" +
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

var replies, isActorOP, isActorModerator, acceptedAnswer; // injected by server
var mainSection = null;
var submitTokensPopupFeed = new SubmitTokensPopupFeed("submit");

$(document).ready(function()
{
	mainSection = $("#section-main");
	
	if (typeof replies !== "undefined")
		for (var i = 0; i < replies.length; i++)
			mainSection[0].innerHTML += replies[i].AsView();
	
	submitTokensPopupFeed = new SubmitTokensPopupFeed("submit");
	submitTokensPopupFeed.Subscribe(mainPopup);
});

function accept(id)
{
	alert("accepting " + id + "...");
}

function remove(id)
{
	alert("removing " + id + "...");
}

function onReplyKeydown(sender, e)
{
	if (!e.shiftKey && (e.keyCode == 13 || e.which == 13))
	{
		alert(sender.value);
		return false;
	}
	
	//if (sender.value.length >= 10) return false;
	return true;
}

function submit(popupid, tokens)
{
	$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> Invalid number of tokens [\"" + tokens + "\"]."));
}

function post(type)
{	
	var collectables = null;
	if (type === "#") collectables = $("[data-collectable]");
	else collectables = $("[data-collectable='#'], [data-collectable='" + type + "']");
	
	if (collectables === null || collectables.length === 0)
	{
		var error = new AlertPopupFeed(Alert.New("danger", "<b>Error!</b> Could not collect data from the page.", true, "modal"));
		error.Subscribe(alertPopup);
		error.Show(0);
		return;
	}
	
	var data = [];
	var files = [];
	
	collectables.each(function(index, collectable)
	{
		collectable = $(collectable);
		var collect = collectable.attr("data-collect");
		var name = collectable.attr("name");
		
		if (typeof collect !== "undefined")
		{
			if (collect === "files") $.each(collectable.prop("files"), function(index, file) { files.push(file); });
			//else if (collect === "innerHTML") data.push({name:collectable.name, value:collectable.innerHTML});
		}
		else
		{
			var value = collectable[0].value;
			if (typeof value === "undefined") value = collectable.attr("value");
			if (typeof value === "undefined") return;
			
			if (typeof data[name] === "undefined") data[name] = value;
			else data[name] += "," + value;
		}
	});
	
	for (var name in data)
		alert("'" + name + "=" + data[name] + "'");
	
	for (var i = 0; i < files.length; i++)
		alert("'+file=" + files[i].name + "'");
	
	var success = new AlertPopupFeed(Alert.New("success", "<b>Success!</b> Your post has been created.", true, "modal"));
	success.Subscribe(alertPopup);
	success.Show(0);
}