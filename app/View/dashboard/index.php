<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<div class="wrapper">
You are logged in
<?php echo $data->user->alias ?>!
<a href="blog/settings">Hantera bloggar</a><!-- vart ska den ligga? Hantera; ta bort, ändra namn etc. !-->

<a href="../account/index">Kontoinställningar</a>
<form action="/logout" method="post">
    <input type="submit" name="Loggout" value="logga ut">
</form>
<h3>Välj blogg</h3>
<form action="/dashboard/index" method="post">
	Bloggnamn:<select>
		 
		<!-- Här ska en dropdown-lista på bloggar du äger - Den fungerar inte just nu, någon får gärna ta över !-->
		<option value='chooseBlog'><?php $blogName; ?></option>
		
	
	</select>
	
	<input type="submit" value="Välj">

</form>


<h4>Skapa blog</h4>
<form id="createBlog" action="/blog/create" method="post" enctype="multipart/form-data">
    Bloggnamn: </br><input type="text" name="blogname" required> </br>
    URL: </br><input type="text" name="urlname" required></br>
    Taggar:</br><input type="text" name="tags"></br>
    NSFW: <input type="checkbox" name="nsfw" value="1"/></br>
    <input type="submit" name="submitblog" value="Skapa">
</form>
</div>
