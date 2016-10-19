<main>
<nav> 
            <a href="/dashboard">Kontrollpanel</a>
            <a href="/logout">Logga ut</a>
            <a href="/<?php echo $data->blogname; ?>/compose">Post</a>
			<a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a>
        </nav>
    <?php foreach ($data->postlist as $post) {
       require 'app/View/blog/post/single.php';
     } ?>
</main>

<a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a>
<a href="/<?= $data->blogname ?>/follow">Följ</a>


