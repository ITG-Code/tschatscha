<main>
    <nav> <?php
        switch ($data->auth) {
            case Authority::BLOG_OWNER:
                $authorityName = "ägare";
                break;
            case Authority::BLOG_CO_WRITER:
                $authorityName = "medskribent";
                break;
            case Authority::BLOG_MODERATE:
                $authorityName = "moderator";
                break;
            default:
                $authorityName = "besökare";
        }
        ?>
        <a href="/dashboard">Hem</a>
        <a href="/<?= $data->blogname ?>/follow">Följ bloggen</a>
        <a href="/logout">Logga ut</a>
        <a href="/<?php echo $data->blogname; ?>/compose">Post</a>
        <a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a>
        <p>Du är <?= $authorityName ?> på bloggen
    </nav>


    <?php foreach ($data->postlist as $post) {
        require 'app/View/blog/post/single.php';
    } ?>
</main>





