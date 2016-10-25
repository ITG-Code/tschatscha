  <br/>

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <!--  <a class="navbar-brand" href="#"></a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/dashboard">Hem</a></li>
        <!-- <li><a href="#"></a></li> -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dina bloggar <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <?php  foreach ($data->bloglist as $value) {if ($value->authority >= 6) { ?>
              <li><a href="/<?= htmlentities($value->url_name) ?>"><?= $value->name ?></a></li>
              <?php }} ?>
              <li class="divider"></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Annat <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/account/settings">Kontoinställningar</a></li>
              <li><a href="/logout">Logga ut</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
<div class="col-md-6 col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Personer som följer dig</h3>
        </div>
        <div class="panel-body">
          <table class="myBlogs">
            <tr class="myFollowSpace">
                  <th><b>Namn</b></th>
                  <th><b>Följer din blogg:</b></th>
               </tr>
            <?php foreach ($data->list as $value) { ?>
              <tr>
                <td>
                     <?= htmlentities($value->name) ?>
                </td>
                <td>
                     <a href="/<?= htmlentities($value->url_name) ?>"><?= htmlentities($value->blog_name) ?></a>
                </td>
                <td>
                     <form action="/blog/deleteFollower" method="post">
                        <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                        <input type="hidden" name="id" value="<?= $value->id ?>">
                        <input type="hidden" name="redict" value="0">
                        <input type="submit" class="btn btn-danger" name="deny" value="Ta bort">
                     </form>
                </td>
              </tr>
              <?php } ?>
        </table>
        <?php if(empty($data->list)){?>
        <p class="text-muted">Du kontrollerar ingen blogg</p>
        <?php } ?>
        </div>
      </div>
</div>

<div class="col-md-6 col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Bloggar du kontrollerar</h3>
        </div>
        <div class="panel-body">
          <table class="myBlogs">
            <tr class="myFollowSpace">
                  <th><b>Blogg</b></th>
                  <th><b>Antal följare</b></th>
                  <th><b>Rank</b></th>
               </tr><?php foreach ($data->blogs as $value) { ?>
              <tr>

               <?php if($value->authority == 7){
                $authorityName = "Ägare";
                }elseif($value->authority == 6){
                    $authorityName = "Delägare";
                }
                elseif($value->authority == 2){
                    $authorityName = "Moderator";
                }
                elseif($value->authority == 0){
                    $authorityName = "Besökare";
                }
                    ?>

                <td>
                     <a href="/<?= $value->url_name ?>"><?= htmlentities($value->name) ?></a>
                </td>
                <td>
                  <?= $value->followers ?>
                </td>
                <td>
                     <?= $authorityName ?>
                </td>
              </tr>
              <?php } ?>
        </table>
        </div>
      </div>
</div>
