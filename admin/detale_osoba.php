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
$sql=("SELECT `osoby`.`Imie`, `osoby`.`Nazwisko`,
			  `osoby`.`LOGIN`, `osoby`.`EMAIL`,
			  `osoby`.`NR_GG`, `osoby`.`UPR_KASOWANIE`,
			  `osoby`.`UPR_EDYCJA`, `osoby`.`UPR_WLASNOSC`
		FROM `osoby`
	   WHERE `osoby`.`ID_OSOBA`=".$id);
//zapytanie
$wynik=mysql_query($sql) or die(mysql_error());
$osoba = mysql_fetch_array($wynik, MYSQL_NUM);
////OPIS komorek tabeli OSOBA
//0. Imie
//1. Nazwisko
//2. Login
//3. email
//4. numer gg
//5. uprawnienia na kasowanie
//6. uprawnienia na edycje
//7. uprawnienia wlasnosciowe

//liczba wypozyczonych filmow
$sql=("SELECT DISTINCT * FROM `Filmy` WHERE `ID_OSOBA`=".$id."");
$wynik2=mysql_query($sql) or die(mysql_error());
$liczba_wszystkie = mysql_num_rows($wynik2);

//liczba filmow na ktore jest chetna ta osoba
$sql=("SELECT DISTINCT * FROM `Pozyczki` WHERE `ID_OSOBA`=".$id."");
$wynik3=mysql_query($sql) or die(mysql_error());
$liczba_wypozycz = mysql_num_rows($wynik3);


//wypisywanie
echo("
<span class=\"detale_rez\"> 
login: ".$osoba[2]."<br>
email: <a href=\"mailto:".$osoba[3]."\" class=\"detale_link\" 
title=\"Napisz maila\"> ".$osoba[3]."</a><br>
gg: <a href=\"gg:".$osoba[4]."\" class=\"detale_link\"
title=\"Napisz wiadomosc na gg\"> ".$osoba[4]."</a><br>
");

//przypomnij has�o
echo("<br />
<a href=\"przypomnij_haslo.php?id=".$id."\" class=\"detale_link\" 
title=\"je�li ta osoba zapomniala haslo, to mozesz wygenerowa� nowe\"
onclick=\"return parent.GB_showCenter('Nowe', this.href,175,425)\">Wygeneruj nowe has�o</a>
");

//liczba wypozyczonych film�w
echo("<div><br>");
if($liczba_wszystkie)
echo("
Liczba wypo�yczonych filmow: <a href=\"pokaz.php?co=osoba&id=".$id."\" class=\"detale_link\"
title=\"Poka� wszystkie filmy, kt�re wypo�ycza ta osoba\">"
.$liczba_wszystkie."</a><br>
");
//liczba filmow na ktore jest chetny
if($liczba_wypozycz)
echo("
Liczba filmow ktore chce wypo�yczy�: <a href=\"wyp_zgloszenia.php?co=osoba&id=".$id."\" class=\"detale_link\"
title=\"Poka� wszystkie filmy, kt�re chce wypo�yczy� ta osoba\">"
.$liczba_wypozycz."</a><br>");
echo("</div>");


//uprawnienia
echo("<span class=\"detale_uprawnienia\">edycja: ");
if($osoba[6]) 
echo("<img src=\"icon/Symbols-Tips-16x16.png\" title=\"Ta osoba mo�e edytowa� filmy\">");
else 
echo("<img src=\"icon/Symbols-Error-16x16.png\" title=\"Ta osoba nie mo�e edytowa� film�w\">");

echo("<br>kasowanie: ");
if($osoba[5]) 
echo("<img src=\"icon/Symbols-Tips-16x16.png\" title=\"Ta osoba mo�e kasowa� filmy\">");
else 
echo("<img src=\"icon/Symbols-Error-16x16.png\" title=\"Ta osoba nie mo�e kasowa� film�w\">");
echo("</span>");


//panel administratora
echo("<span class=\"panel_admina\">");

if($uprawnienia_kasowanie)
{
echo("
<a href=\"usun.php?co=osoba&id=".$id."\" 
onclick=\"return parent.GB_showCenter('Usu�', this.href,175,425,reloadParentOnClose)\"
title=\"Usu� osobe\">
<img src=\"icon/System-Recycle-Bin-Full-32x32.png\" border=0></a><br>");
}

echo("</span>");


echo("</div>");
//koniec wypisywania
mysql_close($connect);
//zamkniecie polaczenia z baza
