function otworz_detale(content)
{
element = document.getElementById(content);
if (element.style.display == 'none') element.style.display = 'block';
else if (element.style.display == 'block') element.style.display = 'none';

}

function zamknij_detale(content) 
{
element = document.getElementById(content);
if (element.style.display == 'block') element.style.display = 'none';
}

function sprawdz(formularz)
{
	for (i = 0; i < formularz.length; i++)
	{
		var pole = formularz.elements[i];
		if ((pole.type == "text" || pole.type == "password" || pole.type == "textarea") && pole.value == "")
		{
			alert("Proszê wype³niæ wszystkie pola!");
			return false;
		}
	}
	return true;
}


function spr_haslo(x)
{
element = document.getElementById('nowe_haslo_ok');
if (x.indexOf('a')) element.style.display = 'none';

}


