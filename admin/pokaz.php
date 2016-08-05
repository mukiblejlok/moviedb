<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>



<?php
$nr_str=1; //pierwsza podstrona
$ile_na_str=50; //ile wypisac wierszy na stronie

if(isset($_GET['nr_str'])) $nr_str=$_GET['nr_str'];
?>


<div id="lista_filmow_top">
<?php
if($_GET['co']=="rez") echo("Re¿yser");
elseif($_GET['co']=="kraj" || $_GET['co']=="rez_kraj") echo("Kraj");
elseif($_GET['co']=="osoba") echo("Osoba");
elseif($_GET['co']=="plyta") echo("P³yta nr ".$_GET['id']);
elseif($_GET['co']=="rok") echo("Rok ".$_GET['id']);


echo("</div>");

if($_GET['co']=="rez") wypisz_rezysera($_GET['id']);
elseif($_GET['co']=="kraj" || $_GET['co']=="rez_kraj") wypisz_kraj($_GET['id']);
elseif($_GET['co']=="osoba") wypisz_osobe($_GET['id']);

?>

<br />
<?php
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

//zapytanie gdy chodzi tylko o niewidziane filmy
if($_GET['n']==1)
{
$sql=("SELECT DISTINCT `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Ogladanie` 
	   ON (`Ogladanie`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Ogladanie`.`ID_OSOBA`=".$_SESSION['id_osoba'].")
	   WHERE (`Ogladanie`.`ID_OSOBA` <>".$_SESSION['id_osoba']." 
	        OR `Ogladanie`.`ID_OSOBA` IS NULL)
	  AND ");
	if($_GET['co']=="rez") $sql.=("`Filmy`.`ID_REZ` =".$_GET['id']." ");
	elseif($_GET['co']=="osoba") $sql.=("`Filmy`.`ID_OSOBA` =".$_GET['id']." ");
	elseif($_GET['co']=="rok") $sql.=("`Filmy`.`ROK` =".$_GET['id']." ");
	elseif($_GET['co']=="kraj") $sql.=("`Filmy`.`ID_KRAJ` =".$_GET['id']." ");
	elseif($_GET['co']=="plyta") $sql.=("`Filmy`.`NR_PLYTY` =".$_GET['id']." ");	  
$sql.=("ORDER BY `Filmy`.`TYTUL`");
}
else
{
//zapytanie ogolne
$sql=("SELECT `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   WHERE ");
if($_GET['co']=="rez") $sql.=("`Filmy`.`ID_REZ` =".$_GET['id']." ");
elseif($_GET['co']=="osoba") $sql.=("`Filmy`.`ID_OSOBA` =".$_GET['id']." ");
elseif($_GET['co']=="rok") $sql.=("`Filmy`.`ROK` =".$_GET['id']." ");
elseif($_GET['co']=="kraj") $sql.=("`Filmy`.`ID_KRAJ` =".$_GET['id']." ");
elseif($_GET['co']=="plyta") $sql.=("`Filmy`.`NR_PLYTY` =".$_GET['id']." ");
else $sql.=("1=0 ");
$sql.=("ORDER BY `Filmy`.`TYTUL` ");
}


////Gdy chodzi o rezyserow z danego kraju
if($_GET['co']=="rez_kraj")
{
$sql=("SELECT `ID_REZ`
	  FROM `Rezyserzy`
	  WHERE `ID_KRAJ`=".$_GET['id']." ");
$sql.=("ORDER BY `Rezyserzy`.`NAZWISKO` ");
}

$sql2=("LIMIT ".(($nr_str-1)*$ile_na_str).", ".$ile_na_str);
//Sprawdzenieile jest wszystkich wierszy
$wynik=mysql_query($sql);
$wynik2=mysql_query($sql.$sql2);
 
$ilosc_wierszy=mysql_num_rows($wynik);

if($_GET['co']=="plyta") echo("<div id=\"lista_filmow_top\">i jej ");
else if($_GET['co']=="osoba") echo("<div id=\"lista_filmow_top\">i wypo¿yczone przez ni± ");

else echo("<div id=\"lista_filmow_top\">i jego ");
if($_GET['n']==1) echo "niewidziane";

if($_GET['co']=='rez_kraj') echo(" re¿yserzy</div>");
else echo(" filmy</div>");

//echo $sql;
//robienie opcji wyboru podstrony jezeli jest wiecej pozycji niz chce
if($ilosc_wierszy>$ile_na_str) 
{
echo ("<div id=\"lista_filmow_litery\">");
	for($i=1; $i<=($ilosc_wierszy/$ile_na_str)+1 ; $i++)
	{
     if($i==$nr_str) echo ("<span class=\"aktywny\"> ".$nr_str." </span>");
    else echo ("<a href=\"".$PHP_SELF."?nr_str=".$i."&co=".$_GET['co']."&id=".$_GET['id']
	          ."&n=".$_GET['n']."\" 
	class=\"down\"> ".$i."</a>");
    }
echo("</div>");
};


while($wiersz = mysql_fetch_array($wynik2, MYSQL_NUM)) 
{
	if($_GET['co']=="rez_kraj") wypisz_rezysera($wiersz[0]); 
	else wypisz_film($wiersz[0]);
}

//liczba wierszy
echo("<div id=\"lista_filmow_stopka\" style=\"height:45px;\">znaleziono ".$ilosc_wierszy);
if($ilosc_wierszy==1)echo(" film");
else if($ilosc_wierszy==2 || $ilosc_wierszy==3 || $ilosc_wierszy==4) echo(" filmy");
else echo(" filmów");

//je¿eli nie wyszystkie wypisano
if($ilosc_wierszy>$ile_na_str) 
{
echo (",<br>ale wypisano tylko ".$ile_na_str."<br>od nr ".(($nr_str-1)*$ile_na_str)." do "
.(($nr_str)*$ile_na_str));
}
echo ("</div>");

/////////////////
mysql_close($polaczenie);
/////////////////
?>
<?php include('stopka.php');?>

