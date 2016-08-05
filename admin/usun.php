<?php include("naglowek_okno.php");?>
<?php include("sprawdz_log.php"); ?> 
<body style="background-color:#DDDDDD;">
<div style="text-align: center;">

<?php 
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

///////////////////////////////////////////////////////////////////////
//USUWANIE FILMU
if(isset($_GET['co']) && $_GET['co']=="film")
{
if(isset($_GET['id']))$id_film = $_GET['id']; 

//DECYZJA PODJETA
//nie usuwamy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Film nie zosta³ usuniêty.<br><br>
Mo¿esz zamknaæ okno</div>");
}
//DECYZJA PODJETA
//usuwamy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

$sql=("DELETE FROM `Filmy` 
	   WHERE `Filmy`.`ID_FILM` =".$id_film." 
	   LIMIT 1
	   ");
$wynik=mysql_query($sql);  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Film zosta³ usuniêty!!!<br>
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
echo("
<div id=\"okno_pytanie\">Czy napewno chcesz usun±æ ten film?</div>
<div id=\"okno_film\">");

//Pobranie danych z $_GET jesli ustawione 
$sql=("SELECT `Filmy`.`TYTUL`, `Filmy`.`ROK`,  
			  `Rezyserzy`.`IMIE`, `Rezyserzy`.`NAZWISKO`, 
			  `Kraje`.`NAZWA` 
	  FROM `Filmy` , `Rezyserzy`, `Kraje`
	  WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
	  AND `Kraje`.`ID_KRAJ` = `Filmy`.`ID_KRAJ`
	  AND `Filmy`.`ID_FILM`=".$id_film."
	  LIMIT 1
	  ");
$wynik=mysql_query($sql);  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("<br><b>".$wiersz[0]."</b><br> re¿. ".$wiersz[2]." ".$wiersz[3]."<br>".$wiersz[4].
", ".$wiersz[1]."<br></div>");

//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_pytanie\">
<a href=\"usun.php?co=film&id=".$id_film."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}

}
/////////////////////////////////
//KONIEC USUWANIA FILMU






///////////////////////////////////////////////////////////////////////
//USUWANIE REZYSERA
if(isset($_GET['co']) && $_GET['co']=="rez")
{
if(isset($_GET['id']))$id_rez = $_GET['id']; 

//DECYZJA PODJETA
//nie usuwamy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Re¿yser nie zosta³ usuniêty.<br><br>
Mo¿esz zamknaæ okno</div>");
}
//DECYZJA PODJETA
//usuwamy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

$sql=("DELETE FROM `Rezyserzy` 
	   WHERE `Rezyserzy`.`ID_REZ` =".$id_rez." 
	   LIMIT 1;");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Re¿yser zosta³ usuniêty!!!<br>
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
echo("
<div id=\"okno_pytanie\">Czy napewno chcesz usun±æ tego re¿ysera?</div>
<div id=\"okno_film\">");

//Pobranie danych z $_GET jesli ustawione 
$sql=("SELECT `Rezyserzy`.`IMIE`, `Rezyserzy`.`NAZWISKO`, 
			  `Kraje`.`NAZWA` 
	  FROM  `Rezyserzy`, `Kraje`
	  WHERE `Rezyserzy`.`ID_KRAJ` = `Kraje`.`ID_KRAJ`
	  AND   `Rezyserzy`.`ID_REZ`=".$id_rez."
	  LIMIT 1
	  ");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("<br><b>".$wiersz[0]." ".$wiersz[1]."</b><br>pochodzenie: ".$wiersz[2]."<br></div>");

//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_pytanie\">
<a href=\"usun.php?co=rez&id=".$id_rez."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}

}
/////////////////////////////////
//KONIEC USUWANIA RE¯YSERA






///////////////////////////////////////////////////////////////////////
//USUWANIE KRAJU
if(isset($_GET['co']) && $_GET['co']=="kraj")
{
if(isset($_GET['id']))$id_kraj = $_GET['id']; 

//DECYZJA PODJETA
//nie usuwamy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Kraj nie zosta³ usuniêty.<br><br>
Mo¿esz zamknaæ okno</div>");
}
//DECYZJA PODJETA
//usuwamy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

$sql=("DELETE FROM `Kraje` 
	   WHERE `Kraje`.`ID_KRAJ` =".$id_kraj." 
	   LIMIT 1;");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Kraj zosta³ usuniêty!!!<br>
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
echo("
<div id=\"okno_pytanie\">Czy napewno chcesz usun±æ ten kraj?</div>
<div id=\"okno_film\">");

//Pobranie danych z $_GET jesli ustawione 
$sql=("SELECT `Kraje`.`NAZWA` 
	  FROM    `Kraje`
	  WHERE   `Kraje`.`ID_KRAJ`=".$id_kraj."
	  LIMIT 1
	  ");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("<br><b>".$wiersz[0]."</b><br></div>");

//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_pytanie\">
<a href=\"usun.php?co=kraj&id=".$id_kraj."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}

}
/////////////////////////////////
//KONIEC USUWANIA KRAJU




///////////////////////////////////////////////////////////////////////
//USUWANIE OSOBY
if(isset($_GET['co']) && $_GET['co']=="osoba")
{
if(isset($_GET['id']))$id_osb = $_GET['id']; 

//DECYZJA PODJETA
//nie usuwamy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Osoba nie zosta³a usuniêta.<br><br>
Mo¿esz zamknaæ okno</div>");
}
//DECYZJA PODJETA
//usuwamy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

$sql=("DELETE FROM `osoby` WHERE `osoby`.`ID_OSOBA` =".$id_osb." ;");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$sql=("DELETE FROM `Ogladanie` WHERE `ID_OSOBA` =".$id_osb." ;");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$sql=("DELETE FROM `Oceny` WHERE `ID_OSOBA` =".$id_osb." ;");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania



echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Osoba zosta³a usuniêta!!!<br>
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
echo("
<div id=\"okno_pytanie\">Czy napewno chcesz usun±æ t± osobê?</div>
<div id=\"okno_film\">");

//Pobranie danych z $_GET jesli ustawione 
$sql=("SELECT `osoby`.`IMIE`, `osoby`.`NAZWISKO`, `osoby`.`LOGIN`, `osoby`.`EMAIL` 
	  FROM    `osoby`
	  WHERE   `osoby`.`ID_OSOBA`=".$id_osb."
	  LIMIT 1
	  ");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("<br><b>".$wiersz[0]." ".$wiersz[1]."</b><br>login: ".$wiersz[2]."<br>
e-mail: ".$wiersz[3]."<br></div>");

//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_pytanie\">
<a href=\"usun.php?co=osoba&id=".$id_osb."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}

}
/////////////////////////////////
//KONIEC USUWANIA OSOBY

//koniec polaczenia
mysql_close($connect);
//////////////////
?>

</div>
<?php include("stopka_okno.php"); ?>