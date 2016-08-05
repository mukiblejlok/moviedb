<?php include("naglowek_okno.php");?>
<?php include("sprawdz_log.php"); ?> 
<div style="text-align:center;">
<?php 
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
if(isset($_GET['id']))$id_film = $_GET['id']; 



echo("
<div id=\"okno_film\">");

//Pobranie danych z $_GET jesli ustawione 
$sql=("SELECT `Filmy`.`TYTUL`, `Filmy`.`ROK`,  
			  `Rezyserzy`.`IMIE`, `Rezyserzy`.`NAZWISKO`, 
			  `Kraje`.`NAZWA` 
	  FROM `Filmy` , `Rezyserzy`, `Kraje`
	  WHERE `Rezyserzy`.`ID_REZ` = `Filmy`.`ID_REZ` 
	  AND `Kraje`.`ID_KRAJ` = `Filmy`.`ID_KRAJ`
	  AND `Filmy`.`ID_FILM`=".$id_film."
	  LIMIT 1
	  ");
$wynik=mysql_query($sql);  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("<br><b>".$wiersz[0]."</b><br> re¿. ".$wiersz[2]." ".$wiersz[3]."<br>".$wiersz[4].
", ".$wiersz[1]."<br></div>");


$ad_filmweb="http://www.filmweb.pl/f702/Siedem,1995";
$ad_imdb="http://www.imdb.com/title/tt0114369/";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $ad_imdb);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 15);
$wynik = curl_exec($curl);
curl_close($curl);

//wynik to nasza strona
//echo mysql_escape_string($wynik);

//szukanie

//re¿yser
$rez = explode('<h5>Director',$wynik);
$rez = $rez[1];
$rez = explode('<br/>', $rez);
$rez = $rez[0];
$rez = explode('/">',$rez);
$rez = $rez[1];
$rez = explode('</a>', $rez);
$rez = $rez[0];

$scenar = explode('<h5>Writer',$wynik);
$scenar = $scenar[1];
$scenar = explode('<br/>', $scenar);
$scenar = $scenar[0];
$scenar = explode('/">',$scenar);
$scenar = $scenar[1];
$scenar = explode('</a>', $scenar);
$scenar = $scenar[0];

$czas = explode('<h5>Runtime:</h5>',$wynik);
$czas = $czas[1];
$czas = explode('</div>', $czas);
$czas = $czas[0];


echo mysql_escape_string($rez)."<br/>".mysql_escape_string($scenar)."<br/>".mysql_escape_string($czas);

//koniec polaczenia
mysql_close($connect);
//////////////////

?>

</div>
<?php include("stopka_okno.php"); ?>


