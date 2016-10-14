<article class="well well-sm">
    <header><h2><?= $post->title ?></h2></header>
    <p><?= $post->content ?></p>
    <footer>
        <p>Skriven av: <?=$post->writer ?></p>
        <p class="">Publicerad: <?= $post->publishing_date ?></p>
    </footer>
</article>