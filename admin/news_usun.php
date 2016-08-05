<?php include("naglowek_okno.php");?>
<?php include("sprawdz_log.php"); ?> 
<body style="background-color:#DDDDDD;">
<div style="text-align: center;">

<?php 
///£±czenie z baz± danych///
include ('param.php'); //parametry polaczenia z baz±
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

///////////////////////////////////////////////////////////////////////
//USUWANIE FILMU
if(isset($_GET['id']))$id = $_GET['id']; 

//DECYZJA PODJETA
//nie usuwamy
if(isset($_GET['napewno']) && $_GET['napewno']=="nie")
{
echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0>
<br>News nie zosta³ usuniêty.<br><br>
Mo¿esz zamknaæ okno</div>");
}
//DECYZJA PODJETA
//usuwamy
else if(isset($_GET['napewno']) && $_GET['napewno']=="tak")
{

$sql=("DELETE FROM `Newsy` 
	   WHERE `Newsy`.`ID` =".$id." 
	   LIMIT 1
	   ");
$wynik=mysql_query($sql);  //wykonanie zapytania
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM); //odczyt zapytania

echo ("
<div id=\"okno_pytanie\"><br>
<img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0>
<br>News zosta³ usuniêty!!!<br>
Mo¿esz zamknaæ okno</div>");
}


//DECYZJA NIEPODJETA
else
{
echo("<br /> <br /><div id=\"okno_pytanie\">Czy napewno chcesz usun±æ tego newsa?</div>");

//odpowiedz na pytanie
echo("<br /><div id=\"okno_pytanie\">
<a href=\"news_usun.php?id=".$id."&napewno=tak\" class=\"detale_link\">
TAK <img src=\"icon/Symbols-Tips-32x32.png\" title=\"TAK\" border=0></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"news_usun.php?id=".$id."&napewno=nie\" class=\"detale_link\">
<img src=\"icon/Symbols-Error-32x32.png\" title=\"NIE\" border=0> NIE</a>
</div>
");
}


/////////////////////////////////
//KONIEC USUWANIA NEWSA


?>


</div>
<?php include("stopka_okno.php"); ?>