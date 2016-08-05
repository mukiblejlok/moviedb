<?php 
ob_start();
session_start();
include('zmienne.php');
include('funkcje.php');

echo("
<?xml version=\"1.0\" encoding=\"iso-8859-2\"?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"
   \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"pl\">
<head>
");
?>

<meta http-equiv="content-type" content="text/html; charset=iso-8859-2">
<meta name="keywords" content="filip, lista, filmów">
<script type="text/javascript">
    var GB_ROOT_DIR = "http://fmularczyk.hekko24.pl/moviedb/admin/greybox/";
</script>
<script type="text/javascript" src="greybox/AJS.js"></script>
<script type="text/javascript" src="greybox/AJS_fx.js"></script>
<script type="text/javascript" src="greybox/gb_scripts.js"></script>
<script type="text/javascript" src="skrypty.js"></script>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="skrypty_jq.js"></script>


