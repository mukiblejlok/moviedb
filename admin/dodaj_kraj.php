<?php include("naglowek_okno.php");?>
<?php include ("sprawdz_log.php"); ?>  

<?php
$o_kraj="Nazwa kraju:";
?>

<?php
//polaczenie w celu wys³ania wpisu do bazy
include ('param.php'); //parametry polaczenia z baz±
$connect=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
 
if (!empty($_POST['kraj'])){ 
$nazwa_kraj = $_POST['kraj'];
//zapytanie sprawdzaj±ce czy ju¿ jest taki rezyser w bazie
$sql = ("SELECT *
	     FROM `Kraje` 
         WHERE `NAZWA`=\"".$nazwa_kraj."\";
		  ");
$rezultat=mysql_query($sql);
$ilosc_wierszy=mysql_num_rows($rezultat);

//je¿eli nie ma takiego rekordu to go dodaj
if($ilosc_wierszy==0)
{
$sql = ("INSERT INTO `Kraje` (`ID_KRAJ`, `NAZWA`) 
	     VALUES (NULL, \"".$nazwa_kraj."\");");

$rezultat = mysql_query($sql);
echo("<div class=\"info\">Dodano kraj do bazy</div>");

unset($_POST['kraj']);
}

else echo("<div class=\"alert\">Taki kraj jest ju¿ w bazie!</div>") ;

}
//////////

echo("
<form action=\"dodaj_kraj.php?action=dod_kraj\" 
method=\"post\" onsubmit=\"if (sprawdz(this)) return true; return false\">


<table>
<tr>
<td class=\"d_opis\">".$o_kraj."</td>
<td class=\"d_okno2\">
<input name=\"kraj\" type=\"text\" size=\"30\" maxlength=\"40\" class=\"d_okno\">
</td></tr>


<tr>
<td class=\"d_opis\" colspan=\"2\">
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Dodaj\" />&nbsp;
<input type=\"reset\" class=\"przycisk\" value=\"Reset\" /></td></tr>
</table></form>
");

if($_GET['skad']=="film") echo("<a href=\"dodaj_film.php\" class=\"link\">...wróæ do dodawania filmu</a>");
if($_GET['skad']=="rez") echo("<a href=\"dodaj_rezysera.php?skad=film\" class=\"link\">...wróæ do dodawania re¿ysera</a>");



?>
<!---- sprawdzanie formularza ----> 
<script type="text/javascript">
// <![CDATA[
function sprawdz(formularz)
{
	for (i = 0; i < formularz.length; i++)
	{
		var pole = formularz.elements[i];
		if ((pole.type == "text" || pole.type == "password" || pole.type == "textarea") && pole.value == "")
		{
			alert("Proszê wype³niæ wszystkie pola!");
			return false;
		}
	}
	return true;
}
// ]]>
</script>
<?php include ('stopka_okno.php'); ?>