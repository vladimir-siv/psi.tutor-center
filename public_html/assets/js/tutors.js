class Tutor extends View
{
	constructor(id, completed, description, firstname, lastname)
	{
		super();
		this.id = id;
		this.completed = completed;
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
			"<p class=\"font-times-new-roman font-xs\"><b>Completed: " + this.completed + "</b></p>" +
			"<p class=\"font-times-new-roman font-xs\"><i>" + this.description + "</i></p>";
	}
}

var tutor_section, pagination_list, tutor_articles;
var pagination_pages = 0, active = 0;
var tutors;

$(document).ready(function()
{
	if (typeof tutors === "undefined") tutors = [];
	
	tutor_section = $("section[data-type='tutors']");
	pagination_list = tutor_section.find("ul[data-type='pagination']");
	tutor_articles = tutor_section.find("article[id]");
	
	pagination_pages = tutors.length / tutor_articles.length;
	if (tutors.length % tutor_articles.length != 0) pagination_pages++;
	
	for (var i = 1; i <= pagination_pages; i++)
		pagination_list.append("<li><a class=\"cursor-pointer\" onclick=\"switchPagination(" + i + ");\">" + i + "</a></li>");
	
	switchPagination(1);
});

function switchPagination(page)
{
	if (page == active) return;
	
	tutor_articles.show();
	
	pagination_list.find("li.active").removeClass("active");
	pagination_list.find("li:nth-child(" + page + ")").addClass("active");
	
	var j = 0;
	for (var i = (page - 1) * tutor_articles.length; i < tutors.length && i < page * tutor_articles.length; i++)
		tutor_articles[j++].innerHTML = tutors[i].AsView();
	
	for (; j < tutor_articles.length; j++) $(tutor_articles[j]).hide(); //tutor_articles[j].innerHTML = "";
	
	active = page;
}