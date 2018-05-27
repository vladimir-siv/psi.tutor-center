const TOKEN_RATE = 1;

function conversion(value)
{
    return value * TOKEN_RATE;
}

class SellTokensPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	        
	Header() 
	{
		return "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
				"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-usd\"></span>&emsp;Sell tokens</h4>"; 
	}
	
	Body() 
	{ 
	  return "" + 
                "<div class=\"input-group\">" +
                "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-eye-close\"></i></span>" +
                "<input id=\"account-number\" type=\"text\" class=\"form-control\" name=\"account-number\" placeholder=\"Account number\">" +
                "</div>" + 
                "<div class=\"input-group\">" +
                "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-grain\"></i></span>" +
                "<input id=\"amount-tokens\" type=\"text\" class=\"form-control\" name=\"amount-tokens\" placeholder=\"Amount tokens\" onchange=\"$('#amount-dollar')[0].value = conversion(parseFloat(this.value))\"; >" +
                "</div>" +
                "<div class=\"input-group\">" + 
                "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-usd\"></i></span>" +
                "<input id=\"amount-dollar\" type=\"text\" class=\"form-control\" name=\"amount-dollar\" placeholder=\"Amount dollar\" disabled>" +
                "</div>";
	}
	
	Footer()
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #account-number')[0].value, " +
				"$('#" + this.popups[this.current].id + " #amount-tokens')[0].value, " + 
				"$('#" + this.popups[this.current].id + " #amount-dollar')[0].value);" +
				"\">Sell</button>" +	
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

class BuyTokensPopupFeed extends PopupFeed
{
	constructor(callback)
	{
		super();
		this.callback = callback;
	}
	
	Header() 
	{
		return "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">&times;</button>" +
				"<h4 class=\"modal-title\"><span class=\"glyphicon glyphicon-usd\"></span>&emsp;Buy tokens</h4>"; 
	}
	
	Body() 
	{
		return "" + 
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-eye-close\"></i></span>" +
			  "<input id=\"account-number\" type=\"text\" class=\"form-control\" name=\"account-number\" placeholder=\"Account number\">" +
			  "</div>" + 
			  "<div class=\"input-group\">" +
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-usd\"></i></span>" +
			  "<input id=\"amount-dollar\" type=\"text\" class=\"form-control\" name=\"amount-dollar\" placeholder=\"Amount dollar\" onchange=\"$('#amount-tokens')[0].value = conversion(parseFloat(this.value))\";>" +
			  "</div>" +
			  "<div class=\"input-group\">" + 
			  "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-grain\"></i></span>" +
			  "<input id=\"amount-tokens\" type=\"text\" class=\"form-control\" name=\"amount-tokens\" placeholder=\"Amount tokens\" disabled>" +
			  "</div>";
	}
	
	Footer() 
	{
	  return "" +
		"<div class=\"row\">" +
			"<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-4\">" +
				"<button type=\"button\" class=\"btn btn-primary btn-sm btn-block\" onclick=\"" + 
				this.callback + "('" + this.popups[this.current].id + "', $('#" + this.popups[this.current].id + " #account-number')[0].value, " +
				"$('#" + this.popups[this.current].id + " #amount-dollar')[0].value, " +
				"$('#" + this.popups[this.current].id + " #amount-tokens')[0].value);" +
				"\">Buy</button>" +
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

var buyTokensPopupFeed;
var sellTokensPopupFeed;

$(document).ready(function()
{
	buyTokensPopupFeed = new BuyTokensPopupFeed("buyTokens");
	buyTokensPopupFeed.Subscribe(mainPopup);
	sellTokensPopupFeed = new SellTokensPopupFeed("sellTokens");
	sellTokensPopupFeed.Subscribe(mainPopup);
});