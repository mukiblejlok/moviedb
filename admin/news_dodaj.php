<?php include("naglowek_okno.php");?>
<?php include("sprawdz_log.php"); ?> 
<body style="background-color:#DDDDDD;">
<div style="text-align:center">
<?php
if($uprawnienia_edycja)
{


if($_GET['co']=="dodaj" && !empty($_POST['tytul']) && !empty($_POST['tresc']) && !empty($_POST['typ']))
{
//dodawanie newsa do bazy

///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

if(isset($_GET['idn']))
{
$sql=("UPDATE `Newsy` SET 
	   `TYTUL`=\"".mysql_escape_string($_POST['tytul'])."\",
	   `TRESC`=\"".mysql_escape_string($_POST['tresc'])."\",
	   `TYP`=\"".$_POST['typ']."\",
	   `ID_OSOBA`=".$_SESSION['id_osoba']."
	   WHERE ID=".$_GET['idn']."
	  ");
}
else
{
$sql=("INSERT INTO `Newsy` 
	   (`ID`,`ID_OSOBA`,`TYTUL`,`TRESC`,`DATA`,`TYP`)
	   VALUES (NULL, ".$_SESSION['id_osoba'].", \"".$_POST['tytul']."\", \"".$_POST['tresc']."\",  NOW(), ".$_POST['typ'].")
	   ");
}
//echo $sql;
$wynik=mysql_query($sql) or die(mysql_error());
echo("
<div id=\"okno_pytanie\"><br>
<a href=\"#\" onClick=\"return parent.parent.GB_hide();\">
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
<br>News zosta³ dodany!<br>
Mo¿esz zamknaæ okno</div>");

}

else if($_GET['co']=="edycja" && isset($_GET['id']))
{
//edycja newsa
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////
$sql=("SELECT `TYTUL`, `TRESC`
	   FROM `Newsy`
	   WHERE `Newsy`.`ID`=".$id." 
	   ");
$wynik=mysql_query($sql) or die(mysql_error());
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo("
<form method=\"post\" name=\"dodaj_newsa\" action=\"news_dodaj.php?co=dodaj&idn=".$id."\" >
<table>
<tr><td class=\"news_dodaj_l\">
tytu³: 
</td><td class=\"news_dodaj_p\">
<input type=\"text\" name=\"tytul\" class=\"d_okno\" style=\"width:200px;\" value=\"".$wiersz[0]."\"/>
</td></tr>

<tr><td class=\"news_dodaj_l\">
tre¶æ: 
</td><td class=\"news_dodaj_p\">
<textarea name=\"tresc\" cols=40 rows=10 class=\"d_okno\">".$wiersz[1]."</textarea>
</td></tr>

<tr><td class=\"news_dodaj_l\">
typ: 
</td><td class=\"news_dodaj_p\">
<input type=\"radio\" name=\"typ\" value=\"1\" checked=\"checked\" />Zwyk³a
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"submit\" name=\"zmiana_param\" value=\"dodaj\" class=\"przycisk\"/>
<br />
<input type=\"radio\" name=\"typ\" value=\"2\" /><span style=\"color:#F22;\">Wa¿na</span>
</td></tr>
</table>
</form>
");

}

else
{
//formularz do wpisywania newsa
echo("
<form method=\"post\" name=\"dodaj_newsa\" action=\"news_dodaj.php?co=dodaj\" >
<table>
<tr><td class=\"news_dodaj_l\">
tytu³: 
</td><td class=\"news_dodaj_p\">
<input type=\"text\" name=\"tytul\" class=\"d_okno\" style=\"width:200px;\"/>
</td></tr>

<tr><td class=\"news_dodaj_l\">
tre¶æ: 
</td><td class=\"news_dodaj_p\">
<textarea name=\"tresc\" cols=40 rows=10 class=\"d_okno\"></textarea>
</td></tr>

<tr><td class=\"news_dodaj_l\">
typ: 
</td><td class=\"news_dodaj_p\">
<input type=\"radio\" name=\"typ\" value=\"1\" checked=\"checked\" />Zwyk³a
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"submit\" name=\"zmiana_param\" value=\"dodaj\" class=\"przycisk\"/>
<br />
<input type=\"radio\" name=\"typ\" value=\"2\" /><span style=\"color:#F22;\">Wa¿na</span>
</td></tr>
</table>
</form>
");
}

}//uprawnienia edycja
else echo "nie mo¿esz";

?>
</div>
<?php include("stopka_okno.php"); ?>