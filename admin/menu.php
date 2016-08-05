<div class="menu">
<ul>
<li><a href="index2.php">Home</a></li>

<li><a href="#">Listy</a>
<ul>
<?php 
echo(" 
  <li><a href=\"lista_film.php?co=all\">Filmy</a></li>
  <li><a href=\"lista_rez.php\">Re¿yserzy</a></li>
  <li><a href=\"lista_kraj.php\">Kraje</a></li>
");
if($uprawnienia_wlasciciel)
echo("  
  <li><a href=\"lista_osob.php\">Osoby</a></li>
");
?>  
</ul></li>
<?php 
if($uprawnienia_wlasciciel)
echo(" 
<li><a href=\"#\">Dodaj</a>
<ul>
  <li><a href=\"dodaj_film.php\" title=\"Dodaj film\" rel=\"gb_page_center[450, 220]\">Film</a></li>
  <li><a href=\"dodaj_rezysera.php\" title=\"Dodaj re¿ysera\" 
  rel=\"gb_page_center[450, 180]\">Re¿ysera</a></li>
  <li><a href=\"dodaj_kraj.php\" title=\"Dodaj kraj\" rel=\"gb_page_center[450, 120]\">Kraj</a></li>
  <li><a href=\"dodaj_osobe.php\" title=\"Dodaj osobê\" rel=\"gb_page_center[450, 300]\">Osobê</a></li>
</ul></li>
");
?>
<li><a href="szukaj.php?co=film">Szukaj</a><ul></ul></li>

<li><a href="#">Ostatnio</a>
<ul>
  <li><a href="ostatnio.php?co=dod">Dodane</a></li>
<?php 
if($uprawnienia_wlasciciel)
echo("<li><a href=\"ostatnio.php?co=mod\">Modyfikowane</a></li>");
?>
  <li><a href="ostatnio.php?co=kup">Kupione</a></li>
  <li><a href="ostatnio.php?co=wid">Widziane</a></li>
  </ul></li>

<li><a href="#">Wypo¿yczanie</a>
<ul>
<?php 
if($uprawnienia_wlasciciel)
echo("<li><a href=\"wyp_zgloszenia.php\">Zg³oszenia</a></li>
  <li><a href=\"wyp_wypozyczone.php\">Wypo¿yczone</a></li>
");
else echo("<li><a href=\"konto.php?co=3\">Aktualne</a></li>
  <li><a href=\"konto.php?co=4\">Historia</a></li>
");

?>  
  </ul></li>

<li><a href="news.php">Newsy</a>
<?php

if($uprawnienia_edycja)
echo("  
  <ul>
  <li><a href=\"news_dodaj.php\" title=\"Dodaj newsa\" 
  onclick=\"return parent.GB_showCenter('Dodaj newsa', this.href,250,350,reloadParentOnClose)\">Dodaj</a></li>
  </ul>");

?>  
  
  </li>


<li><a href="#">Statystyki</a>
<ul>
  <li><a href="stat_top5.php">Top5</a></li>
  <li><a href="oceny.php?co=all&kto=sr">Oceny</a></li>
  </ul></li>

<?php 
if($uprawnienia_wlasciciel)
echo("<li><a href=\"#\">Inne</a>
<ul>
  <li><a href=\"cd_dvd.php\">Nowe p³yty</a></li>
  <li><a href=\"testy.php\">Testy</a></li>
  <li><a href=\"szybkie_ogladanie.php\">Szybkie ogl±danie</a></li>
  </ul></li>  
");
else
echo("<li><a href=\"#\">Inne</a>
<ul>
  <li><a href=\"szybkie_ogladanie.php\">Szybkie ogl±danie</a></li>
  </ul></li>  
");


?> 
</ul>
&nbsp;
</div>
