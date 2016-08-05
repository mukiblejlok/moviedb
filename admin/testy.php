<?php include("naglowek.php");?>
<?php include("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<div style="width:400px;" id="text">
jQuery do cholery !
<?php
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

$sql=("SELECT COUNT(*) FROM `Oceny`");
$wynik=mysql_query($sql);  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania
echo $wiersz[0];


?>


</div>
<?php include("stopka.php");?>

