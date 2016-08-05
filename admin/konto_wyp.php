<?php

if(!($_SESSION['id_osoba']==1))
{
echo("<br /><br />");

$sql=("SELECT `ID_FILM` 
	   FROM `Pozyczki` 
	   WHERE `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$ilosc_checi=mysql_num_rows($wynik);

if($ilosc_checi) //czy ta osoba jest chetna na jakis film
{
echo("<div id=\"lista_filmow_top\">
Zg³osi³e¶ chêæ wypo¿yczenia na te filmy</div>");
	while($checi = mysql_fetch_array($wynik, MYSQL_NUM)) 
	{
	wypisz_film($checi[0]);
	}
echo("<div id=\"lista_filmow_stopka\">razem ".$ilosc_checi."
 filmów</div>");
}
else echo("<div id=\"lista_filmow_top\">Nie zg³osi³e¶ chêci na ¿aden film
	       </div>");


echo("<br /><br />");

$sql=("SELECT `ID_FILM` 
	   FROM `Filmy` 
	   WHERE `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$ilosc_filmy=mysql_num_rows($wynik);

if($ilosc_filmy) //czy ta wypozyczy³a jakis film
{
echo("<div id=\"lista_filmow_top\">
Wypo¿yczy³e¶ te filmy</div>");
	while($filmy = mysql_fetch_array($wynik, MYSQL_NUM)) 
	{
	wypisz_film($filmy[0]);
	}
echo("<div id=\"lista_filmow_stopka\">razem ".$ilosc_filmy."
 filmów</div>");
}
else echo("<div id=\"lista_filmow_top\">Nie masz wypo¿yczonych ¿adnych
 filmów</div>");
}

else
{

}
?>






