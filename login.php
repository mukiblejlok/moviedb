<?php
echo ("
<form action=\" ".getenv(REQUEST_URI)." \" method=\"POST\">
<br>Podaj login: <input name=\"login\" type=\"text\" />
<br>Podaj has�o: <input name=\"pass\" type=\"password\" />
<br><input type=\"submit\" name=\"stan_logowania\" value=\"Logowanie\" />
</form>
");
?>