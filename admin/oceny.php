<?php include("naglowek.php");?>
<?php include("sprawdz_log.php"); ?>
<?php include("naglowek2.php");?>

<?php

if(empty($_GET['kto'])) $_GET['kto']="ja";
if(empty($_GET['co'])) $_GET['kto']="all";

//male podmenu kto
if($_GET['kto']=="ja") 	  echo("<strong>Moje oceny</strong> | ");
else 	                  echo ("<a href=\"oceny.php?kto=ja&co=".$_GET['co']."\" class=\"link\">Moje oceny</a> | ");

if($_GET['kto']=="sr") 	  echo("<strong>Wszystkie oceny</strong> | ");
else   			          echo ("<a href=\"oceny.php?kto=sr&co=".$_GET['co']."\" class=\"link\">Wszystkie oceny</a> | ");

if($_GET['kto']=="filip") echo("<strong>Oceny Filipa</strong>");
else     		    	  echo ("<a href=\"oceny.php?kto=filip&co=".$_GET['co']."\" class=\"link\">Oceny Filipa</a>");
////////

echo("<br /><br />");

//male podmenu co
if($_GET['co']=="rok") 	  echo("<strong>Top 10 Roku</strong> | ");
else 	                  echo ("<a href=\"oceny.php?co=rok&kto=".$_GET['kto']."\" class=\"link\">Top 10 Roku</a> | ");

if($_GET['co']=="dek") 	  echo("<strong>Top 25 Dekady</strong> | ");
else   			          echo ("<a href=\"oceny.php?co=dek&kto=".$_GET['kto']."\" class=\"link\">Top 25 Dekady</a> | ");

if($_GET['co']=="all")    echo("<strong>Top 100 Wszechczasów</strong>");
else     		    	  echo ("<a href=\"oceny.php?co=all&kto=".$_GET['kto']."\" class=\"link\">Top 100 Wszechczasów</a>");
////////

echo("<br /><br />");



//podmenu rok
if($_GET['co']=="rok") 
{
	echo("<div id=\"detale_oceny_".$id."\" style=\"none;height:15px;\" >");
	//skala ocen
	$min=1920;
	$max=2010;
	
	for($i=$min;$i<=$max;$i++)
	{
		echo("<div  
		       onMouseOver=\"podswietl_rok(".$i.",".$max.")\" 
			   onMouseOut=\"skasuj_podswietlenie_rok(".$i.",".$max.")\"
			   id=\"link_rok_".$i."\"
			   class=\"link_oceny\" title=\"".$i."\"
			   onClick=\"parent.top.location.href='oceny.php?kto=".$_GET['kto']."&co=rok&ktory=".$i."' \"
			   style=\"background-color:white; height:12px; width:3px;float:left; 
			   z-index:10; border-bottom: thin solid black;
			   border-top: thin solid black;
			   border-left:thin solid black;\"></div>");
	}	
	echo("<div style=\"background-color:black; height:12px; width:1px;float:left; 
			   border-bottom: thin solid black;border-top: thin solid black;  \"></div>
	<div style=\"font-size:8px;clear:both;\">");
	for($i=$min;$i<$max;$i++) if(!($i%10)) echo($i."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	echo("</div></div>");
	
} 

//podmenu dekada
else if($_GET['co']=="dek") 
{
	for($i=10;$i<=100;$i+=10) 
	{
		if($i<100) 
		{
			if($_GET['ktory']==$i) echo("<strong>".$i."'s</strong> | ");
			else echo("<a href=\"".$PHP_SELF."?kto=".$_GET['kto']."&co=".$_GET['co']."&ktory=".$i."\" 
		                  class=\"link\">".$i."'s</a> | ");
		}
		else 
		{
			if($_GET['ktory']==$i) echo("<strong>00's</strong>");
			else echo("<a href=\"".$PHP_SELF."?kto=".$_GET['kto']."&co=".$_GET['co']."&ktory=".$i."\" 
		                 class=\"link\">00's</a>");
        }
	}
}

echo("<br /><br />");
?>
<div id="lista_filmow_top">
<?php
if($_GET['kto']=="ja") echo("Moja - ");
if($_GET['kto']=="sr") echo("Bazy - ");
if($_GET['kto']=="filip") echo("Filipa - ");


if($_GET['co']=="rok") {
						if(!isset($_GET['ktory'])) $_GET['ktory']=2008;
						echo("Top 10 roku ".$_GET['ktory']);
						}
if($_GET['co']=="dek") {
						if(!isset($_GET['ktory'])) $_GET['ktory']=100;
						if($_GET['ktory']=="100") echo ("Top 25 dekady 00's"); 
						else echo("Top 25 dekady ".$_GET['ktory']."'s");
					   }
if($_GET['co']=="all") echo("Top 100 wszechczasów");
?>
</div>


<?
//osoby przegladajacej lub filipa
if($_GET['kto']=="ja" || $_GET['kto']=="filip")
{
if($_GET['kto']=="ja") $co_za_osoba=$_SESSION['id_osoba'];
else if($_GET['kto']=="filip") $co_za_osoba=1;

//rok
if($_GET['co']=="rok") 

$sql=("SELECT DISTINCT `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Oceny` 
	   ON (`Oceny`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Oceny`.`ID_OSOBA`=".$co_za_osoba.")
	   WHERE `Oceny`.`ID_OSOBA` IS NOT NULL 
	   AND `Filmy`.`ROK`=".$_GET['ktory']."
	   ORDER BY `Oceny`.`OCENA` DESC
	   LIMIT 10;"
		);

//dekada
if($_GET['co']=="dek") 

$sql=("SELECT DISTINCT `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Oceny` 
	   ON (`Oceny`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Oceny`.`ID_OSOBA`=".$co_za_osoba.")
	   WHERE `Oceny`.`ID_OSOBA` IS NOT NULL    
	   AND (`Filmy`.`ROK` BETWEEN ".(1900+$_GET['ktory'])." AND ".(1909+$_GET['ktory']).")
	   ORDER BY `Oceny`.`OCENA` DESC
	   LIMIT 25;"
		);


//wszechczasy

if($_GET['co']=="all") $sql=("SELECT DISTINCT `Filmy`.`ID_FILM`
	   FROM `Filmy` 
	   LEFT JOIN `Oceny` 
	   ON (`Oceny`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Oceny`.`ID_OSOBA`=".$co_za_osoba.")
	   WHERE `Oceny`.`ID_OSOBA` IS NOT NULL 
	   ORDER BY `Oceny`.`OCENA` DESC
	   LIMIT 100;"
		);
}

//srednia ocen bazy
else if($_GET['kto']=="sr")
{
$sql=("SELECT DISTINCT `Filmy`.`ID_FILM` , AVG( `Oceny`.`OCENA` ) AS SR
	   FROM `Filmy`
	   LEFT JOIN `Oceny` ON ( `Oceny`.`ID_FILM` = `Filmy`.`ID_FILM` )
	   WHERE `Oceny`.`ID_OSOBA` IS NOT NULL
	   AND `Filmy`.`ROK`=".$_GET['ktory']."
	   GROUP BY `Filmy`.`ID_FILM`
	   ORDER BY SR DESC
	   LIMIT 10;"
		);

//dekada
if($_GET['co']=="dek") 

$sql=(" SELECT DISTINCT `Filmy`.`ID_FILM` , AVG( `Oceny`.`OCENA` ) AS SR
		FROM `Filmy`
		LEFT JOIN `Oceny` ON ( `Oceny`.`ID_FILM` = `Filmy`.`ID_FILM` )
		WHERE `Oceny`.`ID_OSOBA` IS NOT NULL
	    AND (`Filmy`.`ROK` BETWEEN ".(1900+$_GET['ktory'])." AND ".(1909+$_GET['ktory']).")
	    GROUP BY `Filmy`.`ID_FILM`
		ORDER BY SR DESC
	    LIMIT 25;"
		);

//wszechczasy
if($_GET['co']=="all") $sql=(" SELECT DISTINCT `Filmy`.`ID_FILM` , AVG( `Oceny`.`OCENA` ) AS SR
	FROM `Filmy`
	LEFT JOIN `Oceny` ON ( `Oceny`.`ID_FILM` = `Filmy`.`ID_FILM` )
	WHERE `Oceny`.`ID_OSOBA` IS NOT NULL
	GROUP BY `Filmy`.`ID_FILM`
	ORDER BY SR DESC
	LIMIT 100 "
		);
}		

$wynik=mysql_query($sql) or die(mysql_error()); 
$ilosc_wierszy=mysql_num_rows($wynik);
$i=1;
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_film_nr($wiersz[0],$i);
$i++;
}
echo("<div id=\"lista_filmow_stopka\">znaleziono ".$ilosc_wierszy);
if($ilosc_wierszy==1)echo(" film");
else if($ilosc_wierszy==2 || $ilosc_wierszy==3 || $ilosc_wierszy==4) echo(" filmy");
else echo(" filmów");
echo("</div>");
?>





<?php include ('stopka.php'); ?>