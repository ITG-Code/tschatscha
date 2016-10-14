<article class="well well-sm">
    <header><h2><?= $post->title ?></h2></header>
    <p><?= $data->parsedown->text($post->content) ?></p>
    <footer>
        <p>Skriven av: <?=$post->first_name, " \"", $post->alias,"\" ", $post->sur_name ?></p>
        <p class="">Publicerad: <?= $post->publishing_date ?></p>
    </footer>
</article>