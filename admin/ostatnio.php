<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>    
<?php include("naglowek2.php");?>


<?php
$ile=5;                            //pierwsza litera
?>

<div id="lista_filmow_top">
<?php if(isset($_GET['ile']))$ile = $_GET['ile'];  //pobranie z $_GET ilosci ostatnio dodanych
echo $ile." ostatnio ";
if($_GET['co']=="kup") echo "kupionych";
elseif($_GET['co']=="mod") echo "modyfikowanych";
elseif($_GET['co']=="dod") echo "dodanych";
elseif($_GET['co']=="wid") echo "widzianych";
echo " filmów";
?>
</div>

<?php
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
if($_GET['co']=="kup")
{
$sql=("SELECT `Filmy`.`ID_FILM` FROM `Filmy`
ORDER BY `Filmy`.`DATA_ZAKUPU` DESC
LIMIT 0, ".$ile." ;");
}
elseif($_GET['co']=="mod")
{

$sql=("SELECT `Filmy`.`ID_FILM` FROM `Filmy`
ORDER BY `Filmy`.`DATA_MOD` DESC
LIMIT 0, ".$ile." ;");
}

elseif($_GET['co']=="wid")
{

$sql=("SELECT DISTINCT `Filmy`.`ID_FILM` FROM `Filmy`, `Ogladanie`
WHERE `Ogladanie`.`ID_OSOBA` = ".$_SESSION['id_osoba']."
AND `Ogladanie`.`ID_FILM` = `Filmy`.`ID_FILM`
ORDER BY `Ogladanie`.`DATA` DESC, `Filmy`.`TYTUL`
LIMIT 0, ".$ile." ;");
}


elseif($_GET['co']=="dod")
{

$sql=("SELECT `Filmy`.`ID_FILM` 
	   FROM `Filmy`
	   ORDER BY `Filmy`.`DATA_UTWORZENIA` DESC, `Filmy`.`TYTUL`
	   LIMIT 0, ".$ile);
}
else $sql=" ";
$rezultat = mysql_query($sql);
while($wiersz = mysql_fetch_array($rezultat, MYSQL_NUM))
{
//wypisywanie kolejnych pol wiersza
wypisz_film($wiersz[0]);
}

//koniec polaczenia
mysql_close($connect);
//////////////////
?>

<div id="lista_filmow_stopka">
<?php
if($ile>5)
echo("<a href=\"".$PHP_SELF."?co=".$_GET['co']."&ile=".($ile-5)."\" class=\"plus_minus\"
TITLE=\"Mniej wyników\">mniej wyników (-)</a> /");

if($ile<100)
echo(" <a href=\"".$PHP_SELF."?co=".$_GET['co']."&ile=".($ile+5)."\" class=\"plus_minus\" 
TITLE=\"Wiêcej wyników\">(+) wiêcej wyników</a><br>");
?>

</div>

<?php include ('stopka.php'); ?>


    