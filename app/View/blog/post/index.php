<?php
$post = $data->post[0];


require_once 'app/View/blog/post/single.php';
?>

 <form name="delete" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete" method="post">
<?= $post->id ?>
<input type="hidden" name="delete" value="<?= $post->id ?>"/>
<input type="submit" name="<?= $post->id ?>" value="Ta bort" />
</form>
