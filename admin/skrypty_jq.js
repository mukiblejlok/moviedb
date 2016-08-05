//rozwijanie newsów
$(document).ready(
function()
{
	$(".news_tresc").children("a#dalej").click( function() { $(this).next("span#cd").toggle(); })
	.toggle(function() { $(this).text(''); }, function() { $(this).text(" ...rozwiñ"); });
	;
});
	
	
//walidacja hasla w zmianie has³a
$(document).ready(
function()
{
	$("form[name=zmiana_hasla] input[name=nowe2]").keyup(
	function()
	{
		if ($(this).val().length > 2  && ($(this).val()==$("form[name=zmiana_hasla] input[name=nowe1]").val()))
		{
			$("span#nowe_haslo_ok").show()
		}
		else
		{
			$("span#nowe_haslo_ok").hide()
		}
			
	});
});

//testowa zmiana diva
function detale_filmu(id)
{
$("#detale_film_"+id).toggle();
$("#detale_film_"+id).load("detale_film.php"+"?id="+id);
$("div.detale_filmu").not("#detale_film_"+id).hide();
};

function detale_filmu_ocena(id,ocena)
{
$("#detale_film_"+id).show();
$("#detale_film_"+id).load("detale_film.php"+"?id="+id+"&ocena="+ocena);
$("div.detale_filmu").not("#detale_film_"+id).hide();
};




function detale_rezyser(id)
{
$("#detale_rez_"+id).toggle();
$("#detale_rez_"+id).load("detale_rez.php?id="+id);
$("div.detale_rezysera").not("#detale_rez_"+id).hide();
};

function detale_kraj(id)
{
$("#detale_kraj_"+id).toggle();
$("#detale_kraj_"+id).load("detale_kraj.php?id="+id);
$("div.detale_kraju").not("#detale_kraj_"+id).hide();
};

function detale_osoba(id)
{
$("#detale_osoba_"+id).toggle();
$("#detale_osoba_"+id).load("detale_osoba.php?id="+id);
$("div.detale_osoby").not("#detale_osoba_"+id).hide();
};


//oceny
function pokaz_oceny(id)
{
	$("#twoja_ocena_"+id).html("#");
	$("div#detale_oceny_"+id).show();
	$("#sr_ocena_"+id).hide();
	
	
}

function podswietl_ocena(ocena,film,ile)
{
	var i;
	for(i=0;i<ocena;i++)
	{
	$("#link_ocena_"+i+"_film_"+film).css({'background-color' : '#3074A7','height' : '12px' });
	}
    for(i=(ocena+1);i<=ile;i++)
	{
	$("#link_ocena_"+i+"_film_"+film).css({'background-color' : 'white','height' : '12px' });
	}
	$("#link_ocena_"+ocena+"_film_"+film).css({'background-color' : 'red','height' : '12px' });
	
	$("#twoja_ocena_"+film).html(ocena/10);
}

function skasuj_podswietlenie(ocena,film,ile)
{
	var i;
	for(i=0;i<=ile;i++)
	{
	$("#link_ocena_"+i+"_film_"+film).css({'background-color' : 'white','height' : '12px' });	
	}
	$("#twoja_ocena_"+film).html('#');
}

//rok
function podswietl_rok(rok,ile)
{
	
	$("#link_rok_"+rok).css({'background-color' : 'red','height' : '12px' });
	$("#twoj_rok").html(rok);
}

function skasuj_podswietlenie_rok(rok,ile)
{
	var i;
	for(i=0;i<=ile;i++)
	{
	$("#link_rok_"+i).css({'background-color' : 'white','height' : '12px' });	
	}
	$("#twoj_rok").html('#');
}

