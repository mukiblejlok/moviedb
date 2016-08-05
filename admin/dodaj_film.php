<?php include("naglowek_okno.php");?>
<?php include ("sprawdz_log.php"); ?>  

<?php
$o_tytul="Tytu³:";
$o_rezyser="Re¿yser:";
$o_rok="Rok produkcji:";
$o_kraj="Kraj produkcji:";
$o_inosnik="Ilosc nosników:";
$o_tnosnik="Typ nosnika:";
$ilosc_wierszy=100;
?>


<?php

//polaczenie w celu wys³ania wpisu do bazy
include ('param.php'); //parametry polaczenia z baz±
$connect=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
 
if (isset($_POST['tytul']) && trim($_POST['tytul']) != NULL) $tytul = $_POST['tytul'];
if (isset($_POST['rezyser']) && trim($_POST['rezyser']) != NULL) $id_rez = $_POST['rezyser'];
if (isset($_POST['rok']) && trim($_POST['rok']) != NULL) $rok = $_POST['rok'];
if (isset($_POST['ilosc']) && trim($_POST['ilosc']) != NULL) $ilosc = $_POST['ilosc'];
if (isset($_POST['typ']) && trim($_POST['typ']) != NULL) $typ = $_POST['typ'];
if (isset($_POST['id_kraj']) && trim($_POST['id_kraj']) != NULL) $id_kraj = $_POST['id_kraj'];

//ca³a procedura ponizej wykona sie tylko wtedy je¶li w $_POST jest choæ tytu³
//zapobiega to wyswietleniu sie napisu o dodaniu filmu na samym poczatku
 
if (!empty($_POST['tytul']))
{
//zapytanie sprawdzaj±ce czy ju¿ jest taki film w bazie
$sql = ("SELECT *
	     FROM `Filmy` 
         WHERE `TYTUL`=\"".$tytul."\"
		 AND `ID_REZ`= ".$id_rez."
		 AND `ROK`= ".$rok."
		 AND `ID_KRAJ`=".$id_kraj.";
		 ");
$rezultat=mysql_query($sql);
$ilosc_wierszy=mysql_num_rows($rezultat);

//je¿eli nie ma takiego rekordu to go dodaj
if($ilosc_wierszy==0)
{
//zapytanie dodajace film do bazy
$sql = ("INSERT INTO `Filmy` 
        (`TYTUL`, `ID_REZ`, `ROK`, `ILOSC_NOSNIK`, `ID_TYP_NOSNIKA`, `ID_OSOBA`, `ID_KRAJ`, `DATA_UTWORZENIA`, `DATA_MOD`, `DATA_ZAKUPU`)
VALUES (\"".$tytul."\", ".$id_rez.", ".$rok.", ".$ilosc.", ".$typ.", 1, ".$id_kraj.",NOW(), NOW(),");
if($typ==2) $sql.=("NOW()");
else $sql.=("NULL");

$sql.=(")");

$rezultat = mysql_query($sql) or die(mysql_error());

echo("<div class=\"info\">Dodano film do bazy</div>");

//pozbycie sie zmiennych pobranych z formularza
unset($_POST['tytul']);
unset($_POST['rezyser']);
unset($_POST['rok']);
unset($_POST['ilosc']);
unset($_POST['typ']);
unset($_POST['id_kraj']);
}

//je¿eli jest taki rekord w bazie to napisz to 
else
{
echo("<div class=\"alert\">Taki film ju¿ jest w bazie</div>");
}
}

echo("
<form action=\"dodaj_film.php\" 
method=\"post\" onsubmit=\"if (sprawdz(this)) return true; return false\">
<table>
<tr>
<td class=\"d_opis\">".$o_tytul."</td>
<td class=\"d_okno2\">
<input name=\"tytul\" type=\"text\" size=\"47\" maxlength=\"75\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_rezyser."</td>
<td class=\"d_okno2\">
<select name=\"rezyser\" class=\"d_okno\">
");

//zapytanie o rezyserow
$sql=("SELECT `ID_REZ`, `NAZWISKO`, `IMIE` 
       FROM `Rezyserzy`
	   ORDER BY `NAZWISKO`");
//////////////////////
$wynik=mysql_query($sql); 
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))  
{
echo("<option value=\"".$wiersz[0]."\">".$wiersz[1].", ".$wiersz[2]."</option>");
}
///////////////////////////////////////////////////////////

echo("
</select>
&nbsp;&nbsp;
<a href=\"dodaj_rezysera.php?skad=film\" class=\"link\" title=\"je¶li nie ma re¿ysera na liscie, to kliknij tu\">dodaj nowego</a></td>
</tr>

<tr>
<td class=\"d_opis\">".$o_rok."</td>
<td class=\"d_okno2\">
<input name=\"rok\" type=\"text\" size=\"4\" maxlength=\"4\" class=\"d_okno\">
</td></tr>
<tr>
<td class=\"d_opis\" width=\"200\">".$o_kraj."</td>
<td class=\"d_okno2\">
<select name=\"id_kraj\" class=\"d_okno\">
");

///////////////////////////////////////////////////////////
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
///////////////////////////////////////////////////////////

echo("
</select>
&nbsp;&nbsp;<a href=\"dodaj_kraj.php?skad=film\" class=\"link\" title=\"je¶li nie ma kraju na li¶cie, to kliknij tu\">dodaj nowy</a></td>
</tr>

<tr>
<td class=\"d_opis\">".$o_inosnik."</td>
<td class=\"d_okno2\">
<input name=\"ilosc\" type=\"text\" size=\"3\" maxlength=\"1\" class=\"d_okno\" />
</td></tr>
<tr>
<td class=\"d_opis\">".$o_tnosnik."</td>
<td class=\"d_okno2\">
<select name=\"typ\" class=\"d_okno\">
");

///////////////////////////////////////////////////////////
//zapytanie o nosniki
$sql=("SELECT `ID_TYP`, `NAZWA` 
       FROM `Nosniki`
	   ORDER BY `NAZWA`");
//////////////////////
$wynik=mysql_query($sql); 
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))  
{
echo("<option value=\"".$wiersz[0]."\">".$wiersz[1]."</option>");
}
////////////////////////////////////
echo("
</select>
</td></tr>
<tr>
<td class=\"d_opis\" colspan=\"2\">
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Dodaj\">&nbsp;
<input type=\"reset\" class=\"przycisk\" value=\"Reset\"></td></tr>

</table>
</form>
");

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
