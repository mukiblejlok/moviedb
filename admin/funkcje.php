<?php

//poloczenie z baza
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);


function skroc($str,$ile) {
	$count = str_word_count($str);
	if ($count >$ile) 
	{
		$body = explode(" ", $str);
		$reszta = " ";
		$str = $body[0]." ";
	for ($n=1; $n < $ile; $n++) $str .= $body[$n]." ";
	for ($n=$ile; $n < $count; $n++) $reszta.=$body[$n]." ";
	$str .= "<a href=\"#\" id=\"dalej\" title=\"Czytaj ca³o¶æ\" class=\"link\" 
	         style=\"color:#600;\" > ... czytaj dalej</a>";
	}
	$wynik[0]=$str;
	$wynik[1]=$reszta;
	
	return $wynik;
	} 

function tnij($tresc,$ile) {
    if (strlen($tresc)>=$ile)
    {
        $tt = substr($tresc,0,$ile);
        $txt = $tt."...<a href=\"#\" id=\"dalej\" title=\"Czytaj ca³o¶æ\" class=\"link\" >czytaj dalej</a>";
    }
    else  $txt = $tresc;
    return $txt; 
	} 



function wypisz_film($id)
{
//stworzenie zapytania sql
$sql=("SELECT `Tytul` FROM `Filmy`  WHERE `ID_FILM`=".$id);
$wynik=mysql_query($sql) or die(mysql_error());
$film = mysql_fetch_array($wynik, MYSQL_NUM);

//wypisywanie tytu³u i odwolanie sie do funkcji detale_filmu
echo("
<div id=\"lista_top\" onClick=\"detale_filmu(".$id.")\" >
	<span class=\"rozwin_detale\" title=\"Poka¿ szczegó³owe informacje\">".$film[0]."</span>
</div>
<div id=\"detale_film_".$id."\" class=\"detale_filmu\" style=\"display:none; position:relative;\" >
</div>");
}//koniec funkcji wypisz film


function wypisz_film2($id)
{
//stworzenie zapytania sql
$sql=("SELECT `Tytul` FROM `Filmy`  WHERE `ID_FILM`=".$id);
$wynik=mysql_query($sql) or die(mysql_error());
$film = mysql_fetch_array($wynik, MYSQL_NUM);

//wypisywanie tytu³u i odwolanie sie do funkcji detale_filmu
echo("<table cellpadding=0 cellspacing=0><tr><td id=\"lista_top\" style=\"height:17px;width:10px\">
<input name=\"checkbox[]\" type=\"checkbox\" id=\"checkbox[]\" value=\"".$id."\" style=\"width:10px;height:10px\"/ >
</td><td>
<div id=\"lista_top\" onClick=\"detale_filmu(".$id.")\"  style=\"height:20px;\"> 
	<span class=\"rozwin_detale\" title=\"Poka¿ szczegó³owe informacje\">".$film[0]."</span>
</div>
<div id=\"detale_film_".$id."\" class=\"detale_filmu\" style=\"display:none; position:relative;\" >
</div></td></tr></table>");
}//koniec funkcji wypisz film z checkboxem


function wypisz_film_nr($id,$nr)
{
//stworzenie zapytania sql
$sql=("SELECT `Tytul` FROM `Filmy`  WHERE `ID_FILM`=".$id);
$wynik=mysql_query($sql) or die(mysql_error());
$film = mysql_fetch_array($wynik, MYSQL_NUM);

//wypisywanie tytu³u i odwolanie sie do funkcji detale_filmu
echo("<div id=\"lista_top\" onClick=\"detale_filmu(".$id.")\">");
if($nr<10)echo("0".$nr.". ");
else      echo($nr.". ");

echo("<span class=\"rozwin_detale\" title=\"Poka¿ szczegó³owe informacje\">".$film[0]."</span>
</div>
<div id=\"detale_film_".$id."\" class=\"detale_filmu\" style=\"display:none; position:relative;\" >
</div></td></tr></table>");
}//koniec funkcji wypisz film z checkboxem


function wypisz_rezysera($id)
{
//stworzenie zapytania sql
$sql=("SELECT `Rezyserzy`.`Imie`, `Rezyserzy`.`Nazwisko` FROM `Rezyserzy` WHERE `ID_REZ`=".$id);
$wynik=mysql_query($sql) or die(mysql_error());
$rez = mysql_fetch_array($wynik, MYSQL_NUM);

//wypisywanie
echo("
<div id=\"lista_top\" onClick=\"detale_rezyser(".$id.")\">
<span class=\"rozwin_detale\" title=\"Poka¿ szczegó³owe informacje\">".$rez[0]." ".$rez[1]."</span>
</div>
<div id=\"detale_rez_".$id."\" class=\"detale_rezysera\" style=\"display: none; position:relative; \">
</div>");

}//koniec funkcji WYPISZ_REZYSERA


function wypisz_kraj($id)
{
//stworzenie zapytania sql
$sql=("SELECT `Kraje`.`Nazwa` FROM  `Kraje`  WHERE `Kraje`.`ID_KRAJ`=".$id);
$wynik=mysql_query($sql) or die(mysql_error());
$kraj = mysql_fetch_array($wynik, MYSQL_NUM);
//wypisywanie
echo("
<div id=\"lista_top\" onClick=\"detale_kraj(".$id.")\" >
<span class=\"rozwin_detale\" title=\"Poka¿ szczegó³owe informacje\">".$kraj[0]."</span>
</div>
<div id=\"detale_kraj_".$id."\" class=\"detale_kraju\" style=\"display: none; position:relative; \">
</div>
");
}//koniec funkcji WYPISZ_KRAJ


function wypisz_osobe($id)
{
//stworzenie zapytania sql
$sql=("SELECT `Imie`, `Nazwisko` FROM `osoby` WHERE `ID_OSOBA`=".$id);

$wynik=mysql_query($sql) or die(mysql_error());
$osoba = mysql_fetch_array($wynik, MYSQL_NUM);

//wypisywanie
echo("
<div id=\"lista_top\" onClick=\"detale_osoba(".$id.")\">
<span class=\"rozwin_detale\" title=\"Poka¿ szczegó³owe informacje\">".$osoba[0]." ".$osoba[1]."</span>
</div>
<div id=\"detale_osoba_".$id."\" class=\"detale_osoby\" style=\"display: none; position:relative; \">
</div>");
}




////////////////////////////////////////////////
//Funkcja WYPISZ_NEWSA
///////////////////////
function wypisz_newsa($id)
{
//zmienne globalne
global $uprawnienia_edycja,$uprawnienia_kasowanie,$uprawnienia_wlasciciel;

//poloczenie z baza
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////

////wypisanie newsów
$sql=("SELECT `TYTUL`, `TRESC`, DATE_FORMAT(`DATA`, '%H:%i - %e.%m.%y' ), `TYP`, `osoby`.`IMIE`, `osoby`.`NAZWISKO`
	   FROM `Newsy`, `osoby`
	   WHERE `osoby`.`ID_OSOBA`=`Newsy`.`ID_OSOBA`
	   AND `Newsy`.`ID`=".$id."
	   ");
$wynik=mysql_query($sql) or die(mysql_error());
$wiersz=mysql_fetch_array($wynik, MYSQL_NUM) ;

echo("
<div class=\"news\">
<div class=\"news_tytul\">");

//wiadomosc specjalna
if($wiersz[3]==2) echo("<span style=\"color:#600;\"><img src=\"icon/Symbols-Critical-16x16.png\" 
                         title=\"Wa¿na wiadomo¶æ\"> ".$wiersz[0]."</span>");
else echo $wiersz[0];


if($uprawnienia_edycja)
{
	echo (" <span class=\"news_panel\">
	        <a href=\"news_usun.php?id=".$id."\" rel=\"gb_page_center[350, 200]\" title=\"Usuñ newsa\">
	        <img src=\"icon/System-Recycle-Bin-Full-16x16.png\" border=0></a>&nbsp;
			<a href=\"news_dodaj.php?co=edycja&id=".$id."\" rel=\"gb_page_center[350, 250]\" title=\"Edytuj newsa\">
	        <img src=\"icon/Windows-Write-16x16.png\" border=0></a>
			</span>");
}
$podzielony=skroc($wiersz[1], 15);
$aa=trim($podzielony[1]);
if(!empty($aa))
	echo("
	</div><div class=\"news_tresc\">
	".$podzielony[0]."
	<span id=\"cd\" style=\"display:none;\">".$podzielony[1]."</span>
	</div>");

	else echo("
	</div><div class=\"news_tresc\">
	".$wiersz[1]."</div>");


echo("
<div class=\"news_stopka\">".$wiersz[2]."<br />".$wiersz[4]." ".$wiersz[5]."</div>
</div><br /><br />
 ");


}


mysql_close($connect);
//zamkniecie polaczenia z baza

?>

