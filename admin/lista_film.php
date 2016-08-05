<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<?php
$litera="0-9";                       //pierwsza litera
if(isset($_GET['litera']))$litera = $_GET['litera'];


//male podmenu
if($_GET['co']=="all") 	  echo("<strong>Wszystkie filmy</strong> | ");
else 	                  echo ("<a href=\"lista_film.php?co=all\" class=\"link\">Wszystkie filmy</a> | ");

if($_GET['co']=="dvd") 	  echo("<strong>Filmy na DVD</strong> | ");
else   			          echo ("<a href=\"lista_film.php?co=dvd\" class=\"link\">Filmy na DVD</a> | ");

if($_GET['co']=="niewid") echo("<strong>Niewidziane filmy</strong> |");
else     		    	  echo ("<a href=\"lista_film.php?co=niewid\" class=\"link\">Niewidziane filmy</a> |");

if($_GET['co']=="wid")    echo("<strong>Widziane filmy</strong>");
else             	      echo ("<a href=\"lista_film.php?co=wid\" class=\"link\">Widziane filmy</a>");
////////
?>
<br />
<br />
<br />
<div id="lista_filmow_top">
<?php 
if(isset($_GET['co']) && $_GET['co']=="dvd") echo("Lista filmów na DVD");
else if(isset($_GET['co']) && $_GET['co']=="niewid") echo("Lista nieobejrzanych filmów");
else if(isset($_GET['co']) && $_GET['co']=="wid") echo("Lista widzianych filmów");
else echo ("Lista filmów");
?>
</div>

<div id="lista_filmow_litery">
<?php
//literki linki
$alfabet = array("0-9","A","B","C","Æ","D","E",
"F","G","H","I","J","K","L","£","M","N",
"O","Ó","P","Q","R","S","¦","T","U","V",
"W","X","Y","Z","¬","¯");
foreach($alfabet AS $lit) 
{
   if($litera==$lit) echo ("<span class=\"aktywny\"> ".$lit." </span>");
   else echo ("<a href=\"".$PHP_SELF."?litera=".$lit."&co=".$_GET['co']." \" class=\"down\"> ".$lit."</a>");
}
?>

</div>

<?php
//WYPISANIE FILMOW

///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////


$sql=("SELECT `Filmy`.`ID_FILM` 
	   FROM `Filmy` 
       WHERE `Filmy`.`TYTUL` ");
if ($litera=="0-9") $sql .= (" REGEXP \"^[[:digit:]]+\" ") ;
else $sql .= (" LIKE \"".$litera."%\" "); 
//DVD 
if($_GET['co']=="dvd") $sql .= ("AND `Filmy`.`ID_TYP_NOSNIKA`=2 ");
$sql .=(" ORDER BY `Filmy`.`TYTUL`");

//niewidziane
if($_GET['co']=="niewid")
{
$sql=("SELECT DISTINCT `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Ogladanie` 
	   ON (`Ogladanie`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Ogladanie`.`ID_OSOBA`=".$_SESSION['id_osoba'].")
	   WHERE (`Ogladanie`.`ID_OSOBA` <>".$_SESSION['id_osoba']." 
	   OR `Ogladanie`.`ID_OSOBA` IS NULL) 
	   AND `Filmy`.`TYTUL` "
		);
if ($litera=="0-9") $sql .= (" REGEXP \"^[[:digit:]]+\" ") ;
else $sql .= (" LIKE \"".$litera."%\" "); 
$sql .=(" ORDER BY `Filmy`.`TYTUL`");
}

//niewidziane
if($_GET['co']=="wid")
{
$sql=("SELECT DISTINCT `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Ogladanie` 
	   ON (`Ogladanie`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Ogladanie`.`ID_OSOBA`=".$_SESSION['id_osoba'].")
	   WHERE `Ogladanie`.`ID_OSOBA` IS NOT NULL 
	   AND `Filmy`.`TYTUL` "
		);
if ($litera=="0-9") $sql .= (" REGEXP \"^[[:digit:]]+\" ") ;
else $sql .= (" LIKE \"".$litera."%\" "); 
$sql .=(" ORDER BY `Filmy`.`TYTUL`");
}

$wynik=mysql_query($sql); 
$ilosc_wierszy=mysql_num_rows($wynik);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_film($wiersz[0]);
}
echo("<div id=\"lista_filmow_stopka\">znaleziono ".$ilosc_wierszy);
if($ilosc_wierszy==1)echo(" film");
else if($ilosc_wierszy==2 || $ilosc_wierszy==3 || $ilosc_wierszy==4) echo(" filmy");
else echo(" filmów");
echo(" na litere <strong>".$litera."</strong></div>");

/////////////////
mysql_close($polaczenie);
/////////////////
?>

<?php include('stopka.php');?>

