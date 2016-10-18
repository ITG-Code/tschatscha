<?php
$post = $data->post[0];


require_once 'app/View/blog/post/single.php';
?>
<form action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete" method="post">
<input type="hidden" value="<?= $post->id ?>" name="id" >
<?php echo $post->id; ?>
<input type="submit" name="delete" value="<?= $post->id; ?>" />
</form>