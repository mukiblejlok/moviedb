<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<?php
$o_tytul="Tytu³:";
$o_rezyser="Re¿yser:";
$o_rok="Rok produkcji (RRRR):";
$dostepny="dostêpny";
$niedostepny="wypo¿yczony";
$moje_nazwisko="Mularczyk";
$brak_wynikow="Brak Filmów spe³niaj±cych kryteria wyszukiwania";
$sa_wyniki="Wyniki wyszukiwania";
$o_dostep="Dostêpno¶æ";
$umnie="w domu";
?>



<?php
//czy mamy wyszukiwanie z okienka ?
if(isset($_GET['co']) && $_GET['co']=="okno")
{
$rez=$_POST['rezyser'];
$tyt=$_POST['tytul'];


$sql = ("SELECT `Filmy`.`ID_FILM` 
		 FROM `Filmy` , `Rezyserzy`
		 WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
		");
if($tyt!=NULL) $sql.=("AND `Filmy`.`TYTUL` LIKE \"%".mysql_real_escape_string($tyt)."%\"");
if($rez!=NULL) $sql.=("AND `Rezyserzy`.`NAZWISKO` LIKE \"%".mysql_real_escape_string($rez)."%\" ");
$sql.=("ORDER BY  `Filmy`.`TYTUL` ;");

//echo $sql;
$rezultat = mysql_query($sql) or die(mysql_error());
$liczba_wierszy=mysql_num_rows($rezultat);

if(!($liczba_wierszy)) echo("<div id=\"lista_filmow_top\">Nie znaleziono ¿adnego filmu</div>");
else
	{
	echo ("<div id=\"lista_filmow_top\">Znalezione filmy</div>");
	while($wiersz = mysql_fetch_array($rezultat, MYSQL_NUM))
		{
		wypisz_film($wiersz[0]);
		}	
    echo ("<div id=\"lista_filmow_stopka\">znaleziono ".$liczba_wierszy." filmów.</div>");
	}

}



else //standardowe wyszukiwanie
{
////SZUKANIE FILMU
if(isset($_GET['co']) && $_GET['co']=="film")
{ 

//sprawdzanie czy wype³nione jest choæ jedno pole



if (!empty($_POST['tyt'])) $tyt = $_POST['tyt'];
if (!empty($_POST['rez'])) $rez = $_POST['rez'];
if (!empty($_POST['rok'])) $rok = $_POST['rok'];

if(!($tyt || $rok || $rez) && !empty($_POST['wysylka'])) 
echo("<div class=\"info\">Wype³nij choæ jedno pole</div>");


//formularz wyszukiwania
echo("<br>

<table class=\"male_okno\">
<form action=\"".$PHP_SELF."?co=".$_GET['co']."\" method=\"post\">

<tr><td colspan=\"2\" class=\"d_opis\">Wyszukaj film</td></tr>

<tr>
<td class=\"d_opis\">".$o_tytul."</td>
<td class=\"d_okno2\">
<input name=\"tyt\" type=\"text\" size=\"40\" maxlength=\"75\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\">".$o_rezyser."</td>
<td class=\"d_okno2\">
<input name=\"rez\" type=\"text\" size=\"25\" maxlength=\"50\" class=\"d_okno\">
</td></tr>

<tr>
<td class=\"d_opis\" width=\"200\">".$o_rok."</td>
<td class=\"d_okno2\">
<input name=\"rok\" type=\"text\" size=\"4\" maxlength=\"4\" class=\"d_okno\">
</td></tr>

");

//<tr>
//<td class=\"d_opis\">".$o_dostep."</td>
//<td class=\"d_okno2\">
//<input name=\"dostep\" type=\"radio\" class=\"d_okno2\" value=\"dn\"checked>wszystkie 
//<input name=\"dostep\" type=\"radio\" class=\"d_okno2\" value=\"dt\">tylko dostêpne 
//</td></tr>

echo("
<tr>
<td class=\"d_opis\" colspan=\"2\">
<input type=\"hidden\" name=\"wysylka\" value=1 />
<input type=\"submit\" name=\"submit\" class=\"przycisk\" value=\"Szukaj\">&nbsp;
<input type=\"reset\" class=\"przycisk\" value=\"Reset\"></td></tr>
</form>
</table>");
}

?>
<br><BR>

<?php


//wypisywanie wyniku wyszukiwania
if($tyt || $rok || $rez)
{
//polaczenie w celu wys³ania wpisu do bazy
include ('param.php'); //parametry polaczenia z baza
$connect=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

$sql = ("SELECT `Filmy`.`ID_FILM` 
		 FROM `Filmy` , `Rezyserzy`
		 WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
		");
if($tyt!=NULL) $sql.=("AND `Filmy`.`TYTUL` LIKE \"%".mysql_real_escape_string($tyt)."%\"");
if($rok!=NULL) $sql.=("AND `Filmy`.`ROK` = ".mysql_real_escape_string($rok)." ");
if($rez!=NULL) $sql.=("AND `Rezyserzy`.`NAZWISKO` LIKE \"%".mysql_real_escape_string($rez)."%\" ");
$sql.=("ORDER BY  `Filmy`.`TYTUL` ;");

$rezultat = mysql_query($sql) or die(mysql_error());
$liczba_wierszy=mysql_num_rows($rezultat);

//brak wynikow wyszukiwania
if($liczba_wierszy==0) 
	echo("<div id=\"lista_filmow_top\">Nie znaleziono ¿adnego filmu</div>");

//znaleziono jakies filmy
else
{
	echo ("<div id=\"lista_filmow_top\">Znaleziono ".$liczba_wierszy." filmów</div>");
	while($wiersz = mysql_fetch_array($rezultat, MYSQL_NUM))
	{
		wypisz_film($wiersz[0]);
	}	
}
////////////////
mysql_close($polaczenie);
/////////////////
}


}
?>


<?php include('stopka.php');?>
