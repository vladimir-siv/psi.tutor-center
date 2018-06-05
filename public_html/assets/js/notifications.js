class Notification extends View
{
	constructor(id, title, content, seen)
	{
		super();
		this.id = id;
		this.title = title;
		this.content = content;
		this.seen = seen;
	}
	
	AsView()
	{
		return "" +
			"<div class=\"border-boxed expanded no-margin padding-xs solid-border border-xs border-gray no-border-bottom\" style=\"min-height: 80px;\">" +
				"<a class=\"cursor-pointer\" onclick=\"toggleSeen(" + this.id + ");\">" +
					"<img class=\"margin-sm\" src=\"http://" + window.location.host + "/assets/res/" + (this.seen ? "" : "un") + "seen.png\" width=\"40\" height=\"40\" style=\"float: left;\"/>" +
				"</a>" +
				"<h4>" + this.title + "</h4>" +
				this.content +
			"</div>";
	}
}

var notifications = [];

function viewNotifications()
{
	var notif = "";
	for (var i = notifications.length - 1; i >= 0; i--)
		notif += notifications[i].AsView();
	
	return "" +
		"<div class=\"border-boxed expanded no-margin no-padding solid-border-bottom border-xs border-gray font-times-new-roman\" style=\"overflow-y: auto; max-height: 400px; min-width: 200px;\">" +
			notif +
		"</div>";
}

function feedNotifications()
{
	var notifs = viewNotifications();
	$("div#top-content-fixed header#header-fixed #notifications-1").attr("data-content", notifs);
	$("header#header-main #notifications-2").attr("data-content", notifs);
}

$(document).ready(function()
{
	feedNotifications();
});