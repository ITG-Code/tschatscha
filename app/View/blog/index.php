<main>
<br/>
<?php 
		if($data->loggedin){?>
		<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="#"></a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
   
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/dashboard">Hem</a></li>
        <!-- <li><a href="#"></a></li> -->
      </ul>
 <?php
        if($data->auth >=6){?>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hantera blogg <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/<?php echo $data->blogname; ?>/compose">Skriv inlägg</a></li>
              <?php
        if($data->auth ==7){?>
        <li><a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a></li>
        <?php } ?>
              <li></li>
            	
              <li class="divider"></li>
            </ul>
          </li>
 <?php } ?>
        
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dina bloggar <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <?php  foreach ($data->bloglist as $value) {if ($value->authority >= 6) { ?>
              <li><a href="/<?= $value->url_name ?>"><?= $value->name ?></a></li>
              <?php }} ?>
              <li class="divider"></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Annat <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/account/settings">Kontoinställningar</a></li>
              <li><a href="/blog/allFollowers">Visa alla följare</a></li>
              <li><a href="/logout">Logga ut</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
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
        <?php }else{?>
        <a href="/dashboard">Hem</a>
        <a href="/login">Logga in</a>
        <?php }?>
     
       
        <p>Du är <?= $authorityName ?> på bloggen. <?php
        foreach ($data->followstatus as $value) {     
        	if($value->allowed == 1){?>
        		Du följer den här bloggen.
        <?php } ?>
         <?php
        	if($value->allowed == 0){?>
        		Följfråga skickad.
        <?php }
        }?>
        
        	
       <?php if (empty($data->followstatus)) {?>
        	<a href="/<?= $data->blogname ?>/follow" class="btn btn-success">Följ bloggen</a>

        <?php }
        if(!$data->loggedin){
        	echo "finemang va? :)";
        }
        ?>


    </nav>


    <?php foreach ($data->postlist as $post) {
        require 'app/View/blog/post/single.php';
    } ?>
</main>







