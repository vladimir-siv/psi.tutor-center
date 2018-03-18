function login(popupid, username, password)
{
	$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> Invalid combination [\"" + username + "\" & \"" + password + "\"]."));
}

function register(popupid, firstname, lastname, username, password, email)
{
	$("#" + popupid + "-popup-info").append(Alert.New("success", "<b>Success!</b> You have successfully registered to the system."));
}

function sendMail(name, email, subject, message)
{
	alertPopupFeed.content = Alert.New("success", "<b>Success!</b> Mail has been sent. Thank you!", true);
	alertPopupFeed.Toggle(0);
}