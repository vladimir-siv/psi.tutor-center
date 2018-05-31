class User extends View
{
	constructor(id, description, firstname, lastname)
	{
		super();
		this.id = id;
		this.description = description;
		this.firstname = firstname;
		this.lastname = lastname;
	}
	
	AsView()
	{
		return "" +
			"<a class=\"hover-text-decor-none\" href=\"profile/" + this.id + "\">" +
				"<img class=\"rounded-oval\" src=\""+ window.location.protocol + "//" + window.location.host + "/assets/storage/users/" + this.id + "/avatar.png\" width=\"120\" height=\"120\"/><p name=\"id\" class=\"font-times-new-roman font-sm\"><b>" + this.firstname  + " " + this.lastname + "</b></p>" +
			"</a>" +
			"<p class=\"font-times-new-roman font-xs\"><i>" + this.description + "</i></p>";
	}
}

var user_section, pagination_list, user_articles;
var pagination_pages = 0, active = 0;
var users;

$(document).ready(function()
{
	if (typeof users === "undefined") users = [];
	
	user_section = $("section[data-type='users']");
	pagination_list = user_section.find("ul[data-type='pagination']");
	user_articles = user_section.find("article[id]");
	
	pagination_pages = users.length / user_articles.length;
	if (users.length % user_articles.length != 0) pagination_pages++;
	
	for (var i = 1; i <= pagination_pages; i++)
		pagination_list.append("<li><a class=\"cursor-pointer\" onclick=\"switchPagination(" + i + ");\">" + i + "</a></li>");
	
	switchPagination(1);
});

function switchPagination(page)
{
	if (page == active) return;
	
	user_articles.show();
	
	pagination_list.find("li.active").removeClass("active");
	pagination_list.find("li:nth-child(" + page + ")").addClass("active");
	
	var j = 0;
	for (var i = (page - 1) * user_articles.length; i < users.length && i < page * user_articles.length; i++)
		user_articles[j++].innerHTML = users[i].AsView();
	
	for (; j < user_articles.length; j++) $(user_articles[j]).hide(); //tutor_articles[j].innerHTML = "";
	
	active = page;
}