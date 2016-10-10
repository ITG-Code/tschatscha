Your are logged in
<?php echo $data->user->alias ?>!
<form action="/logout" method="post">
    <input type="submit" name="Loggout" value="logga ut">
</form>
 <br/>
<h4>Skapa blog</h4>
<form id="createBlog" action="/blog/create" method="post" enctype="multipart/form-data">
    Bloggnamn: </br><input type="text" name="blogname" required> </br>
    URL: </br><input type="text" name="urlname" required></br>
    NSFW: <input type="checkbox" name="nsfw" value="1"/></br>
    <input type="submit" name="submitblog" value="Skapa">
</form>
