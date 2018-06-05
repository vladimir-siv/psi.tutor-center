class Reply extends View
{
	constructor(id, userid, username, message, postedOn, isOP, enableDeleteButton, enableAcceptButton, postid)
	{
		super();
		this.id = id;
		this.userid = userid;
		this.username = username;
		this.message = message;
		this.postedOn = postedOn;
		this.isOP = isOP;
		this.enableDeleteButton = enableDeleteButton;
		this.enableAcceptButton = enableAcceptButton;
		this.postid = postid;
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
					"</div>" +
					"<div class=\"col-lg-10 col-md-10 col-sm-8 col-xs-4\">" +
						"<div class=\"border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs\">" +
							this.message + 
						"</div>" +
					"</div>" +
					"<div class=\"col-lg-1 col-md-1 col-sm-2 col-xs-4 text-left\">" +
						"<a href=\""+ window.location.protocol + "//" + window.location.host + "/Guest/profile/" + this.userid + "\" class=\"font-times-new-roman hover-text-decor-none\">" +
							"<img src=\""+ window.location.protocol + "//" + window.location.host + "/assets/storage/users/" + this.userid + "/avatar.png\" width=\"60\" height=\"60\"><br>" +
							this.username +
						"</a>" +
						"<p class=\"font-times-new-roman\">Posted on: <i>" + this.postedOn + "</i></p>" +
						(this.enableDeleteButton ? "<button class=\"btn btn-danger btn-md font-xxs\" onclick=\"deleteReply(" + this.id + ")\">Delete</button>" : "") +
					"</div>" +
				"</div>" +
			"</article>";
		else return "" +
			"<article name=\"reply\" class=\"border-boxed expanded no-margin padding-sm\">" +
				"<div class=\"row\">" +
					"<div class=\"col-lg-1 col-md-1 col-sm-2 col-xs-4 text-right\">" +
						"<a href=\""+ window.location.protocol + "//" + window.location.host + "/Guest/profile/" + this.userid + "\" class=\"font-times-new-roman hover-text-decor-none\">" +
							"<img src=\""+ window.location.protocol + "//" + window.location.host + "/assets/storage/users/" + this.userid + "/avatar.png\" width=\"60\" height=\"60\"><br>" +
							this.username +
						"</a>" +
						"<p class=\"font-times-new-roman\">Posted on: <i>" + this.postedOn + "</i></p>" +
						(this.enableDeleteButton ? "<button class=\"btn btn-danger btn-md font-xxs\" onclick=\"deleteReply(" + this.id + ")\">Delete</button>" : "") +
						(acceptedAnswer == null && this.enableAcceptButton ? "<button class=\"btn btn-success btn-md font-xxs\" onclick=\"acceptReply(" + this.id + ", " + this.postid + ")\">Accept</button>" : "") +
					"</div>" +
					"<div class=\"col-lg-10 col-md-10 col-sm-8 col-xs-4\">" +
						"<div class=\"border-boxed expanded solid-border border-xs border-gray no-border-left no-border-right rounded-xs padding-xs\">" +
							this.message +
						"</div>" +
					"</div>" +
					"<div class=\"col-lg-1 col-md-1 col-sm-2 col-xs-4 text-left\">" +
						(this.id === acceptedAnswer ?
							"<img src=\"" + window.location.protocol + "//" + window.location.host + "/assets/res/accept.png\" class=\"valign-top margin-bottom-sm\" width=\"50\" height=\"50\">"
							:
							(isActorOP && typeof acceptedAnswer === "undefined" ? "<img src=\"res/accept.png\" class=\"cursor-pointer opacity-3 opacity-hover-9 valign-top margin-bottom-sm\" width=\"50\" height=\"50\" onclick=\"accept(" + this.id + ");\">" : "")
						) +
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
					"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + this.callback + "('" + this.popups[this.current].id + "', " + this.postID +", $('#" + this.popups[this.current].id + " #submit-amount')[0].value);\">Submit</button>" +
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
        
        setPostID(id)
        {
            this.postID = id;
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

function onReplyKeydown(sender, e, postid, replierid)
{
	if (!e.shiftKey && (e.keyCode == 13 || e.which == 13))
	{
		$.ajax
		({
			url: "http://" + window.location.host + "/Utility/createReply",
			method: "POST",
			data: { replymsg: sender.value, postid: postid, replierid: replierid},
			dataType: "html"
		})
		.done(function(response) 
		{
			if (response.startsWith("#Error: "))
			{
				alertPopupFeed.content = Alert.New("danger", response.substring(8), true, "modal");
				alertPopupFeed.Toggle(0);
				return;
			}
			alertPopupFeed.content = Alert.New("success", response, true, "modal");
			alertPopupFeed.Toggle(0);
			window.location.reload();
		});
	}
}

function submit(popupid, postID, tokens)
{
    $("#" + popupid + "-popup-info").html("");
    if (tokens == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter tokens!"));
        return;
    }
    $.ajax
    ({
		url: "http://" + window.location.host + "/Utility/submitTokensToWorkPost",
		method: "POST",
		data: { tokens : tokens, postid : postID },
		dataType: "html"
    })
	.done(function(response) 
    {
		if (response.startsWith("#Error: "))
		{
			$("#" + popupid + "-popup-info").append(Alert.New("danger", response.substring(8), true));
			return;
		}
		
		$("#" + popupid + "-popup-info").append(Alert.New("success", response, true));
		window.location.reload();
    });
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
	
	var postData = new FormData();
	
	for (var name in data) postData.append(name, data[name]);
	
	for (var i = 0; i < files.length; i++) postData.append('+file-' + i, files[i], files[i].name);
	
	$.ajax
	({
		url: "http://" + window.location.host + "/Utility/createPost",
		method: "POST",
		data: postData,
		processData: false,
		contentType: false,
		dataType: "html"
	})
	.done(function(response)
	{
		if (response.startsWith("#Error: "))
		{
			var success = new AlertPopupFeed(Alert.New("danger", response.substring(8), true, "modal"));
			success.Subscribe(alertPopup);
			success.Show(0);
		}
		else
		{
			var type = "success";
			
			if (response.startsWith("#Warning: "))
			{
				type = "warning";
				response = response.substring(10);
			}
			
			var success = new AlertPopupFeed(Alert.New(type, response, true, "modal"));
			success.Subscribe(alertPopup);
			success.Show(0);
		}
	});
}

function lockWorkPost(postid)
{
	$.ajax
	({
		url: "http://" + window.location.host + "/Utility/lockWorkPost",
		method: "POST",
		data: { postid : postid },
		dataType: "html"
	})
	.done(function(response)
	{
		if (response.startsWith("#Error: "))
		{
			var success = new AlertPopupFeed(Alert.New("danger", response.substring(8), true, "modal"));
			success.Subscribe(alertPopup);
			success.Show(0);
		}
		else
		{
			var type = "success";
			
			if (response.startsWith("#Warning: "))
			{
				type = "warning";
				response = response.substring(10);
			}
			
			var success = new AlertPopupFeed(Alert.New(type, response, true, "modal"));
			success.Subscribe(alertPopup);
			success.Show(0);
		}
	});
}

function releaseWorkPost(postid)
{
	$.ajax
	({
		url: "http://" + window.location.host + "/Utility/releaseWorkPost",
		method: "POST",
		data: { postid : postid },
		dataType: "html"
	})
	.done(function(response)
	{
		if (response.startsWith("#Error: "))
		{
			var success = new AlertPopupFeed(Alert.New("danger", response.substring(8), true, "modal"));
			success.Subscribe(alertPopup);
			success.Show(0);
		}
		else
		{
			var type = "success";
			
			if (response.startsWith("#Warning: "))
			{
				type = "warning";
				response = response.substring(10);
			}
			
			var success = new AlertPopupFeed(Alert.New(type, response, true, "modal"));
			success.Subscribe(alertPopup);
			success.Show(0);
		}
	});
}