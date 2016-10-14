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

<table class="myBlogs">

        <tr class="myBlogsSpace">
            <th><b>Bloggnamn</b></th>
            <th><b>Senast ändrad</b></th>
        </tr>
        
            
                <tr>
                    <?php foreach ($data->bloglist as $value) { ?>
                    <td>
                      <a href="/<?= $value->url_name ?>"><?= $value->name ?></a>
                    </td>
                    <td>
                        <?= $value->changed_at ?>
                    </td>
                </tr>
            <?php } ?>
       
        </table>

        </br>
<br/>

<h4>Skapa blog</h4>


<form id="createBlog" action="/blog/create" method="post" enctype="multipart/form-data">
   </br> Bloggnamn: </br><input type="text" name="blogname" required> </br>
    URL: </br><input type="text" name="urlname" required></br>
    Taggar:</br><input type="text" name="tags"></br>
    NSFW: <input type="checkbox" name="nsfw" value="1"/></br>
    <input type="submit" name="submitblog" value="Skapa">
</form>
</div>
