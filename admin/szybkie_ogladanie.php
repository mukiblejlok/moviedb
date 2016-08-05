<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<form method="post" action="<?php echo $PHP_SELF."?litera=".$litera ?>" name="form">


<div id="lista_filmow_top" style="width:423px;"> 
Niewidziane filmy</div>
<div id="lista_filmow_litery" style="width:433px;">
<?php
//literki linki
if(!isset($_GET['litera'])) $litera="0-9";
$alfabet = array("0-9","A","B","C","Æ","D","E",
"F","G","H","I","J","K","L","£","M","N",
"O","Ó","P","Q","R","S","¦","T","U","V",
"W","X","Y","Z","¬","¯");
foreach($alfabet AS $lit) {

   if($litera==$lit){
   echo ("<span class=\"aktywny\"> ".$lit." </span>");
                           }
 else{
 echo ("<a href=\"".$PHP_SELF."?litera=".$lit."&co=".$_GET['co']." \" 
 	    class=\"down\"> ".$lit."</a>");
     }
						 }
?>
</div>


<?php
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

//tutaj wypisuje te które jeszcze NIE S¡ ZROBIONE

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

$wynik=mysql_query($sql); 
$ilosc_wierszy=mysql_num_rows($wynik);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_film2($wiersz[0]);
}

//liczba wierszy
echo("<div id=\"lista_filmow_stopka\" style=\"width:433px;\">znalezionych filmów: "
      .$ilosc_wierszy."
	  </div><br />
	  zaznacz filmy, które widzia³e¶ i kliknij przycisk	  
<input name=\"dodaj\" class=\"przycisk\" type=\"submit\" id=\"dodaj\" value=\"widziane\" />

</form>	  
	  ");
	  
	  
//procedura dodanie do ogl±danych	  
if(isset($_POST['dodaj'])){
for($i=0;$i<$ilosc_wierszy;$i++)
	{
	 $id_filmu = $checkbox[$i];
	 if(!empty($id_filmu))
	 {
     $sql=("INSERT INTO `Ogladanie` (`ID`, `ID_OSOBA`, `ID_FILM`, `DATA`) 
       VALUES (NULL, ".$_SESSION['id_osoba'].", ".$id_filmu.", NOW());
	  ");
	  //echo $sql;
     $wynik = mysql_query($sql) or die(mysql_error());
	 } 
	}
echo ("<meta http-equiv=\"refresh\" content=\"0;URL=".$PHP_SELF."?litera=".$litera."\">");
}

/////////////////
mysql_close($polaczenie);
/////////////////
?>


<?php include('stopka.php');?>
