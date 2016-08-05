<?php include("naglowek_okno.php");?>
<?php include ("sprawdz_log.php"); ?>  


<?php
$o_imie="Imiê:";
$o_nazwisko="Nazwisko:";
$o_login="Login:";
$o_haslo="Haslo:";
$o_email="Email:";
$o_gg="Numer gg:";
$o_edycja="Mo¿liwo¶æ edycji:";
$o_kasowanie="Mo¿liwo¶æ kasowania:";


?>

<?php
//polaczenie w celu wys³ania wpisu do bazy
include ('param.php'); //parametry polaczenia z baz±
$connect=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

if(!empty($_POST['imie']) && !empty($_POST['nazwisko']) 
&& !empty($_POST['login']) && !empty($_POST['haslo']))
{ //je¶li powy¿sze 4 s± wpisane to mo¿na dodaæ osobe do bazy
	
	//sprawdzenie czy ju¿ jest ktos o takim loginie
	$sql=("SELECT * 
		   FROM `osoby` 
		   WHERE `LOGIN`=\"".$_POST['login']."\" 
		   OR `EMAIL`=\"".$_POST['email']."\"; ");
	$wynik=mysql_query($sql) or die(mysql_error());
    $ilosc_wierszy=mysql_num_rows($wynik);
	
	////////
if($ilosc_wierszy==0)//nie znaleziono takiego loginu -> mozna dodac osobe
    {
	
	//echo ("tu jestem<br>");

//stworzenie zapytania
$sql=("INSERT INTO `osoby` (
      `ID_OSOBA` , `IMIE` , `NAZWISKO` , 
      `NR_GG` , `EMAIL` , `LOGIN` , `PASS`
	  ");
	  
if(isset($_POST['upr_edycja'])) $sql.=(" , `UPR_EDYCJA`");
if(isset($_POST['upr_kasowanie'])) $sql.=(" , `UPR_KASOWANIE`");

$sql.=("
) VALUES (
NULL , \"".$_POST['imie']."\", 
       \"".$_POST['nazwisko']."\", 
	   ".$_POST['gg'].", 
	   \"".$_POST['email']."\", 
	   \"".$_POST['login']."\", 
	   \"".sha1($_POST['haslo'])."\"	   
	   ");
if(isset($_POST['upr_edycja'])) $sql.= (" , ".$_POST['upr_edycja']);
if(isset($_POST['upr_kasowanie'])) $sql.= (" , ".$_POST['upr_kasowanie']);
$sql.=(" ) ");

//echo $sql;
$wynik=mysql_query($sql) or die(mysql_error()); // dodanie osoby do bazy
echo("<div class=\"info\">Dodano osobê do bazy</div>");

unset($_POST['imie']);
unset($_POST['nazwisko']);
unset($_POST['login']);
unset($_POST['haslo']);
		}
else echo("<div class=\"alert\">Taki login lub email jest juz w bazie</div>");

}//koniec dodawania osoby do bazy 

else
{//nie wypelnione odpowiednie pola

if(!empty($_POST['login']))echo("<div class=\"alert\">wype³nij wszystkie wymagane pola</div>");

}//koniec else'a

echo("
<form action=\"dodaj_osobe.php?action=dod_osobe\" name=\"dodaj_osobe\" method=\"post\"
onsubmit=\"if (sprawdz(this)) return true; return false\">

<br />
<table>
<tr>
<td class=\"d_opis\">".$o_imie."</td>
<td class=\"d_okno2\">
<input name=\"imie\" type=\"text\" size=\"20\" maxlength=\"20\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_nazwisko."</td>
<td class=\"d_okno2\">
<input name=\"nazwisko\" type=\"text\" size=\"30\" maxlength=\"30\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_login."</td>
<td class=\"d_okno2\">
<input name=\"login\" type=\"text\" size=\"20\" maxlength=\"20\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_haslo."</td>
<td class=\"d_okno2\">
<input name=\"haslo\" type=\"text\" size=\"20\" maxlength=\"20\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_gg."</td>
<td class=\"d_okno2\">
<input name=\"gg\" type=\"text\" size=\"10\" maxlength=\"10\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_email."</td>
<td class=\"d_okno2\">
<input name=\"email\" type=\"text\" size=\"40\" maxlength=\"40\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_edycja."</td>
<td class=\"d_okno2\">
<input name=\"upr_edycja\" type=\"checkbox\" value=1 class=\"d_okno\">
</td></tr>


<tr>
<td class=\"d_opis\">".$o_kasowanie."</td>
<td class=\"d_okno2\">
<input name=\"upr_kasowanie\" type=\"checkbox\" value=1 class=\"d_okno\">
</td></tr>


<tr>
<td class=\"d_opis\" colspan=\"2\">
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Dodaj\">&nbsp;
<input type=\"reset\" class=\"przycisk\" value=\"Reset\"></td></tr>
</table> 
</form>
");

?>

<!---- sprawdzanie formularza ----> 
<script type="text/javascript">
// <![CDATA[
function sprawdz(formularz)
{
	for (i = 0; i < formularz.length; i++)
	{
		var pole = formularz.elements[i];
		if ((pole.type == "text") && pole.value == "")
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


