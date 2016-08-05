<?php include("naglowek.php");?>
<?php include ("sprawdz_log.php"); ?>  
<?php include("naglowek2.php");?>

<?php
$litera="0-9";                       //pierwsza litera
$umnie="u mnie";                   //tekst gdy film jest u mnie 
if(isset($_GET['litera']))$litera = $_GET['litera'];
?>

<div class="zwykly">
<?php 
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

//echo("<br>Ostatni zajêty nr p³yty to : ");
$sql=("SELECT DISTINCT MAX(`NR_PLYTY`) FROM `Filmy` ");
$wynik=mysql_query($sql); 
$ilosc_wierszy=mysql_num_rows($wynik);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
$maxi=$wiersz[0];
//echo(" ".$wiersz[0]);
}

?> 

</div>
<br />
<form method="post" action="cd_dvd.php" name="form">

<div id="lista_filmow_top" style="width:423px;"> 
Filmy CD na DVD bez przydzielonego nr p³yty</div>

<!----wy¶wieltlenie wszystkich filmów z podzia³em na litery---->
<?php
//tutaj wypisuje te które jeszcze NIE S¡ ZROBIONE

$sql=("SELECT `Filmy`.`TYTUL` , 
			 `Rezyserzy`.`NAZWISKO` , `Rezyserzy`.`IMIE`,
			 `Filmy`.`ROK` , `Kraje`.`NAZWA`,
			  DATE_FORMAT(`Filmy`.`Data_Utworzenia`,'%Y-%c-%d'),
			  `Filmy`.`ID_FILM`
FROM `Filmy` , `Rezyserzy`, `osoby`, `Nosniki` ,`Kraje`
WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
AND `osoby`.`ID_OSOBA` = `Filmy`.`ID_OSOBA`
AND `Nosniki`.`ID_TYP` = `Filmy`.`ID_TYP_NOSNIKA`
AND `Nosniki`.`ID_TYP` = 3 
AND `Filmy`.`NR_PLYTY` = 0
AND `Kraje`.`ID_KRAJ` = `Filmy`.`ID_KRAJ`
ORDER BY `Filmy`.`DATA_UTWORZENIA`, `Filmy`.`TYTUL`
");

$wynik=mysql_query($sql); 
$ilosc_wierszy=mysql_num_rows($wynik);
while($wiersz = mysql_fetch_array($wynik, MYSQL_NUM)) 
{
wypisz_film2($wiersz[6]);
}//koniec while

//liczba wierszy
echo("<div id=\"lista_filmow_stopka\" style=\"height:30px;width:433px;\">znalezionych filmów: "
      .$ilosc_wierszy."<br />
	  ostatni zajêty numer to : ".$maxi."
	  </div><br />
	  zaznacz filmy na p³ycie, wybierz numer i dodaj<br /> 	  
<input name=\"numer\" style=\"width:50px;\" class=\"d_okno\" type=\"text\" id=\"numer\" value=".($maxi+1)." />	  
<input name=\"dodaj\" class=\"przycisk\" type=\"submit\" id=\"dodaj\" value=\"dodaj\" />

</form>	  
	  ");
	  
if($dodaj){
for($i=0;$i<$ilosc_wierszy;$i++)
	{
	 $id_filmu = $checkbox[$i];
	 if(!empty($id_filmu))
	 {
     $sql = ("UPDATE `Filmy` SET `NR_PLYTY`=".$numer." WHERE `ID_FILM`=".$id_filmu." ;");
     //echo $sql;
	 $wynik = mysql_query($sql);
	 }
	}
echo ("<meta http-equiv=\"refresh\" content=\"0;URL=cd_dvd.php\">");
}

/////////////////
mysql_close($polaczenie);
/////////////////
?>


<?php include('stopka.php');?>
