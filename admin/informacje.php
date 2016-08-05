<?php
///£±czenie z baz± danych///
	include('param.php');
	$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
	mysql_select_db($DB);
/////////////////////////

//ilosc logowan osoby
$sql=("SELECT COUNT(*) FROM `logowania` 
       WHERE `ID_OSOBA`=".$_SESSION['id_osoba']);
$wynik=mysql_query($sql) or die(mysql_error());
$ile_log=mysql_fetch_array($wynik, MYSQL_NUM);
$ile_log=$ile_log[0];

//ilosc wszystkich logowan
$sql=("SELECT COUNT(*) FROM `logowania` 
       WHERE 1 ");
$wynik=mysql_query($sql) or die(mysql_error());
$ile_log_w=mysql_fetch_array($wynik, MYSQL_NUM);
$ile_log_w=$ile_log_w[0];

//ilosc osob
$sql=("SELECT COUNT(*) FROM `osoby` 
       WHERE  1 ");
$wynik=mysql_query($sql) or die(mysql_error());
$ile_osob=mysql_fetch_array($wynik, MYSQL_NUM);
$ile_osob=$ile_osob[0];


//data ostaniego logowania
$sql=("SELECT DATE_FORMAT(`DATA`, '%d.%m.%Y') FROM `logowania` 
       WHERE `ID_OSOBA`=".$_SESSION['id_osoba']."
	   ORDER BY `DATA` DESC;");
$wynik=mysql_query($sql) or die(mysql_error());
$ost=mysql_fetch_array($wynik, MYSQL_NUM);
$ostatni_raz=$ost[0];

//login osoby
$sql=("SELECT `LOGIN` FROM `osoby`
       WHERE `ID_OSOBA`=".$_SESSION['id_osoba']
	   );
$wynik=mysql_query($sql) or die(mysql_error());
$login=mysql_fetch_array($wynik, MYSQL_NUM);
$login=$login[0];

//zapytania do bazy
//troche statystyk

//liczba filmow w bazie
$sql=("SELECT COUNT(*) FROM `Filmy`");
$wynik=mysql_query($sql);
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM);
$liczba_filmow=$wiersz[0];
	 
//liczba widzianych filmow
$sql=("SELECT COUNT(*)
	   FROM `Filmy` 
	   LEFT JOIN `Ogladanie` 
	   ON (`Ogladanie`.`ID_FILM` = `Filmy`.`ID_FILM` 
	   AND `Ogladanie`.`ID_OSOBA`=".$_SESSION['id_osoba'].")
	   WHERE (`Ogladanie`.`ID_OSOBA` <>".$_SESSION['id_osoba']." 
	        OR `Ogladanie`.`ID_OSOBA` IS NULL) "
		);
$wynik=mysql_query($sql);
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM);
$liczba_niewidzianych_filmow=$wiersz[0];

//kogo witam
$sql=("SELECT `IMIE`, `NAZWISKO` 
       FROM `osoby`
	   WHERE `ID_OSOBA`=".$_SESSION['id_osoba']
	   );
$wynik=mysql_query($sql);
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM);
$kto_imie=$wiersz[0];
$kto_nazwisko=$wiersz[1];

	   
?>

<?php
echo("
Jeste¶ zalogowany jako <span style=\"color:#993131\">".$kto_imie." ".$kto_nazwisko."</span> <br /><br />
Widzia³e¶ ju¿ <span style=\"color:#993131\"> ".($liczba_filmow - $liczba_niewidzianych_filmow).
"</span> filmów <br />
z <span style=\"color:#993131\"> ".$liczba_filmow."</span> filmów, które s± w bazie<br />
zosta³o Ci jeszcze tylko:<span style=\"color:#993131\"> ".$liczba_niewidzianych_filmow.
"</span><br /><br />
"); ?>

Twój numer IP: <?php echo $REMOTE_ADDR ?><br />
Ostatnio logowa³e¶ siê dnia: <?php echo $ostatni_raz ?> <br />
£±cznie zalogowa³e¶ siê <?php echo $ile_log ?> razy.<br /><br />
Ca³kowita liczba odwiedzin bazy to: <?php echo $ile_log_w ?><br />
wygenerowana przez <?php echo $ile_osob ?> u¿ytkowników.

