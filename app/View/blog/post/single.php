<article class="well well-sm">
    <header>
        <?php if ($data->linked_title) { ?>
            <h2><a href="/<?=$data->blogname?>/post/<?=$post->url_title?>"><?= $post->title ?></a> </h2>
        <?php } else { ?>
            <h2><?= $post->title ?></h2>
        <?php } ?>
    </header>
    <p><?= $data->parsedown->text($post->content) ?></p>
    <footer>
        <p>Skriven av: <?= $post->first_name, " \"", $post->alias, "\" ", $post->sur_name ?></p>
        <p class="">Publicerad: <?= $post->publishing_date ?></p>
    </footer>
</article>