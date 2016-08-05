<?php include("naglowek.php");?>
<?php include("sprawdz_log.php"); ?>
<?php include("naglowek2.php");?>

<?php
///Â£Â±czenie z bazÂ± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS);
mysql_select_db($DB);
/////////////////////////


echo("<div style=\"width:400px;\">
	Witaj na movieDATAbase !<br /><br />
	");

//wypisanie 3 najnowszych newsów
echo("<br /><br />Najnowsze informacje:  
	<br /><br />
	");
$sql=("SELECT `ID` FROM `Newsy` ORDER BY `DATA` DESC LIMIT 0,3");
$wynik=mysql_query($sql);
while ($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))
{
	wypisz_newsa($wiersz[0]);
}

echo "<br /><br /><a href=\"news.php\" title=\"Kliknij by zobaczyæ wszystkie newsy\" class=\"link\">...wszystkie newsy</a>"
?>

</div>
<?php include ('stopka.php'); ?>