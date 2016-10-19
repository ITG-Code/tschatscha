<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/dashboard">Home</a></li>
        <li><a href="#"></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dina bloggar <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <?php foreach ($data->bloglist as $value) { ?>
              <li><a href="/<?= $value->url_name ?>"><?= $value->name ?></a></li>
              <?php } ?>
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
        <h3 class="panel-title">Följningar</h3>
      </div>
      <div class="panel-body">
        <table class="myBlogs">
          <tr class="myFollowSpace">
            <th><b>Bloggnamn</b></th>
            <th><b>Länk</b></th>
          </tr>
          <?php foreach ($data->followlist as $value) { ?>
            <tr>
              <td><?= $value->name ?></td>
              <td><a href="/<?= $value->url_name ?>"></td>
                <td>
                  <form action="/blog/deleteFollower" method="post">
                    <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                    <input type="hidden" name="id" value="<?= $value->id ?>">
                    <input type="submit" name="unfollow" value="unfollow">
                  </form>
                </td>
              </tr>
              <?php } ?>

            </table>
            <?php if(empty($data->followlist)) {?>
              <p class="text-muted">Du följer inga bloggar</p>
              <?php } ?>
            </div>
          </div>

        </div>
        <div class="col-md-6 col-xs-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Följningsförfrågningar</h3>
            </div>
            <div class="panel-body">
              <table class="myBlogs">
                <tr class="myFollowSpace">
                  <th><b>Name</b></th>
                  <th><b>blog</b></th>
                </tr>
                <?php foreach ($data->acceptFollowList as $value) { ?>
                  <tr>
                    <td>
                      <?= $value->name ?>
                    </td>
                    <td>
                      <?= $value->blog_name ?>
                    </td>
                    <td>
                      <form action="/blog/acceptFollower" method="post">
                        <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                        <input type="hidden" name="id" value="<?= $value->id ?>">
                        <input type="submit" class="btn btn-success" name="accept" value="accept">
                      </form>
                    </td>
                    <td>
                      <form action="/blog/deleteFollower" method="post">
                        <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                        <input type="hidden" name="id" value="<?= $value->id ?>">
                        <input type="submit" class="btn btn-danger" name="deny" value="deny">
                      </form>
                    </td>
                  </tr>
                  <?php } ?>
                </table>
                <?php if(empty($data->acceptFollowList)){?>
                  <p class="text-muted">Inga nya förfrågningar</p>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title">Skapa blogg</h3>
                </div>
                <div class="panel-body">
                  <form class="form-horizontal" action="/blog/create" method="post">
                    <fieldset>
                      <div class="form-group">
                        <label for="blogname">Bloggnamn</label>
                        <input type="text" name="blogname" class="form-control" id="" placeholder="Bloggnamn" required="">
                      </div>
                      <div class="form-group">
                        <label for="urlname">Url namn</label>
                        <input type="text" name="urlname" class="form-control" id="" placeholder="urbanblog.com/dittnamnhär">
                        <p class="help-block">Namnet som syns i länkar</p>
                      </div>
                      <div class="form-group">
                        <label for="tags">Taggar</label>
                        <input type="text" name="tags" class="form-control" id="" placeholder="Taggar">
                        <p class="help-block">T.ex. kläder, datorer</p>
                      </div>
                      <div class="form-group">
                        <div class="checkbox">
                          <label for="nsfw"><input type="checkbox" class="" name="nsfw" id="" value="1">Känsligt innehåll</label>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Skapa blogg">
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
            <div id="errors">
              <h5>
                <?php foreach ($data->errors as $value) {
                  echo $value;
                  } ?>
                </h5>
              </div>
