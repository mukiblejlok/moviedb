<?php
///£±czenie z baz± danych///
	include('param.php');
	$polaczenie=mysql_connect($HOST,$USERNAME,$PASS); 
	mysql_select_db($DB);
/////////////////////////
?>

<form action="szukaj.php?co=okno" name="szukaj_okno" method="post">
<table>
<tr><td class="edycja_osoby_l">
tytu³: 
</td><td class="edycja_osoby_p">
<input type="text" name="tytul" class="d_okno" style="width:170px;"  title="Wpisz szukane wyra¿enie i wci¶nij ENTER"/>

</td></tr>
</table>
</form>
 