var mainPopup;
var loginPopupFeed;
var registerPopupFeed;
var alertPopup;
var alertPopupFeed;

$(document).ready(function()
{
	mainPopup = new Popup(Config.mainPopupId);
	
	loginPopupFeed = new LoginPopupFeed("login");
	loginPopupFeed.Subscribe(mainPopup);
	
	registerPopupFeed = new RegisterPopupFeed("register");
	registerPopupFeed.Subscribe(mainPopup);
	
	alertPopup = new AlertPopup(Config.alertPopupId);
	
	alertPopupFeed = new AlertPopupFeed(Alert.New("success", "<b>Success!</b> The job is done.", false));
	alertPopupFeed.Subscribe(alertPopup);
});

function login(popupid, username, password)
{
	mainPopup.Toggle();
	$("#content")[0].style.height = "1000px";
	//$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> Invalid combination [\"" + username + "\" & \"" + password + "\"]."));
}

function register(popupid, firstname, lastname, username, password, email)
{
	$("#" + popupid + "-popup-info").append(Alert.New("success", "<b>Success!</b> You have successfully registered to the system."));
	//$("#" + popupid + "-popup-info").append(Alert.New("success", firstname + " " + lastname + " " + username + " " + password + " " + email));
}