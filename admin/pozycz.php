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
//ZATWIERDZENIE WYPOZYCZENIA

if(isset($_GET['id'])) $id_film = $_GET['id']; 

////DECYZJA PODJETA
////nie wypozyczamy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
Czy chcesz usun±æ to zg³oszenie ?
<br /><br />
<a href=\"pozycz.php?id=".$id_film."&napewno=nie_usun&komu=".$_GET['komu']."\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}


////DECYZJA PODJETA
////nie wypozyczamy i usuwamy zg³oszenie
else if(isset($_GET['napewno']) && $_GET['napewno']=="nie_usun")
{

$sql=(" DELETE FROM `Pozyczki` 
	    WHERE `ID_FILM`=".$id_film." 
		AND `ID_OSOBA`=".$_GET['komu']."
		LIMIT 1; 
	");
	//echo $sql;
	$wynik=mysql_query($sql) or die(mysql_error());

echo("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br />Usun±³e¶ to zamówienie.<br />
Mo¿esz zamknaæ okno.</div>
");
}




//DECYZJA PODJETA
//wypozyczamy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

	if(isset($_GET['plyta']) && $_GET['plyta']) 
 	{
 	//ustawianie aktualnego posiadacza filmu
	$sql=("UPDATE `Filmy` SET `ID_OSOBA` =".$_GET['komu']."          
		  WHERE `Filmy`.`NR_PLYTY`=".$_GET['plyta']." 
		  ");
    $wynik=mysql_query($sql) or die(mysql_error());
	}
	
	else
	{
	//ustawianie aktualnego posiadacza filmu
	$sql=("UPDATE `Filmy` SET `ID_OSOBA` =".$_GET['komu']."          
		  WHERE `Filmy`.`ID_FILM`=".$id_film." 
		  ");
    $wynik=mysql_query($sql) or die(mysql_error());
   	}
	
//kasowanie zgloszenia 
$sql=("DELETE FROM `Pozyczki` WHERE `ID_FILM`=".$_GET['id']."
 	   AND `ID_OSOBA` =".$_GET['komu']."
 	   LIMIT 1;
	   ");
$wynik=mysql_query($sql) or die(mysql_error());

//dodanie wypozyczenia do tabeli z histori± wypo¿yczen
$sql=("INSERT INTO `Wypozyczenia` (`ID`,`ID_OSOBA`,`ID_FILM`,`DATA`)
       VALUES (NULL,".$_GET['komu'].",".$_GET['id'].",NOW())
      ");
$wynik=mysql_query($sql) or die(mysql_error());

echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Wypozyczy³e¶ ten film (te filmy).<br />
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
//komu
$sql=("SELECT `IMIE`, `NAZWISKO` FROM `osoby` WHERE `ID_OSOBA`=".$_GET['komu']);
$wynik=mysql_query($sql) or die(mysql_error());
$osoba = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania


echo("<div id=\"okno_pytanie\">Czy napewno chcesz wypozyczyæ tej osobie <br /><b>".$osoba[0]." ".$osoba[1]."</b><br />
ten film?</div>
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
		$cd_na_dvd=1;
		}
//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_film\">");

if($cd_na_dvd) echo("<a href=\"pozycz.php?id=".$id_film."&napewno=tak&komu=".$_GET['komu']."&plyta=".$wiersz[5]."\" class=\"detale_link\">");
else echo("<a href=\"pozycz.php?id=".$id_film."&napewno=tak&komu=".$_GET['komu']."\" class=\"detale_link\">");



echo("
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"pozycz.php?id=".$id_film."&napewno=nie&komu=".$_GET['komu']."\" class=\"detale_link\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}


/////////////////////////////////
//KONIEC ZATWIERDZANIA POZYCZANIA FILMU

?>





<?php include ('stopka_okno.php'); ?>
