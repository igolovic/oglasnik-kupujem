function uncheckCounties()
{
	for(var i=1; i<=21; i++)
	{
		document.getElementById('ch' + i).checked = false;
	}
}

function uncheckAllCountriesOption()
{
	document.getElementById('chAll').checked = false;
}

function addFavorite()
{
	var title = "Kupujem";
	var url = "http://www.kupujem.com";
	if (window.sidebar)
	{ // Mozilla Firefox Bookmark
		window.sidebar.addPanel(title, url,"");
	} 
	else if( window.external )
	{ // IE Favorite
		window.external.AddFavorite( url, title); 
	}
	else if(window.opera && window.print) 
	{ // Opera Hotlist
		alert("Ova funkcija nije podržana za Opera preglednik. Molimo dodajte stranicu u favorite ručno.");
	}
}

function makeHomepage()
{
	var title = "Kupujem";
	var url = "http://www.kupujem.com";
	if (window.sidebar)
	{ // Mozilla Firefox homepage
		alert("Ova funkcija nije podržana za Firefox preglednik. Molimo postavite stranicu ručno.");
	} 
	else if( window.external )
	{ // IE homepage
		var el = document.getElementById('setHomePage');
		el.style.behavior='url(#default#homepage)';
		el.setHomePage(url);
	}
	else if(window.opera && window.print) 
	{ // Opera homepage
		alert("Ova funkcija nije podržana za Opera preglednik. Molimo dodajte stranicu u favorite ručno.");
	}
}