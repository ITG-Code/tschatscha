<?php if ((($data->auth >= $post->visibility) || ($post->visibility == 1 && !$data->linked_title)) && ($data->anon + $post->anonymous_allowance >= 1)) { ?>
    <article class="well well-sm">
        <header>
            <?php

            if ($data->linked_title) { ?>
                <h2><a href="/<?= $data->blogname ?>/post/<?= $post->url_title ?>"><?= $post->title ?></a></h2>
            <?php } else { ?>
                <h2><?= $post->title ?></h2>
            <?php } ?>
        </header>
        <p><?= $data->parsedown->text($post->content) ?></p>
        <footer>
            <p style="font-size:10px;">Skriven av: <?= $post->first_name, " \"", $post->alias, "\" ", $post->sur_name ?> | Publicerad: <?= $post->publishing_date ?></p>


            <div>

                Taggar: <?=$post->tags?>


                <p style="font-size:10px;">Taggar: <?=$post->tags?></p>


            </div>

        </footer>
    </article>
<?php } ?>

<?php

if ($data->auth >=6){
?>
<table> <tr>
  <td>
<form name="delete" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete" method="post">
<input type="hidden" name="delete" value="<?= $post->id ?>"/>
<input type="submit" name="<?= $post->id ?>" value="Ta bort" />
</form>
</td>
<td>
<form name="edit" action"/<?= $data->blogname ?>/post/<?= $post->url_title ?>/edit" method="post">
  <input type="hidden" name="edit" value="<?= $post->id ?>" />
  <input type="hidden" name="editurl" value="<?= $post->url_title ?>" />
  <input type="submit" name="<?= $post->id ?>" value="redigera" />
</form>
</td>
</tr>
</table>
<?php
}else{



//<?php foreach($data->postTags as $tags){echo"<a href=''>
    }?>
