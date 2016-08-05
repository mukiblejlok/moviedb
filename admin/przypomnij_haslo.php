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


//DECYZJA PODJETA
//wysylamy
if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{
//

//generowanie hasla

$haslo=substr(md5(time()), 0, 10);

$sql=("UPDATE `osoby` SET `PASS`=\"".sha1($haslo)."\" WHERE `ID_OSOBA`=".$id);
$wynik=mysql_query($sql) or die(mysql_error());
// $haslo=mysql_fetch_array($wynik, MYSQL_NUM);	   


//tworzenie maila
$content = ("__To jest wiadomo¶æ tworzona automatycznie nie odpowiadaj na ni±__________
\n\nAdministrator strony movieDATAbase wysy³a Ci twoje nowe has³o dostêpowe do strony filip.techrom.com.pl .
Pewnie go o nie prosi³e¶, a je¿eli nie to po prostu skasuj tê wiadomo¶æ.
\n\noto Twoje nowe has³o: ".$haslo."\nnie zapomnij zmieniæ go na jakie¶ bardziej przystêpne po zalogowaniu.
\nMi³ego korzystania z movieDATAbase
\nPozdrawiam,\nFilip 
");
	
//wysylanie
    $adresat = $_GET['mail']; 	
	$header = 	"From: baza@filip.techrom.com.pl \nContent-Type:".
			' text/plain;charset="iso-8859-2"'.
			"\nContent-Transfer-Encoding: 8bit";
	if(mail($adresat, 'movieDATAbase - nowe has³o', $content, $header))
		{
echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>Has³o zosta³o wys³ane na maila<br>
Mo¿esz zamknaæ okno</div>");
}

else
{
echo ("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0></a>
<br>Nie uda³o siê wys³aæ has³a<br>
Mo¿esz zamknaæ okno</div>");
}

}

else
{
//DECYZJA NIEPODJETA
//kto
$sql=("SELECT `osoby`.`IMIE`, `osoby`.`NAZWISKO`, `osoby`.`EMAIL`
	   FROM `osoby` WHERE `ID_OSOBA`=".$id);
$wynik=mysql_query($sql) or die(mysql_error());
$kto=mysql_fetch_array($wynik, MYSQL_NUM);	   

echo("<div id=\"okno_pytanie\">Czy chesz wys³aæ tej osobie<br />
<b>".$kto[0]." ".$kto[1]."</b><br />
nowe has³o na maila<br />
<b>".$kto[2]."</b>?<br />
</div>
");

//odpowiedz na pytanie
echo("<Br><div id=\"okno_pytanie\">
<a href=\"przypomnij_haslo.php?id=".$id."&mail=".$kto[2]."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;

<a href=\"#\" class=\"detale_link\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");


}
//koniec polaczenia
mysql_close($connect);
//////////////////

?>

</div>
<?php include("stopka_okno.php"); ?>


