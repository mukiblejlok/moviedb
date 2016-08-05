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

//ktos chce zrezygnowaæ
if(isset($_GET['co']) && $_GET['co']=="rezygnuj")
{
if(isset($_GET['id'])) $id_film = $_GET['id']; 
////DECYZJA PODJETA
////nie rezygnujemy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Nie zrezygnowa³e¶ z filmu.<br />
Mo¿esz zamknaæ okno</div>");
}

//DECYZJA PODJETA
//rezygnujemy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

$sql=(" DELETE FROM `Pozyczki` 
	    WHERE `ID_FILM`=".$id_film." 
		AND `ID_OSOBA`=".$_SESSION['id_osoba']."
		LIMIT 1; 
	");
	//echo $sql;
	$wynik=mysql_query($sql) or die(mysql_error());
    //$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0>
<br>Zrezygnowales z tego filmu.<br />
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
//kto
$sql=("SELECT `osoby`.`IMIE`, `osoby`.`NAZWISKO`
	   FROM `osoby` WHERE `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$kto=mysql_fetch_array($wynik, MYSQL_NUM);	   

echo("<div id=\"okno_pytanie\">".$kto[0]." ".$kto[1].
",<br>czy napewno chcesz zrezygnowaæ z wypo¿yczania tego filmu?</div>
<div id=\"okno_film\">");


//Pobranie danych z $_GET jesli ustawione 
$sql=("SELECT `Filmy`.`TYTUL`, `Filmy`.`ROK`,  
			  `Rezyserzy`.`IMIE`, `Rezyserzy`.`NAZWISKO`, 
			  `Kraje`.`NAZWA`,`Filmy`.`NR_PLYTY` 
	  FROM `Filmy` , `Rezyserzy`, `Kraje`
	  WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
	  AND `Kraje`.`ID_KRAJ` = `Filmy`.`ID_KRAJ`
	  AND `Filmy`.`ID_FILM`=".$id_film." 
	  LIMIT 1;
	  ");
	  //echo $sql;
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("<br><b>".$wiersz[0]."</b><br> re¿. ".$wiersz[2]." ".$wiersz[3]."<br>".$wiersz[4].
", ".$wiersz[1]."<br></div>");

//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_film\">
<a href=\"wypozycz.php?id=".$id_film."&napewno=tak&co=rezygnuj\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"wypozycz.php?id=".$id_film."&napewno=nie&co=rezygnuj\" class=\"detale_link\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}


/////////////////////////////////
//KONIEC REZYGNOWANIA Z WYPOZYCZENIA
} 





else
{
///////////////////////////////////////////////////////////////////////
//WYPO¯YCZANIE FILMU
if(isset($_GET['id'])) $id_film = $_GET['id']; 

////DECYZJA PODJETA
////nie wypozyczamy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Film nie zosta³ wypozyczony.<br />
Mo¿esz zamknaæ okno</div>");
}

//DECYZJA PODJETA
//wypozyczamy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

$sql=("
	INSERT INTO `Pozyczki` (`ID`,`ID_OSOBA`,`ID_FILM`,`DATA`)
	VALUES (NULL,".$_SESSION['id_osoba'].",".$id_film.", NOW() );    
	");
	$wynik=mysql_query($sql) or die(mysql_error());
//$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Zamówienie na film(y) zosta³o przyjête.<br />
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
//kto
$sql=("SELECT `osoby`.`IMIE`, `osoby`.`NAZWISKO`
	   FROM `osoby` WHERE `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$kto=mysql_fetch_array($wynik, MYSQL_NUM);	   

echo("<div id=\"okno_pytanie\">".$kto[0]." ".$kto[1].
",<br>czy napewno chcesz z³o¿yæ zamówienie na ten film?</div>
<div id=\"okno_film\">");


//Pobranie danych z $_GET jesli ustawione 
$sql=("SELECT `Filmy`.`TYTUL`, `Filmy`.`ROK`,  
			  `Rezyserzy`.`IMIE`, `Rezyserzy`.`NAZWISKO`, 
			  `Kraje`.`NAZWA`,`Filmy`.`NR_PLYTY` 
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

//wypisywanie informacji o plycie jesli film jest CD_NA_DVD
if($wiersz[5]!=0){ 
	echo("<div id=\"okno_film\"><br />Ten film jest na p³ycie, na której s± te¿ inne filmy:<br /><br />");
		$sql=("SELECT `TYTUL` FROM `Filmy` WHERE `NR_PLYTY`=".$wiersz[5]." AND `ID_FILM`<>".$id_film);
        $wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
        while($plyta = mysql_fetch_array($wynik, MYSQL_NUM)) echo $plyta[0]." | ";
		echo "<br /></div>";
	}
//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_film\">
<a href=\"wypozycz.php?id=".$id_film."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}

}
/////////////////////////////////
//KONIEC WYPOZYCZANIA FILMU

?>





<?php include ('stopka_okno.php'); ?>
