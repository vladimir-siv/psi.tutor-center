function login(popupid, username, password)
{
	$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> Invalid combination [\"" + username + "\" & \"" + password + "\"]."));
}

function logout()
{
	alertPopupFeed.content = Alert.New("success", "<b>Success!</b> You have logged out!", true, "modal");
	alertPopupFeed.Toggle(0);
}

function register(popupid, firstname, lastname, username, password, email)
{
	$("#" + popupid + "-popup-info").append(Alert.New("success", "<b>Success!</b> You have successfully registered to the system."));
}

function sendMail(name, email, subject, message)
{
	alertPopupFeed.content = Alert.New("success", "<b>Success!</b> Mail has been sent. Thank you!", true, "modal");
	alertPopupFeed.Toggle(0);
}

function toggleSeen(notificationid)
{
	alert("'" + notificationid + "'");
}

function createSubject(popupid, name, description)
{
  $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> Invalid combination [\"" + name + "\" & \"" + description + "\"]."));
}

function createSection(popupid, name, subject, description)
{
  $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> Invalid combination [\"" + name + "\" & \"" + subject + "\" & \"" + description + "]."));
}

function changeAboutTutor(popupid, description)
{
    alert("Pozvala se uspesno funkcija"); // poziva se promena about tutora
}

function changeTutorDatails(popupid, firstname, lastname, email, birthdate)
{
    alert("Pozvala se uspesno funkcija"); // poziva se promena tutor datailsa 
}

function sellTokens(popupid, accountnumber, amountTokens, amountEuro)
{
	alert("Pozvala se uspesno funkcija1") // poziva se prodaja tokena
}

function buyTokens(popuid, accountnumber, amountEuro, amountTokens)
{
	alert("Pozvala se uspesno funkcija2") // poziva se kupovina tokena	
}