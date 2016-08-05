<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php");?>    
<?php include("naglowek2.php");?>


<?php
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////


//wypisanie wypozyczonych filmow
$sql=("SELECT `Filmy`.`ID_FILM`	 
FROM `Filmy` 
WHERE `Filmy`.`ID_OSOBA` !=1 
ORDER BY `Filmy`.`DATA_MOD` DESC
;");
$rezultat = mysql_query($sql) or die(mysql_error());
$ilosc_wierszy=mysql_num_rows($rezultat);
if($ilosc_wierszy==0) echo("<div id=\"lista_filmow_top\">Brak wypo¿yczonych filmow</div>");
else
echo("<div id=\"lista_filmow_top\">Wypo¿yczone filmy</div>");
{
while($wynik = mysql_fetch_array($rezultat, MYSQL_NUM))
{
	wypisz_film($wynik[0]);
}
echo("<div id=\"lista_filmow_stopka\">wypo¿yczonych jest ".$ilosc_wierszy." filmów</div>");
}//koniec else

//////////

mysql_close($polaczenie);
?>



<?php include ('stopka.php'); ?>


