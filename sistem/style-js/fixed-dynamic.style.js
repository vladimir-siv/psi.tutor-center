var win = $(window), doc = $(document);
var body, wrapper, fixedHeader, header, navbar, content, footer;

doc.ready(function()
{
    body = $(document.body);
	fixedHeader = $("body > #wrapper > #top-content-fixed > #header-fixed");
	wrapper = $("body > #wrapper");
	header = $("body > #wrapper > #header-main");
	navbar = $("body > #wrapper > #navbar-main");
	content = $("body > #wrapper > #content");
	footer = $("body > #wrapper > #footer-main");
	
	//win.on("resize", onWindowResize);
	win.on("scroll", onWindowScroll);
	
	//onWindowResize();
	onWindowScroll();
});

function onWindowResize(e)
{
	if (!win.hasScrollBar())
		content[0].style.height = (goip(wrapper[0], "height") - (goip(header[0], "height") + goip(navbar[0], "height") + goip(footer[0], "height"))) + "px";
}

function onWindowScroll(e)
{
	if (win.scrollTop() > getObjectIntProperty(header[0], "height") + getObjectIntProperty(navbar[0], "height"))
	{
		if (!fixedHeader.hasClass("on-top")) fixedHeader.addClass("on-top");
	}
	else if (fixedHeader.hasClass("on-top")) fixedHeader.removeClass("on-top");
}