function searchdb(type, parameters)
{
	var colon = type.lastIndexOf(":");
	var domain, additive;
	
	if (colon != -1)
	{
		domain = type.slice(0, colon);
		additive = type.slice(colon + 1);
	}
	else domain = type;
	
	
	
}