<?php 
ob_start();
session_start(); // poczatek sesji
$_SESSION['ver']=0.9; //wersja strony
?>

<?php
//sprawdzenie czy istnieje w $_POST zmienna stan_logowania
if(isset($_POST['stan_logowania'])) 
{
	///£±czenie z baz± danych///
	include('param.php');
	$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
	mysql_select_db($DB);
	/////////////////////////
//je¶li tak to wykonujemy wyszukanie w bazie istot z takim has³em
	$sql=("SELECT `LOGIN`, `ID_OSOBA`,
		  `UPR_EDYCJA`, `UPR_KASOWANIE`, `UPR_WLASNOSC`	  
	       FROM `osoby` 
           WHERE `LOGIN`=\"".mysql_real_escape_string($_POST['login'])."\"
           AND `PASS`=\"".sha1(mysql_real_escape_string($_POST['pass']))."\";
		  ");
$wynik=mysql_query($sql);
////opis parametrów logowania
//0. Login
//1. ID Osoby
//2. Czy moze edytowaæ ?
//3. Czy moze kasowaæ ?
//4. Czy jest wlascicielem ? 

//i sprawdzamy ile otrzymamy wyników
// je¶li istnieje osoba z takim loginem i haslem to powinien byæ
// TYLKO JEDEN wpis w bazie
	$liczba_rekordow=mysql_num_rows($wynik);
	$parametry_log=mysql_fetch_array($wynik, MYSQL_NUM);
	if($liczba_rekordow==1 && $parametry_log[0]==$_POST['login'])
	{
	//ustawienie zmiennej sesyjnej 
	//logowanie ok
	$_SESSION['login']=$parametry_log[0];
	$_SESSION['id_osoba']=$parametry_log[1];
	$_SESSION['stan_logowania'] = sha1("poprawnie_zalogowany");
//ustalanie przywilejow

//wlasnosc
if($parametry_log[4]==1) $_SESSION['uprawnienia_wlasciciel'] = sha1("pan_wlasciciel");
//edycja
if($parametry_log[2]==1) $_SESSION['uprawnienia_edycja'] = sha1("pan_edytor");
//kasowanie
if($parametry_log[3]==1) $_SESSION['uprawnienia_kasowanie'] = sha1("pan_kasownik");

//dodanie logowania do tablicy logowan
$sql=("INSERT INTO `logowania` 
       (`ID_LOG`, `ID_OSOBA`, `DATA`, `IP`) 
	   VALUES (NULL, ".$_SESSION['id_osoba'].", NOW(), 
	   \"".$REMOTE_ADDR."\");");
$wykonaj=mysql_query($sql) or die(mysql_error());	  
    }
	
	else header("Location: ".$PHP_SELF."?log=zle");

//pozbycie sie zmiennej otrzymanej z formularza	
unset($_POST['stan_logowania']);
unset($_POST['login']);
unset($_POST['pass']);

////koniec polaczenia
mysql_close($polaczenie);
/////////////////

//echo("<span id=\"error\">stan logowania: ".$_SESSION['stan_logowania']."</span>");

//przekierowanie do odpowiedniej podstrony
//gdy zalogowal sie admin
if($_SESSION['stan_logowania'] === sha1("poprawnie_zalogowany"))
{
    //otwarcie strony index2.php
	header("Location: http://".$_SERVER['SERVER_NAME']."/moviedb/admin/index2.php");
}
//gdy zalogowal sie gosc
elseif($_SESSION['stan_logowania'] === sha1("poprawnie_zalogowany_gosc"))
{
	header("Location: http://".$_SERVER['SERVER_NAME']."/moviedb/user/index2.php"); 
}


}//koniec dzialania gdy wyslany jest formularz
?>


<!--czesc htmlowa-->
<html>
<head>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
<meta name="keywords" content="filip, lista, filmów">
<link rel="Stylesheet" type="text/css" href="istyl.css">
<script type="text/javascript" src="admin/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
    var GB_ROOT_DIR = "http://filip.techrom.com.pl/admin/greybox/";
</script>
<script type="text/javascript" src="admin/greybox/AJS.js"></script>
<script type="text/javascript" src="admin/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="admin/greybox/gb_scripts.js"></script>
<link href="admin/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
<title>movieDATAbase</title>
</head>
<body onLoad="document.f.login.focus()">
<div id="header">author: FM </div>

<div id="content">
<table id="table" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td id="tab_top">

<!--pasek logowania-->
<form action=index.php method="POST" name="f">
login: <input name="login" type="text" size=10 tabindex=1 class="tekstowy">
pass: <input name="pass" type="password" size=10 tabindex=2 class="tekstowy">
&nbsp;
<input type="hidden" name="stan_logowania" value=1>
<input type="submit" name="loguj" value="OK" class="sub">

<?php

////
///informacja o wylogowaniu lub byciu niezalogowanym
if(isset($_GET['log']) && $_GET['log']=="error")
	echo ("<span id=\"error\">Nie jeste¶ zalogowany! Zaloguj siê.</span>"); 
if(isset($_GET['log']) && $_GET['log']=="adm")
	echo ("<span id=\"error\">Wylogowa³e¶ siê poprawnie. Mo¿esz zalogowaæ siê ponownie.</span>"); 
if(isset($_GET['log']) && $_GET['log']=="usr")
	echo ("<span id=\"error\">Wylogowa³e¶ siê poprawnie. Mo¿esz zalogowaæ siê ponownie.</span>");
if(isset($_GET['log']) && $_GET['log']=="zle")
{
	echo ("<span id=\"error\">Z³y login lub has³o. ");
    if(!(isset($_SESSION['licz']))) $_SESSION['licz']=0;
		$_SESSION['licz']=$_SESSION['licz']+1;
		if($_SESSION['licz'] >= 3) 
		{
		echo("<a href=\"przypomnij_haslo.php\" style=\"color:#600;\"
		onClick=\"return parent.GB_showCenter('Generowanie nowego has³a', this.href,175,425);\"> 
		Zapomnia³e¶ has³a?</a>");
		$_SESSION['licz']=0; 
		}
	echo("</span>");
}


?>


</form>
</td></tr>

<tr><td id="tab_main"><img src="img/main_img.jpg" width="842" height="333" alt="movieDATAbase"></td></tr>

<tr><td id="tab_bottom">movie<b>data</b>base | ver.
<?php echo $_SESSION['ver']; ?>
</td></tr>
</table>

</div>
</body>
</html>
<?php //ob_flush(); ?>
