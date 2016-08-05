<?php include("naglowek_okno.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////




///////////////////////////////////////////////////////////////////////
//EDYCJA FILMU
if(isset($_GET['co']) && $_GET['co']=="film")
{

$o_tytul="Tytu³:";
$o_rezyser="Re¿yser:";
$o_rok="Rok produkcji:";
$o_kraj="Kraj produkcji:";
$o_inosnik="Ilosc nosników:";
$o_tnosnik="Typ nosnika:";
$o_plyta="Nr plyty";
?>


<?php 
if ($_GET['action'] == "edyt_film")
{
echo("
  <script language=\"JavaScript\" type=\"text/javascript\">                 
    <!--                                                                  
    setTimeout(window.location.replace(\"".$PHP_SELF."?id=".$_GET['id']."&action=napis&co=film\"),10000);    //-->                                                                 
    </script> 
 ");
}
elseif($_GET['action'] == "napis")
{
echo ("<div class=\"info\">Edytowano wpis w bazie</div>");
}

 ?>

<?php
//pobranie dotychczasowych wartosci z bazy

//Pobranie danych z $_GET jesli ustawione 
if(isset($_GET['id']))$id_film = $_GET['id']; 

$sql=("SELECT `Filmy`.`TYTUL` , 
			  `Filmy`.`ROK` , `Filmy`.`ILOSC_NOSNIK` , `Nosniki`.`NAZWA` , 
			  `Rezyserzy`.`IMIE`, `Rezyserzy`.`NAZWISKO`, `Kraje`.`NAZWA`,
			  `Filmy`.`NR_PLYTY`,`Filmy`.`ID_TYP_NOSNIKA`
FROM `Filmy` , `Rezyserzy`, `osoby`, `Kraje`, `Nosniki`
WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
AND `osoby`.`ID_OSOBA` = `Filmy`.`ID_OSOBA`
AND `Kraje`.`ID_KRAJ` = `Filmy`.`ID_KRAJ`
AND `Nosniki`.`ID_TYP` = `Filmy`.`ID_TYP_NOSNIKA`
AND `Filmy`.`ID_FILM`=".$id_film."
LIMIT 1;
");

$wynik=mysql_query($sql);  //wykonanie zapytania

$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

$stary_tytul=$wiersz[0];
$stary_rez_imie=$wiersz[4];
$stary_rez_nazwisko=$wiersz[5];
$stary_rok=$wiersz[1];
$stary_ilosc=$wiersz[2];
$stary_typ=$wiersz[3];
$stary_kraj=$wiersz[6];
$stary_nr_plyty=$wiersz[7];
$stary_typ_id=$wiersz[8];


/////tu sa operacje odpowiedziale za sam± edycje danych w bazie

 
if (isset($_POST['nowy_tytul']) && trim($_POST['nowy_tytul']) != NULL)
 $nowy_tytul = $_POST['nowy_tytul'];
if (isset($_POST['nowy_rezyser']) && trim($_POST['nowy_rezyser']) != NULL)
 $nowy_id_rez = $_POST['nowy_rezyser'];
if (isset($_POST['nowy_rok']) && trim($_POST['nowy_rok']) != NULL)
 $nowy_rok = $_POST['nowy_rok'];
if (isset($_POST['nowy_ilosc']) && trim($_POST['nowy_ilosc']) != NULL)
 $nowy_ilosc = $_POST['nowy_ilosc'];
if (isset($_POST['nowy_typ']) && trim($_POST['nowy_typ']) != NULL
) $nowy_id_typ = $_POST['nowy_typ'];
if (isset($_POST['nowy_kraj']) && trim($_POST['nowy_kraj']) != NULL)
 $nowy_id_kraj = $_POST['nowy_kraj'];
if (isset($_POST['nowy_nr_plyty']) && trim($_POST['nowy_nr_plyty']) != NULL)
 $nowy_nr_plyty = $_POST['nowy_nr_plyty'];

//istota calej edycji //////////////////
//zapytanie edytujace film w bazie
$sql = ("UPDATE `Filmy` SET 
`TYTUL`=\"".$nowy_tytul."\" , 
`ID_REZ`=".$nowy_id_rez.", 
`ROK`=".$nowy_rok.", 
`ILOSC_NOSNIK`=".$nowy_ilosc.", 
`ID_TYP_NOSNIKA`=".$nowy_id_typ.", 
`ID_OSOBA`=1, 
`ID_KRAJ`=".$nowy_id_kraj.",
`NR_PLYTY`=".$nowy_nr_plyty.", 
`DATA_MOD`=NOW()
WHERE `ID_FILM`=".$id_film."
;");
$rezultat = mysql_query($sql);
//////////////////////////////////////////
?>


<?php
//poczatek formularza
echo("
<form action=\"edytuj.php?id=".$id_film."&action=edyt_film&co=film\" 
method=\"post\" onsubmit=\"if (sprawdz(this)) return true; return false\">
<br />
<table>
<tr>
<td class=\"d_opis\">".$o_tytul."</td>
<td class=\"d_okno2\">
<input name=\"nowy_tytul\" 
value=\"".$stary_tytul."\"
type=\"text\" size=\"47\" maxlength=\"75\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_rezyser."</td>
<td class=\"d_okno2\">
<select name=\"nowy_rezyser\" class=\"d_okno\">
");

///////////////////////////////////////////////////////////
//zapytanie o rezyserow
$sql=("SELECT `ID_REZ`, `NAZWISKO`, `IMIE` 
       FROM `Rezyserzy`
	   ORDER BY `NAZWISKO`");
//////////////////////
$wynik=mysql_query($sql); 
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))  
{
////wybranie jako domy¶lny re¿ysera ktorego id zgadza sie z id_rez filmu
if(($wiersz[1]==$stary_rez_nazwisko) && ($wiersz[2]==$stary_rez_imie))
echo("<option value=\"".$wiersz[0]."\" selected=\"selected\">".$wiersz[1].", "
.$wiersz[2]."</option>");
else 
echo("<option value=\"".$wiersz[0]."\" >".$wiersz[1].", ".$wiersz[2]."</option>");
/////////////////////////////////////////////////
}

echo("
</select>
</td></tr>

<tr>
<td class=\"d_opis\">".$o_rok."</td>
<td class=\"d_okno2\">
<input name=\"nowy_rok\"
value=\"".$stary_rok."\"
 type=\"text\" size=\"4\" maxlength=\"4\" class=\"d_okno\">
</td></tr>


<tr>
<td class=\"d_opis\">".$o_kraj."</td>
<td class=\"d_okno2\">
<select name=\"nowy_kraj\" class=\"d_okno\">
");

///////////////////////////////////////////////////////////
//zapytanie o kraj
$sql=("SELECT `ID_KRAJ`, `NAZWA` 
       FROM `Kraje`
	   ORDER BY `NAZWA`");
//////////////////////

$wynik=mysql_query($sql); 

while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))  
{
////wybranie jako domy¶lny kraju ktorego id zgadza sie z id_kraju filmu
if($wiersz[1]==$stary_kraj)
echo("<option value=\"".$wiersz[0]."\" selected=\"selected\">".$wiersz[1]."</option>");
else 
echo("<option value=\"".$wiersz[0]."\">".$wiersz[1]."</option>");
/////////////////////////////////////////////////
}
///////////////////////////////////////////////////////////
echo("
</select>
</td></tr>

<tr>
<td class=\"d_opis\">".$o_inosnik."</td>
<td class=\"d_okno2\">
<input name=\"nowy_ilosc\" 
value=\"".$stary_ilosc."\"
type=\"text\" size=\"3\" maxlength=\"1\" class=\"d_okno\">
</td></tr>
<tr>
<td class=\"d_opis\">".$o_tnosnik."</td>
<td class=\"d_okno2\">
<select name=\"nowy_typ\" class=\"d_okno\">");

///////////////////////////////////////////////////////////
//zapytanie o nosniki
$sql=("SELECT `ID_TYP`, `NAZWA` 
       FROM `Nosniki`
	   ORDER BY `NAZWA`");
//////////////////////
$wynik=mysql_query($sql); 
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))  
{
if($wiersz[1]==$stary_typ)
echo("<option value=\"".$wiersz[0]."\" selected=\"selected\">".$wiersz[1]."</option>");
else 
echo("<option value=\"".$wiersz[0]."\">".$wiersz[1]."</option>");
}

echo("		
</select>
</td></tr>");

//wyswietlenie edycji nr plyty jezeli mamy do czynienia z CD na DVD
if($stary_typ_id==3)
{
echo("
<tr>
<td class=\"d_opis\">".$o_plyta."</td>
<td class=\"d_okno2\">
<input name=\"nowy_nr_plyty\"
value=\"".$stary_nr_plyty."\"
type=\"text\" size=\"3\" maxlength=\"3\" class=\"d_okno\">
</td></tr>");
}
else echo("<input name=\"nowy_nr_plyty\" value=0 type=\"hidden\" >");

//przyciski
echo("
<tr></tr><tr>
<td class=\"d_opis\" style=\"background:none;\" colspan=2>
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Zmieñ\">
<input type=\"reset\" class=\"przycisk\" value=\"Reset\"></td>
</tr>
</table>
</form>
");


}
///////////////////////////////////////////
//KONIEC EDYCJI FILMU
?>



<?php 
///////////////////////////////////////////////////////////////////////////////
//EDYCJA RE¯YSERA
if(isset($_GET['co']) && $_GET['co']=="rez")
{

$o_imie="Imie:";
$o_nazwisko="Nazwisko:";
$o_kraj="Kraj:";
?>


<?php 
if ($_GET['action'] == "edyt_rez")
{
echo("
  <script language=\"JavaScript\" type=\"text/javascript\">                 
    <!--                                                                  
    setTimeout(window.location.replace(\"".$PHP_SELF."?id=".$_GET['id']."&action=napis&co=rez\"),10000);    //-->                                                                 
    </script> 
 ");
}
elseif($_GET['action'] == "napis")
{
echo ("<div class=\"info\">Edytowano wpis w bazie</div>");
}

 ?>

<?php
//pobranie dotychczasowych wartosci z bazy
//Pobranie danych z $_GET jesli ustawione 
if(isset($_GET['id']))$id_rez = $_GET['id']; 

$sql=("SELECT `Rezyserzy`.`ID_REZ`, 
			  `Rezyserzy`.`IMIE`, `Rezyserzy`.`NAZWISKO`, `Kraje`.`NAZWA`
FROM `Rezyserzy`, `Kraje` 
WHERE  `Kraje`.`ID_KRAJ` = `Rezyserzy`.`ID_KRAJ`
AND `Rezyserzy`.`ID_REZ`=".$id_rez."
LIMIT 1;
");

$wynik=mysql_query($sql);  //wykonanie zapytania

$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

$stary_imie=$wiersz[1];
$stary_nazwisko=$wiersz[2];
$stary_kraj=$wiersz[3];


//echo($stary_imie." ".$stary_nazwisko." - ".$stary_kraj);


if (!empty($_POST['nowy_imie']))$imie = $_POST['nowy_imie'];
if (!empty($_POST['nowy_nazwisko']))$nazwisko = $_POST['nowy_nazwisko'];
if (!empty($_POST['nowy_kraj']))$kraj = $_POST['nowy_kraj'];

//istota calej edycji //////////////////
//zapytanie dodajace film do bazy
$sql = ("UPDATE `Rezyserzy` SET 
`IMIE`=\"".$imie."\" , 
`NAZWISKO`=\"".$nazwisko."\", 
`ID_KRAJ`=".$kraj."

WHERE `ID_REZ`=".$id_rez.";");

$rezultat = mysql_query($sql);
//////////////////////////////////////////
?>


<?php
//poczatek formularza

echo("
<form action=\"".$PHP_SELF."?id=".$id_rez."&action=edyt_rez&co=rez\" 
method=\"post\" onsubmit=\"if (sprawdz(this)) return true; return false\">

<br />
<table>
<tr>
<td class=\"d_opis\">".$o_imie."</td>
<td class=\"d_okno2\">
<input name=\"nowy_imie\" 
value=\"".$stary_imie."\"
type=\"text\" size=\"47\" maxlength=\"75\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_nazwisko."</td>
<td class=\"d_okno2\">
<input name=\"nowy_nazwisko\" 
value=\"".$stary_nazwisko."\"
type=\"text\" size=\"47\" maxlength=\"75\" class=\"d_okno\">
</td></tr>


<tr>
<td class=\"d_opis\">".$o_kraj."</td>
<td class=\"d_okno2\">
<select name=\"nowy_kraj\" class=\"d_okno\">
");

//zapytanie o kraj
$sql=("SELECT `ID_KRAJ`, `NAZWA` 
       FROM `Kraje`
	   ORDER BY `NAZWA`");
//////////////////////

$wynik=mysql_query($sql); 

while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM))  
{
////wybranie jako domy¶lny kraju ktorego id zgadza sie z id_kraju filmu
if($wiersz[1]==$stary_kraj)
echo("<option value=\"".$wiersz[0]."\" selected=\"selected\">".$wiersz[1]."</option>");
else 
echo("<option value=\"".$wiersz[0]."\">".$wiersz[1]."</option>");
/////////////////////////////////////////////////
}

///////////////////////////////////////////////////////////
echo("
</select>
</td></tr>
<tr>
<td class=\"d_opis\" colspan=\"2\">
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Zmieñ\">&nbsp;
<input type=\"reset\" class=\"przycisk\" value=\"Reset\"></td></tr>
</table>
</form>
");

}
//////////////////////////////////////
//KONIEC EDYCJI REZYSERA
?>



<?php
////////////////////////////////////////////////////////////
//EDYCJA KRAJU
if(isset($_GET['co']) && $_GET['co']=="kraj")
{
$o_kraj="Nazwa kraju:";

if ($_GET['action'] == "edyt_kraj")
{
echo("
  <script language=\"JavaScript\" type=\"text/javascript\">                 
    <!--                                                                  
    setTimeout(window.location.replace(\"".$PHP_SELF."?id=".$_GET['id']."&action=napis&co=kraj\"),10000);    //-->                                                                 
    </script> 
 ");
}
elseif($_GET['action'] == "napis")
{
echo ("<div class=\"info\">Edytowano wpis w bazie</div>");
}


//Pobranie danych z $_GET jesli ustawione 
if(isset($_GET['id']))$id_kraj = $_GET['id']; 

$sql=("SELECT `Kraje`.`ID_Kraj`, 
			  `Kraje`.`NAZWA`
FROM  `Kraje` 
WHERE  `Kraje`.`ID_KRAJ`=".$id_kraj."
LIMIT 1;
");

$wynik=mysql_query($sql);  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

$stary_kraj=$wiersz[1];


if (!empty($_POST['nowy_kraj'])) 
{
$kraj = $_POST['nowy_kraj'];
//istota calej edycji //////////////////
//zapytanie zmieniajace wpis w bazie

$sql = ("UPDATE `Kraje` SET 
        `NAZWA`=\"".$_POST['nowy_kraj']."\"
WHERE `ID_KRAJ`=".$id_kraj."
LIMIT 1;");

$rezultat = mysql_query($sql);
//////////////////////////////////////////
}


//poczatek formularza

echo("
<form action=\"".$PHP_SELF."?id=".$id_kraj."&action=edyt_kraj&co=kraj\" 
method=\"post\" onsubmit=\"if (sprawdz(this)) return true; return false\">

<br />
<table>
<tr>
<td class=\"d_opis\">".$o_kraj."</td>
<td class=\"d_okno2\">
<input name=\"nowy_kraj\" 
value=\"".$stary_kraj."\"
type=\"text\" size=\"47\" maxlength=\"20\" class=\"d_okno\" />
</td></tr>

<tr>
<td class=\"d_opis\" colspan=\"2\">
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Zmieñ\">&nbsp;
<input type=\"reset\" class=\"przycisk\" value=\"Reset\"></td></tr>
</table>
</form>
");


}
//////////////////////////////////////
//KONIEC EDYCJI KRAJU
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

<?php 
//koniec polaczenia
mysql_close($connect);
//////////////////
include("stopka_okno.php")?>
