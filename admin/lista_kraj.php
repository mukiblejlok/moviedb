<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<?php
$litera="A";                       //pierwsza litera
if(isset($_GET['litera']))$litera = $_GET['litera'];
?>

<div id="lista_filmow_top">Lista krajów</div>

<?php
//WYPISANIE Krajow
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

$sql=("SELECT `Kraje`.`ID_KRAJ`
       FROM `Kraje`
	   ORDER BY `Kraje`.`NAZWA`");
$wynik=mysql_query($sql) or die(mysql_error());
$ilosc_wierszy=mysql_num_rows($wynik);

while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))
{
 wypisz_kraj($wiersz[0]);
}
//liczba wierszy
echo("<div id=\"lista_filmow_stopka\">znaleziono ".$ilosc_wierszy);
if($ilosc_wierszy==1)echo(" kraj");
else echo(" krajów");
echo("</div>");
/////////////////
mysql_close($polaczenie);
/////////////////
?>


<?php include('stopka.php');?>

