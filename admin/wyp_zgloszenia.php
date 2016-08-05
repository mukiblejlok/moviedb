<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>    
<?php include("naglowek2.php");?>


<?php
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
//wypisanie zgloszen wypozyczenia

$sql=("SELECT `Filmy`.`ID_FILM` 
	FROM `Filmy` , `Rezyserzy`, `osoby`, `Nosniki`, `Kraje`, `Pozyczki`
	WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
	AND `Nosniki`.`ID_TYP` = `Filmy`.`ID_TYP_NOSNIKA`
	AND `Kraje`.`ID_KRAJ` = `Filmy`.`ID_KRAJ`
	AND `Pozyczki`.`ID_OSOBA` = `osoby`.`ID_OSOBA`
	AND `Pozyczki`.`ID_FILM` = `Filmy`.`ID_FILM`
	ORDER BY `Pozyczki`.`DATA` DESC, `Filmy`.`TYTUL`
");

$rezultat = mysql_query($sql);
$ilosc_wierszy=mysql_num_rows($rezultat);
if($ilosc_wierszy==0) echo("<div id=\"lista_filmow_top\">Brak chêtnych na twoje filmy</div>");
else
{
	echo("<div id=\"lista_filmow_top\">Lista filmów, na które s± chêtni</div>");
    while($wynik = mysql_fetch_array($rezultat, MYSQL_NUM)) wypisz_film($wynik[0]);
	echo("<div id=\"lista_filmow_stopka\">³±czna liczba zg³oszeñ :".$ilosc_wierszy." </div>");
}


//koniec 
mysql_close($polaczenie);
?>

<?php include ('stopka.php'); ?>
