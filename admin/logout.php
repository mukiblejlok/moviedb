<?php
//sprawdzenie czy uzytkownik byl zalogowany
session_start();
 
if($_SESSION['stan_logowania']===sha1("poprawnie_zalogowany")) {
	unset($_SESSION['stan_logowania']);
	unset($_SESSION['uprawnienia_wlasciciel']);
	unset($_SESSION['uprawnienia_edycja']);
	unset($_SESSION['uprawnienia_kasowanie']);
	session_destroy();
	header("Location: http://".$SERVER_NAME."/index.php?log=adm");
	}

elseif($_SESSION['stan_logowania']===sha1("poprawnie_zalogowany_gosc")) {
	unset($_SESSION['stan_logowania']);
	session_destroy();
	header("Location: http://".$SERVER_NAME."/index.php?log=usr");
	}

else{
	session_destroy(); 
	header("Location: http://".$SERVER_NAME."/index.php?log=error");
	}
?>