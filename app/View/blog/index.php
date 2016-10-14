<main>
    <?php foreach ($data->postlist as $post) {
       require 'app/View/blog/post/single.php';
     } ?>
</main>
<a href="/<?php echo $data->blogname; ?>/settings">Blogsettings</a>

