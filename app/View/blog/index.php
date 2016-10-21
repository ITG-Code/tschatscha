<main>
<nav> <?php if($data->auth == 7){
				$authorityName = "ägare";
				}elseif($data->auth == 6){
					$authorityName = "medskribent";
				}
				elseif($data->auth == 2){
					$authorityName = "moderator";
				}
				elseif($data->auth == 0){
					$authorityName = "besökare";
				}
					?>
			</p>
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





