<?php include("naglowek_okno.php");?>
<?php include("sprawdz_log.php"); ?> 

<div style="text-align:center">
<?php

if($_GET['co']=="wyslij" && !empty($_POST['tytul']) && !empty($_POST['tresc']))
{

///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
$sql=("SELECT `IMIE`, `NAZWISKO`, `EMAIL` FROM `osoby` WHERE `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$kto=mysql_fetch_array($wynik, MYSQL_NUM);	   


$tytul=strip_tags($_POST['tytul']);
$tresc="Wiadomo¶æ wys³ana z formularza na stronie, przez ".$kto[0]." ".$kto[1]."\n
--------------------------------------------------------------------------------\n"
        .strip_tags($_POST['tresc']).
		"\n------------------------------------------------------------------------
		\nmozesz jej odpowiedzieæ pod adresem:\n".$kto[2];



//wysylanie
    $header ="From:".$kto[0].".".$kto[1]."@moviedatabase \nContent-Type:".
			' text/plain;charset="iso-8859-2"'.
			"\nContent-Transfer-Encoding: 8bit";
	if(mail("filasek@gazeta.pl", $tytul, $tresc, $header))
	{
	echo ("
	<div id=\"okno_pytanie\"><br>
	<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
	<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
	<br>Wiadomo¶æ zosta³a wys³ana<br>
	Mo¿esz zamknaæ okno</div>");
	}

	else
	{
	echo ("
	<div id=\"okno_pytanie\"><br>
	<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
	<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0></a>
	<br>Nie uda³o siê wys³aæ wiadomo¶ci<br>
	Mo¿esz zamknaæ okno</div>");
	}

}

else
{
//formularz do wpisywania newsa
echo("
<form method=\"post\" name=\"dodaj_newsa\" action=\"kontakt.php?co=wyslij\" >
<table>
<tr><td class=\"news_dodaj_l\">
tytu³: 
</td><td class=\"news_dodaj_p\">
<input type=\"text\" name=\"tytul\" class=\"d_okno\" style=\"width:200px;\"/>
</td></tr>

<tr><td class=\"news_dodaj_l\">
tre¶æ: 
</td><td class=\"news_dodaj_p\">
<textarea name=\"tresc\" cols=40 rows=12 class=\"d_okno\"></textarea>
</td></tr>

<tr><td class=\"news_dodaj_l\">
&nbsp;
</td><td class=\"news_dodaj_p\">
<input type=\"submit\" name=\"zmiana_param\" value=\"wy¶lij\" class=\"przycisk\"/>
</td></tr>
</table>
</form>
");
}

?>


</div>
<?php include("stopka_okno.php"); ?>