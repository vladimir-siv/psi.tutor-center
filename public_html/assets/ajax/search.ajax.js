class ResultView extends View
{
	Feed(json) { throw new Error("Abstract method"); }
}

class LinkSectionSearchResult extends ResultView
{
	Feed(json) { this.id = json.id; this.section = json.section; }
	AsView() { return "<a class=\"hover-text-decor-none font-rammetto-one font-xs bg-lightblue padding-left-xs padding-right-xs\" href=\"http://" + window.location.host + "/Guest/section/" + this.id + "\" target=\"_blank\"><span class=\"bg-secondary\" name=\"section\" data-collectable=\"#\" value=\"" + this.id + "\">" + this.section + "</span></a>&nbsp;"; }
}

class ActiveSectionSearchResult extends ResultView
{
	constructor(callback) { super(); this.callback = callback; }
	Feed(json) { this.id = json.id; this.section = json.section; }
	AsView() { return "<button type=\"button\" class=\"font-rammetto-one font-xs bg-lightblue padding-left-xs padding-right-xs\" onclick=\"" + this.callback + "(this, {id:" + this.id + ", section:'" + this.section + "'});\"><span class=\"bg-secondary\" name=\"result\">" + this.section + "</span></button>&nbsp;"; }
}

function searchdb(type, params, callback)
{
	if (searchingInProgress)
	{
		alertPopupFeed.content = Alert.New("warning", "Another search already in progress! Please, wait for it to finish.", true, "modal");
		alertPopupFeed.Toggle(0);
		return;
	}
	
	if (typeof callback === "undefined") callback = onSearchComplete;
	
	var colon = type.lastIndexOf(":");
	var domain, format = null;
	
	if (colon != -1)
	{
		domain = type.slice(0, colon);
		format = type.slice(colon + 1);
	}
	else domain = type;
	
	searchingInProgress = true;
	
	$.ajax
	({
		url: "http://" + window.location.host + "/Utility/searchdb",
		method: "POST",
		data: { domain : domain, format : format, params : JSON.stringify(params) },
		dataType: "html"
	})
	.done(function(response)
	{
		onSearchComplete(callback, response);
	});
}

var callbackParameters = [];
var searchingInProgress = false;

function onSearchComplete(callback, result)
{
	var json = JSON.parse(result);
	
	if (callback === onSearchComplete)
	{
		if (callbackParameters.length >= 2)
		{
			var resultDisplay = $(callbackParameters[0]);
			resultDisplay.html("");
			for (var i = 0; i < json.length; i++)
			{
				callbackParameters[1].Feed(json[i]);
				resultDisplay.append(callbackParameters[1].AsView());
			}
		}
	}
	else callback(json, callbackParameters);
	
	callbackParameters = [];
	searchingInProgress = false;
}

function FeedPopover(json, args)
{
	if (args.length >= 2)
	{
		var resultDisplay = $(args[0]);
		resultDisplay.attr("data-content", "");
		for (var i = 0; i < json.length; i++)
		{
			args[1].Feed(json[i]);
			resultDisplay.attr("data-content", function(i, oldval) { return oldval + args[1].AsView(); });
		}
		resultDisplay.popover("show");
	}
}