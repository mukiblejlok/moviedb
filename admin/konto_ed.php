<br />
<br />
<?php
///////tutaj bedzie update danych
if(isset($_POST['zmiana_param']))
{
	//jezeli ktos wcisn�� zmiane parametr�w to zmieniamy
	$sql=("
	UPDATE `osoby`
	SET 
	`IMIE`=\"".$_POST['imie']."\",
	`NAZWISKO`=\"".$_POST['nazwisko']."\",
	`NR_GG`=\"".$_POST['nr_gg']."\",
	`EMAIL`=\"".$_POST['email']."\"
	WHERE `ID_OSOBA`=".$_SESSION['id_osoba']."
	LIMIT 1;
	");
	//echo $sql;
	$wynik=mysql_query($sql) or die(mysql_error());
 	echo("Informacje o osobie zosta�y zmienione,<br />strona prze�aduje sie za 5 sekund.");
	echo "<head><meta http-equiv=\"Refresh\" content=\"1\" /></head>";
	
}
else if(isset($_POST['zmiana_hasla']))
{
	//jezeli ktos wcisnal zmiane hasla to zmieniamy
    $sql=("SELECT `PASS` FROM `osoby`
	       WHERE `ID_OSOBA`=".$_SESSION['id_osoba']
	     );
	$wynik=mysql_query($sql) or die(mysql_error());
	$stare_pass = mysql_fetch_array($wynik, MYSQL_NUM);
		
	//ale najpierw sprawdzimy czy has�o poprawne
	if(sha1($_POST['stare'])===$stare_pass[0])
		{
		if($_POST['nowe1']==$_POST['nowe2']) 
			{
			$sql=("
				   UPDATE `osoby`
		           SET `PASS`=\"".sha1($_POST['nowe1'])."\" 
		    WHERE `ID_OSOBA`=".$_SESSION['id_osoba']."
		    LIMIT 1;
	        ");
	        //echo $sql;
		    $wynik=mysql_query($sql) or die(mysql_error());
			echo("<br />Has�o zosta�o zmienione,<br /> strona prze�aduje si� za 5 sekund.");
			
			}
		
		}
	else echo("Poda�e� z�e has�o");

echo "<head><meta http-equiv=\"Refresh\" content=\"1\" /></head>";		
}
	

else
{	
	//jezeli nic nie zmieniamy to wchodzimy na zwykl� stron�
	//skoro edycja, to pobierzemy to co nam sie przyda

$sql=("SELECT `IMIE`, `NAZWISKO`, `LOGIN`, `NR_GG`, `EMAIL`
	   FROM `osoby`
	   WHERE `ID_OSOBA`=".$_SESSION['id_osoba']
	   );
$wynik=mysql_query($sql) or die(mysql_error());
$info_osoba = mysql_fetch_array($wynik, MYSQL_NUM);

//Zmiana parametrow
echo("<br /> 
Zmiana parametr�w<hr />
<form method=\"post\" name=\"zmiana_param\" action=\"konto.php?co=2\" >
<table>
<tr><td class=\"edycja_osoby_l\">
Login: 
</td><td class=\"edycja_osoby_p\">
<span style=\"font-size:11px; color:#F22;\" title=\"Wybacz, ale loginu si� nie zmienia\"> ".$info_osoba[2]."</span> 
</td></tr>
<tr><td class=\"edycja_osoby_l\">
imi�: 
</td><td class=\"edycja_osoby_p\">
<input type=\"text\" name=\"imie\" value=\"".$info_osoba[0]."\" class=\"d_okno\"/> 
</td></tr>
<tr><td class=\"edycja_osoby_l\">
nazwisko: 
</td><td class=\"edycja_osoby_p\">
<input type=\"text\" name=\"nazwisko\" value=\"".$info_osoba[1]."\" class=\"d_okno\"/> 
</td></tr>
<tr><td class=\"edycja_osoby_l\">
gg: 
</td><td class=\"edycja_osoby_p\">
<input type=\"text\" name=\"nr_gg\" value=\"".$info_osoba[3]."\" class=\"d_okno\"/> 
</td></tr>
<tr><td class=\"edycja_osoby_l\">
email: 
</td><td class=\"edycja_osoby_p\">
<input type=\"text\" name=\"email\" value=\"".$info_osoba[4]."\" class=\"d_okno\"/> 
</td></tr>
<tr><td class=\"edycja_osoby_l\">
 </td><td class=\"edycja_osoby_p\">
<input type=\"submit\" name=\"zmiana_param\" value=\"zmie�\" class=\"przycisk\"/>
</table>

</form>
");


//Zmiana has�a
echo("<br /> 
Zmiana has�a<hr />
<form method=\"post\" name=\"zmiana_hasla\" action=\"konto.php?co=2\" >
<table>
<tr><td class=\"edycja_osoby_l\">
stare has�o:
</td><td class=\"edycja_osoby_p\">
<input type=\"password\" name=\"stare\" class=\"d_okno\"/> 
</td></tr>
<tr><td class=\"edycja_osoby_l\">
nowe has�o:
</td><td class=\"edycja_osoby_p\">
<input type=\"password\" name=\"nowe1\" class=\"d_okno\" /> 
</td></tr>
<tr><td class=\"edycja_osoby_l\">
powt�rz:
</td><td class=\"edycja_osoby_p\">
<input type=\"password\" name=\"nowe2\" class=\"d_okno\" /><span id=\"nowe_haslo_ok\" style=\"display:none;\">
<img src=\"icon/Symbols-Tips-16x16.png\" border=0>
</span> 
</td></tr>

<tr><td class=\"edycja_osoby_l\">
 </td><td class=\"edycja_osoby_p\">
<input type=\"submit\" name=\"zmiana_hasla\" value=\"zmie�\" class=\"przycisk\"/>
</table>
</form>
");

	   
}//koniec else'a od edycji
?>