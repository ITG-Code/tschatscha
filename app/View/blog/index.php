<main>
<nav> <?php if($data->auth == 7){
				$authorityName = "ägare";
				$data->auth = $authorityName;

				?>
				<a href="/<?php echo $data->blogname; ?>/compose">Gör ett inlägg</a>
			 <a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a> ';
				<?php	
				}elseif($data->auth == 6){
					$authorityName = "medskribent";
					$data->auth = $authorityName;
					echo ' <a href="/<?php echo $data->blogname; ?>/compose">Gör ett inlägg</a> ';
				}
				elseif($data->auth == 2){
					$authorityName = "moderator";
					$data->auth = $authorityName;
				}
				elseif($data->auth == 0){
					$authorityName = "besökare";
					$data->auth = $authorityName;
				}
				if($this->userModel ->isLoggedIn()){
					echo'<a href="/dashboard">Min kontrollpanel</a>
					<a href="/logout">Logga ut</a>';
				}?>
			<p>Du är <?= $authorityName ?> på bloggen 
			
			
        </nav>


    <?php foreach ($data->postlist as $post) {
       require 'app/View/blog/post/single.php';
     } ?>
</main>



<!--<?php
				//if($data->){
			//echo '<a href="/<?= $data->allowed ?>/follow">Följ bloggen</a></p>';
			// Du ska inte kunna trycka följa om du redan är pending, du ska kunna sluta följa osv.
            
            }?>
            !-->

