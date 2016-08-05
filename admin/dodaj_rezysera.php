<?php include("naglowek_okno.php");?>
<?php include ("sprawdz_log.php"); ?>  

<?php
$o_imie="Imiê:";
$o_nazwisko="Nazwisko:";
$o_kraj="Kraj pochodzenia:";
$o_nkraj="Je¿eli nie ma kraju na li¶cie:";
$ilosc_wierszy=100;
?>


<?php
//polaczenie w celu wys³ania wpisu do bazy
include ('param.php'); //parametry polaczenia z baz±
$connect=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
 
if (isset($_POST['imie']) && trim($_POST['imie']) != NULL) $imie = $_POST['imie'];
if (isset($_POST['nazwisko']) && trim($_POST['nazwisko']) != NULL) 
$nazwisko = $_POST['nazwisko'];
if (isset($_POST['id_kraj']) && trim($_POST['id_kraj']) != NULL) $id_kraj = $_POST['id_kraj'];

//ca³a procedura ponizej wykona sie tylko wtedy je¶li w $_POST jest choæ tytu³
//zapobiega to wyswietleniu sie napisu o dodaniu filmu na samym poczatku
 
if (!empty($_POST['nazwisko']))
{
//zapytanie sprawdzaj±ce czy ju¿ jest taki rezyser w bazie
$sql = ("SELECT *
	     FROM `Rezyserzy` 
         WHERE `IMIE`=\"".$imie."\"
		 AND `NAZWISKO`= \"".$nazwisko."\"
		 AND `ID_KRAJ`=".$id_kraj.";
		 ");
$rezultat=mysql_query($sql);
$ilosc_wierszy=mysql_num_rows($rezultat);

//je¿eli nie ma takiego rekordu to go dodaj
if($ilosc_wierszy==0)
{
$sql = ("INSERT INTO `Rezyserzy` 
        (`IMIE`, `NAZWISKO`, `ID_KRAJ`)
VALUES (\"".$imie."\", \"".$nazwisko."\", ".$id_kraj.");");
$rezultat = mysql_query($sql);

echo("<div class=\"info\">Dodano re¿ysera do bazy</div>");

unset($_POST['imie']);
unset($_POST['nazwisko']);
unset($_POST['id_kraj']);
}
//je¿eli jest taki rekord w bazie to napisz to 

else echo("<div class=\"alert\">Taki re¿yser ju¿ jest w bazie</div>");

}
echo("
<form action=\"dodaj_rezysera.php\" 
method=\"post\" onsubmit=\"if (sprawdz(this)) return true; return false\">


<table>
<tr>
<td class=\"d_opis\">".$o_imie."</td>
<td class=\"d_okno2\">
<input name=\"imie\" type=\"text\" size=\"40\" maxlength=\"75\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_nazwisko."</td>
<td class=\"d_okno2\">
<input name=\"nazwisko\" type=\"text\" size=\"40\" maxlength=\"75\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\" width=\"200\">".$o_kraj."</td>
<td class=\"d_okno2\">
<select name=\"id_kraj\" class=\"d_okno\">
");

//zapytanie o kraje
$sql=("SELECT `ID_KRAJ`, `NAZWA` 
       FROM `Kraje`
	   ORDER BY `NAZWA`");
//////////////////////
$wynik=mysql_query($sql); 
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))  
{
echo("<option value=\"".$wiersz[0]."\">".$wiersz[1]."</option>");
}
////////////////////////////
echo("
</select>

<a href=\"dodaj_kraj.php?skad=rez\" class=\"link\" title=\"je¶li nie ma kraju na liscie, to kliknij tu\">dodaj nowy</a></td>
</tr>

<tr>
<td class=\"d_opis\" colspan=\"2\">
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Dodaj\">&nbsp;
<input type=\"reset\" class=\"przycisk\" value=\"Reset\"></td></tr>
</table>
</form>
");

if($_GET['skad']=="film") echo("<a href=\"dodaj_film.php\" class=\"link\">...wróæ do dodawania filmu</a>");

//koniec polaczenia
mysql_close($connect);
//////////////////

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
