<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<div class="wrapper">
You are logged in
<?php echo $data->user->alias ?>!
<a href="blog/settings">Hantera bloggar</a><!-- vart ska den ligga? Hantera; ta bort, ändra namn etc. !-->

<a href="../account/index">Kontoinställningar</a>
<form action="/logout" method="post">
    <input type="submit" name="Loggout" value="logga ut">
</form>

<h3>Dina bloggar</h3>

<table align="left" cellspacing="5" cellpadding="8">
        <tr>
            <td align="left"><b>Bloggnamn</b></td>
            <td align="left"><b>URL</b></td>
            <td align="left"><b>Senast ändrad</b></td>
        </tr>
        
            <?php foreach ($data->bloglist as $value) { ?>
                <tr>
                    <td align="left">
                    </td>
                    <td align="left">
                        <?= $value->name ?>
                    </td>
                    <td align="left">
                        <?= $value->url_name ?>
                    </td>
                    <td align="left">
                        <?= $value->changed_at ?>
                    </td>
                </tr>
            <?php } ?>
       
        </table>

        </br>


<h4>Skapa blog</h4>


<form id="createBlog" action="/blog/create" method="post" enctype="multipart/form-data">
   </br> Bloggnamn: </br><input type="text" name="blogname" required> </br>
    URL: </br><input type="text" name="urlname" required></br>
    Taggar:</br><input type="text" name="tags"></br>
    NSFW: <input type="checkbox" name="nsfw" value="1"/></br>
    <input type="submit" name="submitblog" value="Skapa">
</form>
</div>
