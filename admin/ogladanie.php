<?php include("naglowek_okno.php");?>
<?php include("sprawdz_log.php"); ?> 
<body style="background-color:#DDDDDD;">
<div style="text-align: center;">

<?php 
///��czenie z baz� danych///
include ('param.php'); //parametry polaczenia z baz�
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
if(isset($_GET['id']))$id_film = $_GET['id']; 

//DECYZJA PODJETA
//nie widziany
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>Film nie zosta� dodany do obejrzanych.<br><br>
Mo�esz zamkna� okno</div>");
}

//DECYZJA PODJETA
//widziany
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{
//dodanie do ogladanych
$sql=("INSERT INTO `Ogladanie` (`ID`, `ID_OSOBA`, `ID_FILM`, `DATA`) 
       VALUES (NULL, ".$_SESSION['id_osoba'].", ".$id_film.", NOW());
	  ");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania


echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\" >
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"NIE\" border=0></a>
<br />Film zosta� dodany do obejrzanych!<br /><br />
Mo�esz zamkn�� okno</div>");

}



else
{
//DECYZJA NIEPODJETA

//kto
$sql=("SELECT `osoby`.`IMIE`, `osoby`.`NAZWISKO`
	   FROM `osoby` WHERE `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$kto=mysql_fetch_array($wynik, MYSQL_NUM);	   

echo("<div id=\"okno_pytanie\">".$kto[0]." ".$kto[1].
",<br>czy widzia�e� ten film?</div>
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
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("<br><b>".$wiersz[0]."</b><br> re�. ".$wiersz[2]." ".$wiersz[3]."<br>".$wiersz[4].
", ".$wiersz[1]."<br></div>");

//odpowiedz na pytanie
echo("<BR><div id=\"okno_pytanie\">
<a href=\"ogladanie.php?id=".$id_film."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");


}
//koniec polaczenia
mysql_close($connect);
//////////////////

?>

</div>
<?php include("stopka_okno.php"); ?>


