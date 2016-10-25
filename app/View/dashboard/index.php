<div class="col-md-12">
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dina bloggar <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($data->bloglist as $value) {
                                if ($value->authority >= 6) { ?>
                                    <li>
                                        <a href="/<?= htmlentities($value->url_name) ?>"><?= htmlentities($value->name) ?></a>
                                    </li>
                                <?php }
                            } ?>
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
</div>

<div class="col-md-6 col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Följningar</h3>
        </div>
        <div class="panel-body">
            <table class="myBlogs">
                <tr class="myFollowSpace">
                    <th><b>Bloggnamn</b></th>
                </tr>
                <?php foreach ($data->followlist as $value) { ?>
                    <tr>
                        <td>
                            <a href="/<?= htmlentities($value->url_name) ?>"><?= htmlentities($value->name) ?></a>
                        </td>

                        <td>
                            <form action="/blog/deleteFollower" method="post">
                                <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                                <input type="hidden" name="id" value="<?= $value->id ?>">
                                <input type="hidden" name="redict" value="1">
                                <input type="submit" name="unfollow" class="btn btn-danger" value="Sluta följa">
                            </form>
                        </td>
                    </tr>
                <?php } ?>

            </table>
            <?php if (empty($data->followlist)) { ?>
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
                    <th><b>Alias</b></th>
                    <th><b>Blogg</b></th>
                </tr>
                <?php foreach ($data->acceptFollowList as $value) { ?>
                    <tr>
                        <td>
                            <?= htmlentities($value->name) ?>
                        </td>
                        <td>
                            <?= htmlentities($value->blog_name) ?>
                        </td>
                        <td>
                            <form action="/blog/acceptFollower" method="post">
                                <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                                <input type="hidden" name="id" value="<?= $value->id ?>">
                                <input type="hidden" name="redict" value="1">
                                <input type="submit" class="btn btn-success" name="accept" value="Acceptera">
                            </form>
                        </td>
                        <td>
                            <form action="/blog/deleteFollower" method="post">
                                <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                                <input type="hidden" name="id" value="<?= $value->id ?>">
                                <input type="hidden" name="redict" value="1">
                                <input type="submit" class="btn btn-danger" name="deny" value="Neka">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php if (empty($data->acceptFollowList)) { ?>
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
                        <input type="text" name="blogname" class="form-control" id="" placeholder="Bloggnamn"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="urlname">Url namn</label>
                        <input type="text" name="urlname" class="form-control" id=""
                               placeholder="urbanblog.com/dittnamnhär">
                        <p class="help-block">Namnet som syns i länkar</p>
                    </div>
                    <div class="form-group">
                        <label for="tags">Taggar</label>
                        <input type="text" name="tags" class="form-control" id="" placeholder="Taggar">
                        <p class="help-block">T.ex. kläder, datorer, separeras med komma (,)</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label for="nsfw"><input type="checkbox" class="" name="nsfw" id="" value="1">Känsligt
                                innehåll</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Skapa blogg">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Alla bloggar</h3>
        </div>
        <div class="panel-body">
            <table class="myBlogs">
                <tr class="myFollowSpace">
                    <th><b>Blogg</b></th>
                    <th><b>URL</b></th>
                    <th><b>Alias</b></th>
                </tr>
                <?php
                //if($data->authority == 7){
                foreach ($data->allbloglist as $blog) {
                    ?>
                    <tr>
                        <td><a href="/<?= htmlentities($blog->url_name) ?>"><?= htmlentities($blog->name) ?></a></td>
                        <td>
                            <a href="/<?= htmlentities($blog->url_name) ?>">urbanblogg.se/<?= htmlentities($blog->url_name) ?></a>
                        </td>
                        <td><?= $blog->alias ?></td>

                    </tr>
                    <?php //}
                } ?>

            </table>
            <?php if (empty($data->allbloglist)) { ?>
                <p class="text-muted">Det finns inga bloggar</p>
            <?php } ?>
        </div>
    </div>


    <div id="errors">
        <h5>
            <?php foreach ($data->errors as $value) {
                echo htmlentities($value);
            } ?>
        </h5>
    </div>
