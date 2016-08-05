<?php
ob_start();
session_start();
include("sprawdz_log.php");
header('Content-Type: text/html; charset=iso-8859-2'); 


if(isset($_GET['id'])) $id=$_GET['id'];

//poloczenie z baza
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);


//stworzenie zapytania sql
$sql=("SELECT `Rezyserzy`.`Imie`, `Rezyserzy`.`Nazwisko`,
			  `Rezyserzy`.`ID_KRAJ`, `Kraje`.`Nazwa`
	    FROM `Rezyserzy`, `Kraje`
	   WHERE `Rezyserzy`.`ID_KRAJ`=`Kraje`.`ID_KRAJ`
	     AND `Rezyserzy`.`ID_REZ`=".$id);
//zapytanie
$wynik=mysql_query($sql) or die(mysql_error());
$rez = mysql_fetch_array($wynik, MYSQL_NUM);
////OPIS komorek tabeli REZ
// 0. Imie Rezysera
// 1. Nazwisko Rezysera
// 2. ID Kraju pochodzenia
// 3. Nazwa kraju pochodzenia

//wypisywanie

//sczegoly
echo("
<span class=\"detale_rez\">
kraj pochodzenia: <a href=\"pokaz.php?co=kraj&id=".$rez[2]."\" class=\"detale_link\"
title=\"Poka¿ wszystkie filmy z tego kraju\">"
.$rez[3]."</a><br>
</span>");

//liczba wszystkich i niewidzianych filmow
$sql=("SELECT DISTINCT `Tytul`, `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Ogladanie` 
	   ON (`Ogladanie`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Ogladanie`.`ID_OSOBA`=".$_SESSION['id_osoba'].")
	   WHERE `Filmy`.`ID_REZ`=".$id."
	   AND (`Ogladanie`.`ID_OSOBA` <>".$_SESSION['id_osoba']." 
	        OR `Ogladanie`.`ID_OSOBA` IS NULL) "
		);
$wynik_niewidziane=mysql_query($sql) or die(mysql_error());
$liczba_niewidziane = mysql_num_rows($wynik_niewidziane);
$sql=("SELECT DISTINCT *
	   FROM `Filmy` 
	   WHERE `Filmy`.`ID_REZ`=".$id
	 	);
$wynik_wszystkie=mysql_query($sql) or die(mysql_error());
$liczba_wszystkie = mysql_num_rows($wynik_wszystkie);

	    
echo("<br>
<div>Ilo¶æ filmów w bazie: <a href=\"pokaz.php?co=rez&id=".$id."\" class=\"detale_link\"
title=\"Poka¿ wszystkie filmy tego rezysera\"> ".$liczba_wszystkie." </a>");
if($liczba_niewidziane)
echo("
<br>w tym niewidzianych: <a href=\"pokaz.php?co=rez&n=1&id=".$id."\" class=\"detale_link\"
title=\"Poka¿ niewidziane filmy tego rezysera\"> ".$liczba_niewidziane." </a></div>
");
else echo("<br>widzia³e¶ wszystkie!</div>");

//panel administratora
echo("<span class=\"panel_admina\">");

if($uprawnienia_edycja)
{
echo("
<a href=\"edytuj.php?co=rez&id=".$id."\" 
onclick=\"return parent.GB_showCenter('Edytuj', this.href,175,425,reloadParentOnClose)\"
title=\"Edycja re¿ysera\">
<img src=\"icon/Windows-Write-32x32.png\" border=0></a><br>
");
}
if($uprawnienia_kasowanie)
{
echo("
<a href=\"usun.php?co=rez&id=".$id."\" 
onclick=\"return parent.GB_showCenter('Usuñ', this.href,175,425,reloadParentOnClose)\"
title=\"Usuñ re¿ysera\">
<img src=\"icon/System-Recycle-Bin-Full-32x32.png\" border=0></a><br>");
}

echo("
<a href=\"http://www.filmweb.pl/szukaj?q=".$rez[0]." ".$rez[1]."&c=person\"    
title=\"Szukaj w FilmWebie\" class=\"detale_link2\" onclick=\"return GB_showCenter('Filmweb', this.href,600,850)\" >
<img src=\"icon/filmweb_logo.jpg\" border=0></a></span>");



//koniec wypisywania
mysql_close($connect);
//zamkniecie polaczenia z baza