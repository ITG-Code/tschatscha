<main>
<nav> <?php if($data->auth == 7){
				$authorityName = "ägare";
				$data->auth = $authorityName;

				}elseif($data->auth == 6){
					$authorityName = "medskribent";
					$data->auth = $authorityName;
				}
				elseif($data->auth == 2){
					$authorityName = "moderator";
					$data->auth = $authorityName;
				}
				elseif($data->auth == 0){
					$authorityName = "besökare";
					$data->auth = $authorityName;
				}
					?></p>
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





