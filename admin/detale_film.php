<?php
ob_start();
session_start();
include("sprawdz_log.php");
header('Content-Type: text/html; charset=iso-8859-2'); 
?>

<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="skrypty_jq.js"></script>

<?php
if(isset($_GET['id'])) $id=$_GET['id'];

//poloczenie z baza
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);


//////////////////////////////
//ewentualne dodanie oceny do bazy
if(!empty($_GET['ocena']))
{
//sprawdzenie czy ju¿ jest jaka¶ ocena
$sql=("SELECT * FROM `Oceny` WHERE `ID_OSOBA`=".$_SESSION['id_osoba']."
       AND `ID_FILM`=".$id."; ");
$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
$czy=mysql_num_rows($wynik);
if($czy>=1)
	{// jest ju¿ taka ocena wiêc j± zamienimy
	$sql=("UPDATE `Oceny`  SET `OCENA` =\"".($_GET['ocena']/10)."\", `DATA`= NOW() 
	       WHERE `ID_OSOBA`=".$_SESSION['id_osoba']." 
		   AND `ID_FILM`=".$id." ");
	$wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
	}	   
else{//nie ma takiej oceny wiec j± dodamy
	  $sql=("INSERT INTO `Oceny` (`ID_OCENA`, `ID_OSOBA`, `ID_FILM`, `OCENA`, `DATA`) 
             VALUES (NULL, ".$_SESSION['id_osoba'].", ".$id.", \"".($_GET['ocena']/10)."\", NOW());
		    ");
      $wynik=mysql_query($sql) or die(mysql_error());  //wykonanie zapytania
    }

}
/////////////////////////////////

//stworzenie zapytania sql
$sql=("SELECT `Filmy`.`Tytul`, `Filmy`.`Rok`, `Kraje`.`Nazwa`, 
	   `Rezyserzy`.`Imie`, `Rezyserzy`.`Nazwisko`, `Nosniki`.`Nazwa`,
	   `Filmy`.`Ilosc_Nosnik`, `Filmy`.`Nr_plyty`,
	   DATE_FORMAT(`Filmy`.`Data_Mod`,'%Y-%c-%d'),
	   DATE_FORMAT(`Filmy`.`Data_Utworzenia`,'%Y-%c-%d'), 
	   `osoby`.`Imie`, `osoby`.`Nazwisko`,`osoby`.`ID_OSOBA`,
	   `Filmy`.`ID_REZ`,`Filmy`.`ID_KRAJ`,`Filmy`.`ID_TYP_NOSNIKA`
	   FROM `Filmy`, `Rezyserzy`, `Kraje`,`Nosniki`, `osoby`
	   WHERE `Filmy`.`ID_REZ`=`Rezyserzy`.`ID_REZ` AND
	         `Filmy`.`ID_KRAJ`=`Kraje`.`ID_KRAJ` AND
			 `Filmy`.`ID_TYP_NOSNIKA`=`Nosniki`.`ID_TYP` AND
			 `Filmy`.`ID_OSOBA`=`osoby`.`ID_OSOBA` AND 
			 `Filmy`.`ID_FILM`=".$id);
//zapytanie
$wynik=mysql_query($sql);
$film = mysql_fetch_array($wynik, MYSQL_NUM);
//sprawdzenie czy film byl ogladany
$sql=("SELECT DATE_FORMAT(`DATA`,'%Y-%c-%d') 
       FROM `Ogladanie` WHERE ID_OSOBA=".$_SESSION['id_osoba']." AND ID_FILM=".$id);
$wynik=mysql_query($sql);
$widziany=mysql_num_rows($wynik);
if($widziany){
	$data_oglodania=mysql_fetch_array($wynik, MYSQL_NUM);
	$data_oglodania=$data_oglodania[0];
}
//sprawdzenie czy film jest oceniony
$sql=("SELECT `OCENA`
       FROM `Oceny` WHERE ID_OSOBA=".$_SESSION['id_osoba']." AND ID_FILM=".$id);
$wynik=mysql_query($sql);
$oceniony=mysql_num_rows($wynik);
if($oceniony){
	$ocena=mysql_fetch_array($wynik, MYSQL_NUM);
	$ocena=$ocena[0];
}

//pobranie sredniej oceny dla filmu
$sql=("SELECT FORMAT(AVG(`OCENA`),2)
       FROM `Oceny` WHERE ID_FILM=".$id);
$wynik=mysql_query($sql);
$oceniony_sr=mysql_num_rows($wynik);
if($oceniony_sr){
	$ocena_sr=mysql_fetch_array($wynik, MYSQL_NUM);
	$ocena_sr=$ocena_sr[0];
}
//pobranie sredniej oceny dla filmu
$sql=("SELECT *
       FROM `Oceny` WHERE ID_FILM=".$id);
$wynik=mysql_query($sql);
$oceniony_sr_ile=mysql_num_rows($wynik);



////OPIS komorek tabeli FILM
// 0. Tytu³ filmu
// 1. Rok produkcji
// 2. Kraj Produkcji
// 3. Imie Re¿ysera
// 4. Nazwisko Re¿ysera
// 5. Rodzaj no¶nika
// 6. Ilo¶æ no¶ników
// 7. Nr p³yty (gdy CD na DVD)
// 8. Data ostatniej modyfikacji
// 9. Data dodania do bazy
//10. Imie osoby ktora go ma
//11. Nazwisko osoby ktora go ma
//12. ID osoby która go ma
//13. ID Re¿ysera
//14. ID Kraj
//15. ID Typ nosnika

////OPIS widziany
// je¿eli widziany=1 to by³ widziany, je¿eli widziany=0 to nie by³ widziany

//zapytanie czy sa chetni na ten film
$sql=("SELECT `Pozyczki`.`ID_OSOBA`,`osoby`.`NAZWISKO`, `osoby`.`IMIE`
	   FROM `Pozyczki`, `osoby`
	   WHERE `Pozyczki`.`ID_OSOBA` = `osoby`.`ID_OSOBA`
	   AND `Pozyczki`.`ID_FILM` = ".$id."
	   ORDER BY `Pozyczki`.`DATA` DESC
	   ");
$wynik_pozyczka=mysql_query($sql);
$liczba_chetnych=mysql_num_rows($wynik_pozyczka);
//Opis pozyczek
//0. ID osoby ktora chce wypozyczyc film
//1. Nazwisko
//2. Imie
/////

//rezyser, kraj, tytul
echo("
<span class=\"detale_rez\">
re¿.<a href=\"pokaz.php?co=rez&id=".$film[13]."\" class=\"detale_link\"
title=\"Poka¿ wszystkie filmy tego re¿ysera\">"
.$film[3]." ".$film[4]."</a><br>
<a href=\"pokaz.php?co=kraj&id=".$film[14]."\" class=\"detale_link\" 
title=\"Poka¿ wszystkie filmy z tego kraju\">"
.$film[2]."</a>, 
<a href=\"pokaz.php?co=rok&id=".$film[1]."\" class=\"detale_link\"
title=\"Poka¿ wszystkie filmy z tego roku\">"
.$film[1]."</a><br>
</span>");

//nosnik
echo("<span class=\"detale_nosnik\">no¶nik:<br>".$film[6]."x ".$film[5]);
if($film[15]==3) echo("<br>(nr p³yty: 
<a href=\"pokaz.php?co=plyta&id=".$film[7]."\" class=\"detale_link\" 
title=\"Poka¿ wszystkie filmy z tej p³yty\">"
.$film[7]."</a>)");

//kupi³em na DVD
if($film[5]!="DVD" && $uprawnienia_wlasciciel)
{
echo("<br><a href=\"kup.php?id=".$id."\" class=\"detale_link\" 
onclick=\"return parent.GB_showCenter('Kup Film', this.href,175,425,reloadParentOnClose)\"
title=\"Zakup filmu na DVD\" >
Kupi³em go!</a>");
}
//stan i wypozyczanie
echo("<br><br>Dostêpno¶æ:");
if($film[12]==1)echo ("<img src=\"icon/Symbols-Tips-16x16.png\" title=\"Dostepny\"><br>");
else if($film[12]==$_SESSION['id_osoba']) echo ("<br />ten film jest u Ciebie<br />");
else 
	{
	echo("<img src=\"icon/Symbols-Error-16x16.png\" title=\"Wypo¿yczony\"><br>");
	if($uprawnienia_wlasciciel)
		echo("ma go:<br><a href=\"oddanie.php?id=".$id."&kto=".$film[12]."\" class=\"detale_link\" 
		      title=\"Film zosta³ oddany\" 
			  onclick=\"return parent.GB_showCenter('Oddany', this.href,300,450,reloadParentOnClose)\">"
			  .$film[10]." ".$film[11]."</a>");
    }
//wypisanie ewentualnych chetnych na film
if($uprawnienia_wlasciciel)
{
if($liczba_chetnych)
	{	
	echo("Chêtni na tej film:<br />");
	while($pozyczka = mysql_fetch_array($wynik_pozyczka, MYSQL_NUM))
	{
		echo("<a href=\"pozycz.php?id=".$id."&komu=".$pozyczka[0]."\" class=\"detale_link\" 
		title=\"Wypo¿ycz tej osobie ten film\" 
		onclick=\"return parent.GB_showCenter('Wypo¿ycz', this.href,300,450,reloadParentOnClose)\">"
		.$pozyczka[2]." ".$pozyczka[1]."</a>");
	}
	}
}
//skoro nie jestes wlasciielem to moze bys chcial wypozyczyæ
//chyba ¿e juz sie po niego zglosi³e¶
$sql=("SELECT * FROM `Pozyczki` WHERE `ID_FILM`=".$id." AND `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$czy=mysql_num_rows($wynik);

if($uprawnienia_wlasciciel==0 && $film[12]==1 && $czy==0)
echo("<a href=\"wypozycz.php?id=".$id."\" title=\"Wypozycz film\" class=\"detale_link\" 
onclick=\"return parent.GB_showCenter('Wypo¿ycz Film', this.href,300,450)\">wypo¿ycz go</a>");

if($uprawnienia_wlasciciel==0 && $film[12]==1 && $czy==1)
echo("<a href=\"wypozycz.php?id=".$id."&co=rezygnuj\" title=\"Zrezygnuj z filmu\" class=\"detale_link\" 
onclick=\"return parent.GB_showCenter('Zrezygnuj', this.href,350,450,reloadParentOnClose)\">zrezygnuj</a>");

/////
echo ("</span>");

//ogladany
echo("<br><span class=\"detale_ogladany\">Widziany: ");
if($widziany) echo("<img src=\"icon/Symbols-Tips-16x16.png\" title=\"Widziales ten film "
.$data_oglodania."\">");
else echo("<img src=\"icon/Symbols-Error-16x16.png\" title=\"Nie widzia³e¶ tego filmu\"><br>
<a href=\"ogladanie.php?id=".$id."\" class=\"detale_link\" 
onclick=\"return parent.GB_showCenter('Ogl±danie', this.href,200,425,reloadParentOnClose)\"
title=\"Dodaj ten film do obejrzanych\">Obejrza³em go!</a><br />");


//ocena
if($widziany)
{
	echo("<br />Twoja ocena: ");
	if($oceniony) echo("<span style=\"cursor:pointer;font-weight:bold;font-size:14px;\" 
	                     title=\"Twoja ocena, kliknij aby j± zmieniæ\"
	                    onClick=\"pokaz_oceny(".$id.");\" id=\"twoja_ocena_".$id."\">".$ocena."</span>");
    else 
	{
		echo("<span style=\"cursor:pointer;font-weight:bold;font-size:14px;\" 
	                     title=\"Twoja ocena, kliknij aby j± zmieniæ\"
	                    onClick=\"pokaz_oceny(".$id.");\" id=\"twoja_ocena_".$id."\">brak</span>");
	} 
	echo("<div id=\"detale_oceny_".$id."\" style=\"display:none;height:12px;\" >
	      <div style=\"background-color:black; height:12px; width:1px;float:left; 
			   border-bottom: thin solid black;border-top: thin solid black;  \"></div>");
	//skala ocen
	$skala=100;
	
	for($i=1;$i<=$skala;$i++)
	{
		echo("<div  
		       onMouseOver=\"podswietl_ocena(".$i.",".$id.",".$skala.")\" 
			   onMouseOut=\"skasuj_podswietlenie(".$i.",".$id.",".$skala.")\"
			   id=\"link_ocena_".$i."_film_".$id."\"
			   class=\"link_oceny\" title=\"".($i/10)."\"
			   onclick=\"return parent.detale_filmu_ocena(".$id.",".$i.")\"
			   style=\"background-color:white; height:12px; width:2px;float:left; 
			   z-index:10; border-bottom: thin solid black;
			   border-top: thin solid black;  \"></div>");
	}	
	echo("<div style=\"background-color:black; height:12px; width:1px;float:left; 
			   border-bottom: thin solid black;border-top: thin solid black;  \"></div>
	<div style=\"font-size:9px;clear:both;\">");
	for($i=0;$i<10;$i++) echo($i."&nbsp;&nbsp;&nbsp;&nbsp;");
	echo("10</div></div>");
	
} 
if($ocena_sr!=0) echo("<span title=\"¦rednia z ".$oceniony_sr_ile." g³osów\" 
                       style=\"cursor:pointer\" id=\"sr_ocena_".$id."\" ><br />¶r. ocena: ".$ocena_sr."</span>");


echo("</span>");



//daty
echo("<br /><br /><span class=\"detale_dodano\">Dodano: ".$film[9]);
if($film[9]!=$film[8]) echo("<br>Modyfikacja: ".$film[8]);
echo("</span>");


//panel administratora
echo("<span class=\"panel_admina\">");

if($uprawnienia_edycja)
{
echo("
<a href=\"edytuj.php?co=film&id=".$id."\" onclick=\"return parent.GB_showCenter('Edycja', this.href,300,425,reloadParentOnClose)\"
title=\"Edycja filmu\">
<img src=\"icon/Windows-Write-32x32.png\" border=0></a><br>
");
}
if($uprawnienia_kasowanie)
{
echo("
<a href=\"usun.php?co=film&id=".$id."\" onclick=\"return parent.GB_showCenter('Kasowanie', this.href,200,425,reloadParentOnClose)\"
title=\"Usuñ film\">
<img src=\"icon/System-Recycle-Bin-Full-32x32.png\" border=0></a><br>");
}

//mega detale beta
if($uprawnienia_wlasciciel)
{
echo("<br><a href=\"mega_detale.php?id=".$id."\" class=\"detale_link\" 
onclick=\"return parent.GB_showCenter('Mega Detale', this.href,600,700)\"
title=\"Zakup filmu na DVD\" >
MD</a>");
}

//szukanie na filmwebie
echo("
<a href=\"http://www.filmweb.pl/szukaj?q=".$film[0]."&c=film\"    
title=\"Szukaj w FilmWebie\" class=\"detale_link2\" 
onclick=\"return GB_showCenter('Filmweb', this.href,500,850)\" >
<img src=\"icon/filmweb_logo.jpg\" border=0></a>");
 
echo("</span>");
//koniec wypisywania
mysql_close($connect);
//zamkniecie polaczenia z baza

?>