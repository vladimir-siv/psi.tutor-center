function login(popupid, username, password)
{
    $("#" + popupid + "-popup-info").html("");
    if (username == "" && password == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter username!"));
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter password!"));
        return;
    }
    if (username == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter username!"));
        return;
    }
    if (password == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter password!"));
        return;
    }
	
    $.ajax
    ({
		url: "login",
		method: "POST",
		data: { username : username, password : password },
		dataType: "html",
    })
	.done(function(response) 
    {
		if (response.startsWith("#Error: "))
		{
			$("#" + popupid + "-popup-info").append(Alert.New("danger", response.substring(8), true));
			return;
		}
		
		$("#" + popupid + "-popup-info").append(Alert.New("success", response, true));
		window.location.reload();
    });
}

function logout()
{
	alertPopupFeed.content = Alert.New("success", "<b>Success!</b> You have logged out!", true, "modal");
	alertPopupFeed.Toggle(0);
}

function register(popupid, firstname, lastname, username, password, email)
{
    $("#" + popupid + "-popup-info").html("");
    if (firstname == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter firstname!"));
        return;
    }
    if (lastname == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter lastname!"));
        return;
    }
    if (username == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter username!"));
        return;        
    }
    if (password == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter password!"));
        return;        
    }
    if (email == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter email!"));
        return;         
    }
    $.ajax
    ({
		url: "register",
		method: "POST",
		data: { firstname: firstname, lastname : lastname, username : username, password : password, email : email},
		dataType: "html",
    })
	.done(function(response) 
    {
		if (response.startsWith("#Error: "))
		{
			$("#" + popupid + "-popup-info").append(Alert.New("danger", response.substring(8), true));
			return;
		}
		
		$("#" + popupid + "-popup-info").append(Alert.New("success", response, true));
		//window.location.reload();
    });
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