class Popup
{
	constructor(id)
	{
		var body = $(document.body);
		this.id = id;
		body.append(this.ToString());
		this.domElement = $("#" + id);
	}
	Feed(popupFeed)
	{
		var vheader = this.domElement.find(".modal-header");
		var vbody = this.domElement.find(".modal-body");
		var vfooter = this.domElement.find(".modal-footer");
		var vinfo = this.domElement.find("#" + this.id + "-popup-info");
		
		vheader.empty();
		vbody.empty();
		vfooter.empty();
		vinfo.empty();
		
		vheader.append(popupFeed.Header());
		vbody.append(popupFeed.Body());
		vfooter.append(popupFeed.Footer());
		vinfo.append(popupFeed.Info());
	}
	Show()
	{
		this.domElement.modal("show");
	}
	Hide()
	{
		this.domElement.modal("hide");
	}
	Toggle()
	{
		this.domElement.modal("toggle");
	}
	ToString()
	{
		return "" +
			"<div id=\"" + this.id + "\" class=\"modal fade above-top-content-fixed\" role=\"dialog\">" +
				"<div class=\"modal-dialog\">" +
					"<div class=\"modal-content\">" +
						"<div class=\"modal-header\"></div>" +
						"<div class=\"modal-body\"></div>" +
						"<div class=\"modal-footer\"></div>" +
						"<div id=\"" + this.id + "-popup-info\" class=\"container-fluid\"></div>" +
					"</div>" +
				"</div>" +
			"</div>";
	}
}

class AlertPopup extends Popup
{
	constructor(id)
	{
		super(id);
	}
	Feed(popupFeed)
	{
		var vbody = this.domElement.find(".modal-dialog");
		vbody.empty();
		vbody.append(popupFeed.Body());
	}
	ToString()
	{
		return "" +
			"<div id=\"" + this.id + "\" class=\"modal fade above-top-content-fixed\" role=\"dialog\">" +
				"<div class=\"modal-dialog\"></div>" +
			"</div>";
	}
}

class PopupFeed
{
	constructor()
	{
		this.popups = [];
		this.current = -1;
	}
	Subscribe(popup)
	{
		this.popups.push(popup);
	}
	Unsubscribe(popup)
	{
		var index = this.popups.indexOf(popup);
		if (index > -1) this.popups.splice(index, 1);
	}
	Feed(i)
	{
		//for (var i = 0; i < this.popups.length; this.popups[i++].Feed(this)) ;
		if (i < 0 || this.popups.length <= i) return false;
		this.current = i;
		this.popups[i].Feed(this);
		return true;
	}
	Show(i)
	{
		if (this.Feed(i)) this.popups[i].Show();
	}
	Hide(i)
	{
		if (this.Feed(i)) this.popups[i].Hide();
	}
	Toggle(i)
	{
		if (this.Feed(i)) this.popups[i].Toggle();
	}
	Header() { throw new Error("Abstract method"); }
	Body() { throw new Error("Abstract method"); }
	Footer() { throw new Error("Abstract method"); }
	Info() { throw new Error("Abstract method"); }
}

class Alert
{
	static New(type, content, dismissable = true, dismiss="alert")
	{
		if (dismissable)
		{
			return "" +
				"<div class=\"alert alert-" + type + " alert-dismissible fade in\">" +
					"<a href=\"#\" class=\"close\" data-dismiss=\"" + dismiss + "\" aria-label=\"close\">&times;</a>" +
					content +
				"</div>";
		}
		else
		{
			return "" +
				"<div class=\"alert alert-" + type + " fade in\">" +
					content +
				"</div>";
		}
	}
}

$(document).ready(function()
{
	$('[data-toggle="popover"]').popover();
});