<div style="font-family:Verdana; font-size:12px; text-align:center;">
<br />
Je�eli zapomnia�e� has�a <br />
to wpisz poni�ej sw�j adres mail,<br />
na kt�ry zostanie wys�ane nowe has�o:<br />
<br />
<form method="post" action="przypomnij_haslo.php?co=spr" name="form">
<input type="text" name="mail" style="background-color:#EEE; border-style:none;" 
title="wpisz sw�j adres i wci�nij ENTER"/>
</form>

<?php
if($_GET['co']=="spr")
{
//sprawdzamy czy jest taki adres

///��czenie z baz� danych///
include('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
mysql_select_db($DB);
/////////////////////////

//je�li tak to wykonujemy wyszukanie w bazie istot z takim has�em
$sql=("SELECT `EMAIL`, `IMIE`, `LOGIN`	  
       FROM `osoby` 
       WHERE `EMAIL`=\"".mysql_real_escape_string($_POST['mail'])."\" 
	   ");
//echo $sql;
$wynik=mysql_query($sql) or die(mysql_error());
$liczba_rekordow=mysql_num_rows($wynik);
$wiersz=mysql_fetch_array($wynik, MYSQL_NUM);



	if($liczba_rekordow==1){
	
	
//generowanie hasla
$haslo=substr(md5(time()), 0, 10);
$sql=("UPDATE `osoby` SET `PASS`=\"".sha1($haslo)."\" WHERE `EMAIL`=\"".mysql_real_escape_string($_POST['mail'])."\" ");
$wynik=mysql_query($sql) or die(mysql_error());
// $haslo=mysql_fetch_array($wynik, MYSQL_NUM);	   

		$content = ("__To jest wiadomo�� tworzona automatycznie nie odpowiadaj na ni�__________
\n\nAdministrator strony movieDATAbase wysy�a Ci twoje nowe has�o dost�powe do strony filip.techrom.com.pl .
Pewnie go o nie prosi�e�, a je�eli nie to po prostu skasuj t� wiadomo��.
\n\noto Twoje nowe has�o: ".$haslo."\nnie zapomnij zmieni� go na jakie� bardziej przyst�pne po zalogowaniu.
\nMi�ego korzystania z movieDATAbase
\nPozdrawiam,\nFilip 
");
		//wysylanie
    	$adresat = $wiersz[0]; 	
		$header = 	"From: baza@filip.techrom.com.pl \nContent-Type:".
			' text/plain;charset="iso-8859-2"'.
			"\nContent-Transfer-Encoding: 8bit";
		if(mail($adresat, 'movieDATAbase - nowe has�o', $content, $header))
	
		echo($wiersz[1].", w�a�nie wys�a�em Ci na maila<br />nowe has�o");
	}
	else{
	echo("nie ma w bazie u�ytkownika o takim adresie,<br />
          albo si� pomyli�e�, albo po prostu nie masz tu konta");
	}
}
?>

</div>