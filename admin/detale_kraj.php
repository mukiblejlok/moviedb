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
$sql=("SELECT `Kraje`.`Nazwa`
	    FROM  `Kraje`
	   WHERE `Kraje`.`ID_KRAJ`=".$id);
//zapytanie
$wynik=mysql_query($sql) or die(mysql_error());
$kraj = mysql_fetch_array($wynik, MYSQL_NUM);
////OPIS komorek tabeli KRAJ
// 0. Nazwa kraju


//wypisywanie
//liczba wszystkich i niewidzianych filmow
$sql=("SELECT DISTINCT `Tytul`, `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Ogladanie` 
	   ON (`Ogladanie`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Ogladanie`.`ID_OSOBA`=".$_SESSION['id_osoba'].")
	   WHERE `Filmy`.`ID_KRAJ`=".$id."
	   AND (`Ogladanie`.`ID_OSOBA` <>".$_SESSION['id_osoba']." 
	        OR `Ogladanie`.`ID_OSOBA` IS NULL) "
		);
$wynik_niewidziane=mysql_query($sql) or die(mysql_error());
$liczba_niewidziane = mysql_num_rows($wynik_niewidziane);
$sql=("SELECT DISTINCT *
	   FROM `Filmy` 
	   WHERE `Filmy`.`ID_KRAJ`=".$id
	 	);
$wynik_wszystkie=mysql_query($sql) or die(mysql_error());
$liczba_wszystkie = mysql_num_rows($wynik_wszystkie);

	    
echo("<br>
<div>Ilo¶æ filmów w bazie: <a href=\"pokaz.php?co=kraj&id=".$id."\" class=\"detale_link\"
title=\"Poka¿ wszystkie filmy z tego kraju\"> ".$liczba_wszystkie." </a>");
if($liczba_niewidziane)
echo("
<br>w tym niewidzianych: <a href=\"pokaz.php?co=kraj&n=1&id=".$id."\" class=\"detale_link\"
title=\"Poka¿ niewidziane filmy z tego kraju\"> ".$liczba_niewidziane." </a></div>
");
else echo("<br>widzia³e¶ wszystkie!</div>");

//rezyserzy z tego kraju
echo("<br><div>Liczba re¿yserów z tego kraju: ");
$sql=("SELECT DISTINCT *
	   FROM `Rezyserzy` 
	   WHERE `Rezyserzy`.`ID_KRAJ`=".$id
	 	);
$wynik_wszystkie=mysql_query($sql) or die(mysql_error());
$liczba_wszystkie = mysql_num_rows($wynik_wszystkie);
echo("<a href=\"pokaz.php?co=rez_kraj&id=".$id."\" class=\"detale_link\"
title=\"Poka¿ re¿yserów z tego kraju\"> ".$liczba_wszystkie."</a></div>");

//panel administratora
echo("<span class=\"panel_admina\">");

if($uprawnienia_edycja)
{
echo("
<a href=\"edytuj.php?co=kraj&id=".$id."\"
onclick=\"return parent.GB_showCenter('Edytuj', this.href,100,425,reloadParentOnClose)\"
title=\"Edycja kraju\">
<img src=\"icon/Windows-Write-32x32.png\" border=0></a><br>
");
}

echo("
<a href=\"http://pl.wikipedia.org/wiki/".$kraj[0]."\"    
title=\"Info z Wikipedi\" class=\"detale_link2\" 
onclick=\"return GB_showCenter('Wikipedia', this.href,600,850,reloadParentOnClose)\">
<img src=\"icon/logo_wikipedia.png\" border=0></a> ");

if($uprawnienia_kasowanie)
{
echo("
<a href=\"usun.php?co=kraj&id=".$id."\" 
onclick=\"return parent.GB_showCenter('Usuñ', this.href,175,425,reloadParentOnClose)\"
title=\"Usuñ kraj\">
<img src=\"icon/System-Recycle-Bin-Full-32x32.png\" border=0></a>");
}
echo("</span>");


//koniec wypisywania
mysql_close($connect);
//zamkniecie polaczenia z baza