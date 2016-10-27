<main>
    <nav> 
    <?php
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
    }?>
        <?php if ($data->loggedin) {?>
        <p >Du är <?= $authorityName ?> på bloggen. <?php
        
            
        
        foreach ($data->followstatus as $value) {
            if ($value->allowed == 1) {?>
                Du följer den här bloggen.
        <?php                                                                                                                                                                                                                                                                                                                         } ?>
            <?php
            if ($value->allowed == 0) {?>
                Följfråga skickad.
        <?php                                                                                                                                                                                                                                                                                                                         }
        }?>


        <?php if (empty($data->followstatus)) {?>
            <a href="/<?= $data->blogname ?>/follow" class="btn btn-success">Följ bloggen</a>

        <?php }
} ?>
        <p>Följare på <span style="text-transform: capitalize; font-style: bold;"><?= $data->realBlogName->name?> | </span> <?= $data->followers->followers ?> st</p>
        <?php if (!$data->loggedin) {?>
        <p>Du är <?= $authorityName ?> på bloggen.
        <?php
}?>
   
    </nav> 
     

    <?php foreach ($data->postlist as $post) {
            require 'app/View/blog/post/single.php';
}
            ?>
    <?php if (empty($data->postlist)) { ?>
        Det finns inga poster på denna blog
    <?php } ?>
</main>
