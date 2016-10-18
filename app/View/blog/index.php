<main>
<nav> 
            <a href="/dashboard">Dashboard</a>
            <a href="/logout">Log out</a>
            <a href="/<?php echo $data->blogname; ?>/compose">Post</a>
			<a href="/<?php echo $data->blogname; ?>/settings">Blogsettings</a>
        </nav>
    <?php foreach ($data->postlist as $post) {
       require 'app/View/blog/post/single.php';
     } ?>
</main>

<a href="/<?php echo $data->blogname; ?>/settings">Blogsettings</a>
<a href="/<?= $data->blogname ?>/follow">follow</a>


