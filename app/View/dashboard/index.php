Your are logged in
<?php echo $data->user->alias ?>!<br/>
<a href="blog/createform">Skapa blogg</a>
<br/>
<a href="settings">Hantera bloggar</a><!-- vart ska den ligga? Hantera; ta bort, ändra namn etc. !-->
<br/>
<a href="../account/index">Kontoinställningar</a>
<form action="/logout" method="post">
    <input type="submit" name="Loggout" value="logga ut">
</form>
