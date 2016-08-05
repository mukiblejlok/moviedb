<?php
if($_SESSION['stan_logowania']!=sha1("poprawnie_zalogowany"))
{
header("Location: http://filip.techrom.com.pl/admin/logout.php");
}
else
{
//nadanie uprawnien
//wlasnosc
if($_SESSION['uprawnienia_wlasciciel'] === sha1("pan_wlasciciel")) $uprawnienia_wlasciciel=1;
//edycja
if($_SESSION['uprawnienia_edycja'] === sha1("pan_edytor")) $uprawnienia_edycja=1;
//kasowanie
if($_SESSION['uprawnienia_kasowanie'] === sha1("pan_kasownik")) $uprawnienia_kasowanie=1;
}
?>  