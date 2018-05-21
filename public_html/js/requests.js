class Request extends View
{
	constructor(id, username, title, status, submittedon)
	{
		super();
		this.id = id; // request id
		this.username = username;
		this.title = title;
		this.status = status;
		this.submittedon = submittedon;
	}
	
	AsView()
	{
		var status = "<span class=\"text-primary\"><b>Unknown</b></span>";
		
		if (this.status === null) status = "<span class=\"text-warning\"><b>Awaiting</b></span>";
		else if (this.status === true) status = "<span class=\"text-success\"><b>Accepted</b></span>";
		else if (this.status === false) status = "<span class=\"text-danger\"><b>Rejected</b></span>";
		
		return "";
	}
}

function accept(request)
{
	alert(request);
}

function reject(request)
{
	alert(request);
}