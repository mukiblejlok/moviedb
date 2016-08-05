<?php
///£±czenie z baz± danych///
include ('param.php');
$polaczenie=mysql_connect($HOST,$USERNAME,$PASS);
mysql_select_db($DB);
/////////////////////////
//pobranie nr loga z bazy
$sql=("SELECT `LOGO` 
	   FROM `osoby` 
	   WHERE `ID_OSOBA`=".$_SESSION['id_osoba']
	   );
$wynik=mysql_query($sql) or die(mysql_error());
$wiersz = mysql_fetch_array($wynik, MYSQL_NUM);
$zmienny=$wiersz[0];
echo("<link href=\"styl_zmienny".$zmienny.".css\" rel=\"stylesheet\" type=\"text/css\">");
?>



<title>movieDATAbase</title>
</head>
<body>
<div class="glowny_div">

<?php //TUTAJ MAMY NAGLOWEK	  ?>
<div class="top_logowanie">
	
	<a href="index2.php" class="link_naglowek">home</a> |
	<a href="konto.php" class="link_naglowek">moje konto</a> |
	<a href="about.php" class="link_naglowek">about</a> |
	<a href="kontakt.php" title="Napisz do mnie na maila" rel="gb_page_center[350, 250]" class="link_naglowek">kontakt</a> |
	<a href="logout.php" class="link_naglowek">wyloguj</a> | 
	<a href="rss.php"><img width="12" height="12" src="img/rss1.gif" title="Kana³ RSS" border="0" /></a>
	<br />
</div>

<div class="prawie_glowny_div">

<?php //TUTAJ MAMY CA£E LOGO I NAPIS
	  //WSZYSTKO KONFIGUROWALNE Z CSSa
	  ?>
	  
<div class="logo">
	<div class="tekst_logo">
	movie<strong>data</strong>base<br>ver. <?php echo $_SESSION['ver']?><br />
	<span style="font-size:9px;">-puk puk -kto tam? -zaliczenie!</span>
	</div>
</div>


<?php 
//do³aczamy piekne menu
include ("menu.php"); 
?>

<div class="glowne_okno">
	<div class="lewe_okno">

