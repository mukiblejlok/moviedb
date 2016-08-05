<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<?php
$litera="A";                       //pierwsza litera
if(isset($_GET['litera']))$litera = $_GET['litera'];
?>

<div id="lista_filmow_top">Lista Re¿yserów</div>

<div id="lista_filmow_litery">
<?php

//literki linki
$alfabet = array("A","B","C","Æ","D","E",
"F","G","H","I","J","K","L","£","M","N",
"O","Ó","P","Q","R","S","¦","T","U","V",
"W","X","Y","Z","¬","¯");
foreach($alfabet AS $lit) {
   if($litera==$lit) echo ("<span class=\"aktywny\"> ".$lit." </span>");
   else echo ("<a href=\"".$PHP_SELF."?litera=".$lit."\" class=\"down\"> ".$lit."</a>");
   }
?>
</div>

<?php
//WYPISANIE FILMÓW
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

$sql=("SELECT `Rezyserzy`.`ID_REZ`
       FROM `Rezyserzy`
	   WHERE `Rezyserzy`.`NAZWISKO`  LIKE \"".$litera."%\" 
       ORDER BY `Rezyserzy`.`NAZWISKO`");
$wynik=mysql_query($sql) or die(mysql_error());
$ilosc_wierszy=mysql_num_rows($wynik);

while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))
{
 wypisz_rezysera($wiersz[0]);
}
//liczba wierszy
echo("<div id=\"lista_filmow_stopka\">znaleziono ".$ilosc_wierszy);
if($ilosc_wierszy==1)echo(" re¿ysera");
else echo(" re¿yserów");
echo(" na litere <strong>".$litera."</strong></div>");
/////////////////
mysql_close($polaczenie);
/////////////////
?>


<?php include('stopka.php');?>

