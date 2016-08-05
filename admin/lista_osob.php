<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<div id="lista_filmow_top">Lista osob</div>

<?php
//WYPISANIE OSOB
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

//zapytanie
$sql=("SELECT `osoby`.`ID_OSOBA`             
FROM `osoby` 
ORDER BY `osoby`.`NAZWISKO`");

$wynik=mysql_query($sql); 
$ilosc_wierszy=mysql_num_rows($wynik);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_osobe($wiersz[0]);
}
//liczba wierszy
echo("<div id=\"lista_filmow_stopka\">znaleziono ".$ilosc_wierszy);
if($ilosc_wierszy==1)echo(" osobe");
else if($ilosc_wierszy==2 || $ilosc_wierszy==3 || $ilosc_wierszy==4) echo(" osoby");
else echo(" osób");
echo("</div>");

/////////////////
mysql_close($polaczenie);
/////////////////
?>


<?php include('stopka.php');?>

