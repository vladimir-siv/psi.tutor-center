class Post extends View
{
	constructor(id, type, title, postedon, authorname, authorid)
	{
		super();
		this.id = id;
		this.type = type;
		this.title = title;
		this.postedon = postedon;
		this.authorname = authorname;
		this.authorid = authorid;
	}
	
	AsView()
	{
		return "<div class=\"font-times-new-roman\" style=\"background-color: inherit;\">"+
  		"<h4><a class=\"hover-text-decor-none\" href=\""+ window.location.protocol + "//" + window.location.host + "/Guest/post/" + this.id + "\">#" + this.id + " " + this.type + ": " + this.title + "</a><h4>"+
        "<h6>Posted on: <b>" + this.postedon + "</b> Author: <a class=\"hover-text-decor-none\" href=\""+ window.location.protocol + "//" + window.location.host + "/Guest/profile/" + this.authorid + "\"><b>" + this.authorname + "</b></a><h6>"+
		"</div>";
	}
}

var post_section, pagination_list, post_articles;
var pagination_pages = 0, active = 0;
var posts;

$(document).ready(function()
{
	if (typeof posts === "undefined") posts = [];
	
	post_section = $("section[data-type='posts']");
	pagination_list = post_section.find("ul[data-type='pagination']");
	post_articles = post_section.find("article[id]");
	
	pagination_pages = posts.length / post_articles.length;
	if (posts.length % post_articles.length != 0) pagination_pages++;
	
	for (var i = 1; i <= pagination_pages; i++)
		pagination_list.append("<li><a class=\"cursor-pointer\" onclick=\"switchPagination(" + i + ");\">" + i + "</a></li>");
	
	switchPagination(1);
});

function switchPagination(page)
{
	if (page == active) return;
	
	post_articles.show();
	
	pagination_list.find("li.active").removeClass("active");
	pagination_list.find("li:nth-child(" + page + ")").addClass("active");
	
	var j = 0;
	for (var i = (page - 1) * post_articles.length; i < posts.length && i < page * post_articles.length; i++)
		post_articles[j++].innerHTML = posts[i].AsView();
	
	for (; j < post_articles.length; j++) $(post_articles[j]).hide(); //post_articles[j].innerHTML = "";
	
	active = page;
}