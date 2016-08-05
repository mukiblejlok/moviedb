
<br />
<br />
<p>Wybór obrazka<hr />

<?php
////je¿eli formularz przys³a³ logo to zmieniamy
if(isset($_POST['logo']))
{
$sql=("UPDATE `osoby` 
       SET `LOGO`=".$_POST['logo']." 
		WHERE `ID_OSOBA` =".$_SESSION['id_osoba']." 
		LIMIT 1 ;
	  ");
$wynik=mysql_query($sql) or die(mysql_error());
//odswiezenie dla natychmiastowego efektu
echo "<head><meta http-equiv=\"Refresh\" content=\"1\" /></head>";
}


/////////////zmiana loga
$ile=5; //liczba dostepnych log

//pobranie aktualnej warto¶ci
$sql=("SELECT `LOGO` 
	   FROM `osoby` 
	   WHERE `ID_OSOBA`=".$_SESSION['id_osoba']
	   );
$wynik=mysql_query($sql) or die(mysql_error());
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM);
$aktualne_logo=$wiersz[0];
?>	   

<form method="post" action="konto.php?co=1">
<?php
$nazwy[0]='Inaczej ni¿ w raju';
$nazwy[1]='Siedmiu Samurajów';
$nazwy[2]='Psychoza';
$nazwy[3]='Siedem';
$nazwy[4]='Amator';


for($i=1;$i<=$ile;$i++)
{
if($aktualne_logo==$i) echo ("<br /> <input type=\"radio\" name=\"logo\" value=".$i."  checked=\"checked\" /> ".$nazwy[$i-1]);
else echo ("<br /> <input type=\"radio\" name=\"logo\" value=".$i."  /> ".$nazwy[$i-1]);
}
?>
<br /><br />

<input type="submit" name="submit" value="zmieñ" class="przycisk"/>
</form>
</p>
