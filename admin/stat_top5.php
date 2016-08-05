<?php include("naglowek.php");?>
<?php include("sprawdz_log.php"); ?>
<?php include("naglowek2.php");?>
<?php 
//chcesz baze to masz
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
?>

<div class="zwykly" style="width:400px;">
<strong>TOP X FILMÓW</strong><hr />
<form name="form_ile">
Mo¿e byæ TOP5, a mo¿e byæ tyle <br />
ile tu wpiszesz:  
<input type="text" name="top_ile" maxlength="2" class="d_okno" style="width:20px;"/>
(od 1 do 10)
</form>


<?php if(isset($_GET['top_ile'])){ 
			$top_ile=$_GET['top_ile']; 
	  		if($top_ile > 10)$top_ile=10;
			}
	  
	  else $top_ile=5;
?>


<br />
<div id="lista_filmow_top">
TOP<?php echo $top_ile; ?> Najstarszy film:
</div>

<?php
//zapytanie sql najstarsze filmy
$sql=("SELECT `ID_FILM`
	   FROM `Filmy`
	   GROUP BY `Rok`, `Tytul`
	   LIMIT ").$top_ile;
$wynik=mysql_query($sql);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_film($wiersz[0]);
} 
?>

<br />
<div id="lista_filmow_top">
TOP<?php echo $top_ile ?> Najd³u¿szy tytu³:</div>
<?php
//zapytanie sql najstarsze filmy
$sql=("SELECT `ID_FILM`, LENGTH(`Tytul`) as mmm
	   FROM `Filmy`
	   GROUP BY `mmm` DESC
	   LIMIT ").$top_ile;
$wynik=mysql_query($sql);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_film($wiersz[0]);
} 
?>

<br />
<div id="lista_filmow_top">
TOP<?php echo  $top_ile ?> Najkrótszy tytu³: ???</div>
<?php
//zapytanie sql najstarsze filmy
$sql=("SELECT `ID_FILM`, LENGTH(`Tytul`) as mmm
	   FROM `Filmy`
	   GROUP BY `mmm`
	   ORDER BY `mmm`
	   LIMIT ").$top_ile;
	   
$wynik=mysql_query($sql);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_film($wiersz[0]);
} 
?>

<br />
<div id="lista_filmow_top">
TOP<?php echo $top_ile ?>Re¿yser:</div>
<?php
//zapytanie sql najstarsze filmy
$sql=("SELECT `Rezyserzy`.`ID_REZ`, COUNT(`Filmy`.`ID_REZ`) as mmm
	   FROM `Filmy`, `Rezyserzy`
	   WHERE `Rezyserzy`.`ID_REZ`=`Filmy`.`ID_REZ`
	   GROUP BY `Filmy`.`ID_REZ`
	   ORDER BY `mmm` DESC
       LIMIT  ").$top_ile;
$wynik=mysql_query($sql);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_rezysera($wiersz[0]);
} 
?>


<br />
<div id="lista_filmow_top">
TOP<?php echo $top_ile ?> Kraje produkcji:</div>
<?php
//zapytanie sql najstarsze filmy
$sql=("SELECT `Kraje`.`ID_KRAJ`, COUNT(`Filmy`.`ID_KRAJ`) as mmm
	   FROM `Filmy`, `Kraje`
	   WHERE `Kraje`.`ID_KRAJ`=`Filmy`.`ID_KRAJ`
	   GROUP BY `Filmy`.`ID_KRAJ`
	   ORDER BY `mmm` DESC
       LIMIT  ").$top_ile;
$wynik=mysql_query($sql);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_kraj($wiersz[0]);
} 
?>




</div>
<?php include ('stopka.php'); ?>
