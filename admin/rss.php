<?php
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS);
mysql_select_db($DB);
/////////////////////////


//pocz±tek kana³u
echo("<?xml version=\"1.0\" encoding=\"iso-8859-2\" ?>
<rss version=\"2.0\">
 <channel>
  <title>movieDATAbase RSS</title>
  <link>http://www.mdb.dl.pl</link>
  <description><![CDATA[Informacje o nowo¶ciach w bazie filmów.]]></description>
  <lastBuildDate>Sat, 20 Dec 2003 21:00:00 GMT</lastBuildDate>
  ");
  
echo("<item>
     <title>Ostatnio dodane filmy</title>
     <link>http://filip.techrom.com.pl/admin/ostatnio.php?co=dod</link>
     <description><![CDATA[
	 ");
$sql=("SELECT `Filmy`.`Tytul`, `Filmy`.`Rok`, `Filmy`.`DATA_UTWORZENIA` 
	   FROM `Filmy`
	   ORDER BY `Filmy`.`DATA_UTWORZENIA` DESC, `Filmy`.`TYTUL`
	   LIMIT 0,5 ");
$rezultat = mysql_query($sql) or die(mysql_error());
while($wiersz = mysql_fetch_array($rezultat, MYSQL_NUM))
{
echo("<b>".$wiersz[0]."</b> - ".$wiersz[1]."<i> (".$wiersz[2].")</i><br />");
}
echo("]]></description></item>");

echo("<item>
     <title>Ostatnio kupione filmy</title>
     <link>http://filip.techrom.com.pl/admin/ostatnio.php?co=kup</link>
     <description><![CDATA[
	 "); 
$sql=("SELECT `Filmy`.`Tytul`, `Filmy`.`Rok`, `Filmy`.`DATA_ZAKUPU` 
	   FROM `Filmy`
	   ORDER BY `Filmy`.`DATA_ZAKUPU` DESC, `Filmy`.`TYTUL`
	   LIMIT 0,5 ");
$rezultat = mysql_query($sql) or die(mysql_error());
while($wiersz = mysql_fetch_array($rezultat, MYSQL_NUM))
{
echo("<b>".$wiersz[0]."</b> - ".$wiersz[1]."<i> (".$wiersz[2].")</i><br />");
}
echo("]]></description></item>");

$sql=("SELECT `TYTUL`, `TRESC` 
	   FROM `Newsy`
	   ORDER BY `DATA` DESC 
	   LIMIT 0,3 ");
$rezultat = mysql_query($sql) or die(mysql_error());
while($wiersz = mysql_fetch_array($rezultat, MYSQL_NUM))
{
echo("<item>
     <title>".$wiersz[0]."</title>
     <link>http://filip.techrom.com.pl/admin/news.php</link>
     <description><![CDATA[
	 ".$wiersz[1]."
	 ]]></description></item>
	 ");
}



echo("</channel></rss>");

?>

