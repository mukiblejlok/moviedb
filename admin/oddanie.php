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
//ODDAWANIE FILMU

if(isset($_GET['id'])) $id_film = $_GET['id']; 

////DECYZJA PODJETA
////nie oddany
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Film nie zosta³ oddany.<br />
Mo¿esz zamknaæ okno</div>");
}

//DECYZJA PODJETA
//oddany
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

	if(isset($_GET['plyta']) && $_GET['plyta']) 
 	{
 	$sql=("UPDATE `Filmy` SET `ID_OSOBA` =1          
		  WHERE `Filmy`.`NR_PLYTY`=".$_GET['plyta']." 
		  ");
    $wynik=mysql_query($sql) or die(mysql_error());
	}
	
	else
	{
	$sql=("UPDATE `Filmy` SET `ID_OSOBA` =1         
		  WHERE `Filmy`.`ID_FILM`=".$id_film." 
		  ");
    $wynik=mysql_query($sql) or die(mysql_error());
    }
	
echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Film (P³yta) oddany.<br />
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
//kto
$sql=("SELECT `IMIE`, `NAZWISKO` FROM `osoby` WHERE `ID_OSOBA`=".$_GET['kto']);
$wynik=mysql_query($sql) or die(mysql_error());
$osoba = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania


echo("<div id=\"okno_pytanie\">Czy napewno ta osoba<br /><b>".$osoba[0]." ".$osoba[1]."</b><br />
odda³a ci ten film?</div>
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
		echo "<br />wiêc one te¿ zostan± uznane za oddane.</div>";
		$cd_na_dvd=1;
		}
//odpowiedz na pytanie
echo("<Br><BR><div id=\"okno_film\">");

if($cd_na_dvd) echo("<a href=\"oddanie.php?id=".$id_film."&napewno=tak&kto=".$_GET['kto']."&plyta=".$wiersz[5]."\" class=\"detale_link\">");
else echo("<a href=\"oddanie.php?id=".$id_film."&napewno=tak&kto=".$_GET['kto']."\" class=\"detale_link\">");



echo("
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}


/////////////////////////////////
//KONIEC ODDAWANIA FILMU

?>





<?php include ('stopka_okno.php'); ?>
