<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>



<div style="width:400px;" id="filip">



<?php
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

//wypisanie newsów
$sql=("SELECT `ID`
	   FROM `Newsy`
	   ORDER BY `DATA` DESC ");
$wynik=mysql_query($sql) or die(mysql_error());
$ilosc_wierszy=mysql_num_rows($wynik);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_newsa($wiersz[0]);
}	   

?>
</div>
<?php include('stopka.php');?>