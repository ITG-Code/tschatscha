<?php if (!$data->linked_title) { ?>
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
 
    <ul class="nav navbar-nav navbar-right">
    <li><a href="/<?= $data->blogname ?>">Tillbaka till  flödet</a></li>
        <?php
        if($data->auth >=6){?>
        <li><a href="/<?php echo $data->blogname; ?>/compose">Skriv nytt inlägg</a></li><li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hantera blogg <b class="caret"></b></a>
          <ul class="dropdown-menu">
            
              <?php
        if($data->auth ==7){?>
        <li><a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a></li>
        <?php } ?>
              <li></li>

              
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

     <?php
     } }?>
<?php if ((($data->auth >= $post->visibility) || ($post->visibility == 1 && !$data->linked_title)) && ($data->anon + $post->anonymous_allowance >= 1)) { ?>
    <div class="col-md-12">
        <article class="well well-sm">
            <header>
                <?php if (htmlentities($data->linked_title)) { ?>
                    <h2><a href="/<?= htmlentities($data->blogname) ?>/post/<?= htmlentities($post->url_title) ?>"><?= htmlentities($post->title) ?></a></h2>
                <?php } else { ?>
                    <h2><?= $post->title ?></h2>
                <?php } ?>
            </header>
            <p>
                <?php
                $content = $data->parsedown->text($post->content);
                $content = str_replace("<img", "<img class=\"img-responsive\"", $content);
                echo $content;
                ?>
            </p>
            <footer>
                <p style="font-size:10px;">Skriven
                    av: <?= htmlentities($post->first_name), " \"", htmlentities($post->alias), "\" ", htmlentities($post->sur_name) ?>
                    | Publicerad: <?= $post->publishing_date ?></p>
                <div>
                    <p style="font-size:10px;">Taggar: <?= htmlentities($post->tags) ?></p>
                </div>
                <?php if (!$data->linked_title) { ?>
                <?php if ($data->auth >= Authority::BLOG_CO_WRITER) { ?>
    <table>
        <tr>
            <td>
                <form name="edit" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/edit" method="post">
                    <input type="submit" class="btn btn-success" name="<?= $post->id ?>" value="Redigera"/>
                </form>
            </td>
            <td>
                <form name="delete" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete" method="post">
                    <input type="hidden" name="delete" value="<?= $post->id ?>"/>
                    <input type="submit" class="btn btn-danger" name="<?= $post->id ?>" value="Ta bort"/>
                </form>
            </td>
        </tr>
    </table>
<?php } ?>
            </footer>

        </article>
        
            <article class="well well-sm">
                <header>
                    <label for="content">Kommentera:</label>
                    <form method="post" action="/<?= $data->blogname ?>/createComment">
                    <textarea class="form-control" name="content" id="content" rows="3" pattern="^[A-Za-z]{1,}$"
                              value="content" required></textarea>
                        <input type="hidden" name="id" value="<?= $post->id ?>"/>
                        <input type="hidden" name="url_title" value="<?= $post->url_title ?>"/>
                        <input type="submit" name="submit" value="Submit">
                    </form>
                </header>
            </article>
        <?php } ?>
    </div>
<?php } ?>


