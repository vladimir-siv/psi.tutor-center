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
		url: "http://" + window.location.host + "/Utility/login",
		method: "POST",
		data: { username : username, password : password },
		dataType: "html"
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
    $.ajax
    ({
		url: "http://" + window.location.host + "/Utility/logout",
		method: "POST",
		dataType: "html"
    })
	.done(function(response)
	{
		window.location.reload();
	});
}

function register(popupid, firstname, lastname, username, password, email, birthdate)
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
		url: "http://" + window.location.host + "/Utility/register",
		method: "POST",
		data: { firstname: firstname, lastname : lastname, username : username, password : password, email : email, birthdate : birthdate},
		dataType: "html"
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

function sendRequest(position, description)
{
    if (position == "")
    {
        alertPopupFeed.content = Alert.New("danger", "You must enter title of request.", true, "modal");
		alertPopupFeed.Toggle(0);
        return;        
    }
    if (description == "")
    {
        alertPopupFeed.content = Alert.New("danger", "You must enter description of request.", true, "modal");
		alertPopupFeed.Toggle(0);
        return;         
    }
    $.ajax
    ({
		url: "http://" + window.location.host + "/User/requestPromotion",
		method: "POST",
		data: { position: position, description : description},
		dataType: "html"
    })
	.done(function(response) 
    {
		if (response.startsWith("#Error: "))
		{
			alertPopupFeed.content = Alert.New("danger", response.substring(8), true, "modal");
			alertPopupFeed.Toggle(0);
			return;
		}
		alertPopupFeed.content = Alert.New("success", response, true, "modal");
		alertPopupFeed.Toggle(0);
		window.location.reload();
    });
}

function toggleSeen(notificationid)
{
	alert("'" + notificationid + "'");
}

function createSubject(popupid, name, description)
{
	$("#" + popupid + "-popup-info").html("");
	if (name == "")
	{
		$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter name!"));
		return;
	}
	if (description == "")
	{
		$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter description!"));
		return;      
	}
	$.ajax
	({
		url: "http://" + window.location.host + "/Utility/createSubject",
		method: "POST",
		data: { name : name, description : description },
		dataType: "html"
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

function createSection(popupid, name, subject, description)
{
       $("#" + popupid + "-popup-info").html("");
	if (name == "")
	{
		$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter name!"));
		return;
	}
        if (subject == "")
        {
                $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter name!"));
		return;
        }
	if (description == "")
	{
		$("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter description!"));
		return;      
	}
	$.ajax
	({
		url: "http://" + window.location.host + "/Utility/createSection",
		method: "POST",
		data: { name : name, subject : subject, description : description },
		dataType: "html"
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

function changeAbout(popupid, description)
{
    alert("Pozvala se uspesno funkcija"); // poziva se promena about tutora
}

function changeDatails(popupid, firstname, lastname, email, birthdate)
{
    alert("Pozvala se uspesno funkcija"); // poziva se promena tutor datailsa 
}

function sellTokens(popupid, accountnumber, amountTokens, amountEuro)
{
    $("#" + popupid + "-popup-info").html("");
    if (accountnumber == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter account number!"));
        return;
    }
    if (amountTokens == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter amount Tokens!"));
        return;
    }
    $.ajax
    ({
		url: "http://" + window.location.host + "/Utility/sellTokens",
		method: "POST",
		data: { accountnumber : accountnumber, amountTokens: amountTokens },
		dataType: "html"
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

function buyTokens(popupid, accountnumber, amountEuro, amountTokens)
{	
    $("#" + popupid + "-popup-info").html("");
    if (accountnumber == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter account number!"));
        return;
    }
    if (amountEuro == "")
    {
        $("#" + popupid + "-popup-info").append(Alert.New("danger", "<b>Error.</b> You must enter amount euro!"));
        return;
    }
    $.ajax
    ({
		url: "http://" + window.location.host + "/Utility/buyTokens",
		method: "POST",
		data: { accountnumber : accountnumber, amountEuro: amountEuro },
		dataType: "html"
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

function deleteSubject(){
	alert($(location).attr("href").split('/').pop());
}