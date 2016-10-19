<?php if ((($data->auth >= $post->visibility) || ($post->visibility == 1 && !$data->linked_title)) && ($data->anon + $post->anonymous_allowance >= 1)) { ?>
    <article class="well well-sm">
        <header>
            <?php
            var_dump($post->id);
            if ($data->linked_title) { ?>
                <h2><a href="/<?= $data->blogname ?>/post/<?= $post->url_title ?>"><?= $post->title ?></a></h2>
            <?php } else { ?>
                <h2><?= $post->title ?></h2>
            <?php } ?>
        </header>
        <p><?= $data->parsedown->text($post->content) ?></p>
        <footer>
            <p>Skriven av: <?= $post->first_name, " \"", $post->alias, "\" ", $post->sur_name ?></p>

            <p class="">Publicerad: <?= $post->publishing_date ?></p>
            <div>
                Taggar: <?=$post->tags?>
            </div>

        </footer>
    </article>
<?php } ?>

<?php
   
if ($data->auth >=6){
?>

<form name="delete" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete" method="post">
<input type="hidden" name="delete" value="<?= $post->id ?>"/>
<input type="submit" name="<?= $post->id ?>" value="Ta bort" />
</form>
<?php
}else{
?>

<?php
    }?>

