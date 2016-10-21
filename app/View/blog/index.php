<main>
    <nav> <?php
        switch ($data->auth) {
            case Authority::BLOG_OWNER:
                $authorityName = "ägare";
                break;
            case Authority::BLOG_CO_WRITER:
                $authorityName = "medskribent";
                break;
            case Authority::BLOG_MODERATE:
                $authorityName = "moderator";
                break;
            default:
                $authorityName = "besökare";
        }
        ?>
        <?php
        	if($data->loggedin){
        		//var_dump($data->followstatus->allowed); ?>

        <a href="/dashboard">Hem</a>

        
        <?php
        if($data->auth >=6){?>
        <a href="/<?php echo $data->blogname; ?>/compose">Post</a>
        <?php } ?>
        <?php
        if($data->auth ==7){?>
        <a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a>
        <?php } ?>
        <a href="/logout">Logga ut</a>
        <?php }else{?>
        <a href="/dashboard">Hem</a>
        <a href="/login">Logga in</a>
        <?php }?>
        <p>Du är <?= $authorityName ?> på bloggen. <?php
        foreach ($data->followstatus as $value) {     
        	if($value->allowed == 1){?>
        		Du följer den här bloggen
        <?php } ?>
         <?php
        	if($value->allowed == 0){?>
        		Följförfrågan väntar på godkännande
        <?php }
        }?>
        <?php
        	if($data->loggedin){?>
       <?php if (empty($data->followstatus)) {?>
        	<a href="/<?= $data->blogname ?>/follow">Följ bloggen</a>

        <?php }
        }?>


    </nav>


    <?php foreach ($data->postlist as $post) {
        require 'app/View/blog/post/single.php';
    } ?>
</main>







