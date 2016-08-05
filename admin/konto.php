<?php include("naglowek.php");?>
<?php include("sprawdz_log.php"); ?>
<?php include("naglowek2.php");?>
<div style="width:400px;">
<?php 
//male podmenu
if(!isset($_GET['co']) || $_GET['co']==1)
	echo("<strong>Wygl±d strony</strong> | ");
else
	echo ("<a href=\"konto.php?co=1\" class=\"link\">Wygl±d strony</a> | ");
if($_GET['co']==2)
	echo("<strong>Edycja konta</strong> | ");
else
	echo ("<a href=\"konto.php?co=2\" class=\"link\">Edycja konta</a> | ");
if(!($_SESSION['id_osoba']==1))
{
	if($_GET['co']==3)
		echo("<strong>Moje wypo¿yczenia</strong>");
	else
		echo ("<a href=\"konto.php?co=3\" class=\"link\">Moje wypo¿yczenia</a>");
}
////////
?>

<?php
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS);
mysql_select_db($DB);
/////////////////////////
?>

<?php
switch($_GET['co'])
{
case 1:
include("konto_wyg.php");
break;

case 2:
include("konto_ed.php");
break;

case 3:
include("konto_wyp.php");
break;

default:
include("konto_wyg.php");

}


?>
</div>
<?php include ('stopka.php'); ?>
