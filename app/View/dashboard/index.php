
<div class="col-md-6 col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading" href="#myfollows" data-toggle="collapse" style="cursor: pointer;">
            <h3 class="panel-title">Följningar</h3>
        </div>
        <div class="panel-body collapse" id="myfollows">
            <table class="myBlogs">
                <tr class="myFollowSpace">
                    <th><b>Bloggnamn</b></th>
                    <th><b>Senast uppdaterad</b></th>
                </tr>
                <?php foreach ($data->followlist as $value) { ?>
                    <tr>
                        <td>
                            <a href="/<?= htmlentities($value->url_name) ?>"><?= htmlentities($value->name) ?></a>
                        </td>
                        <td>
                            <?=$value->updated_time ?>
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


<div class="col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading" href="#createblog" data-toggle="collapse" style="cursor: pointer;">
            <h3 class="panel-title">Skapa blogg</h3>
        </div>
        <div class="panel-body collapse" id="createblog">
            <form class="form-horizontal" action="/blog/create" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="blogname">Bloggnamn</label>
                        <input type="text" name="blogname" class="form-control" id="" placeholder="Bloggnamn"
                               required="">
                    </div>
                    <div class="form-group">
                        <label for="urlname">Url-namn</label><br>
                        <label id="urllable">urbanblog.com/</label> <input type="text" name="urlname" id="urlname" class="form-control" id=""
                               placeholder="Din-url">
                        <p class="help-block">Namnet som syns i länkar</p>
                    </div>
                    <div class="form-group">
                        <label for="tags">Taggar</label>
                        <input type="text" name="tags" class="form-control" id="" placeholder="Taggar">
                        <p class="help-block">T.ex. kläder, datorer, separeras med komma (,)</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label style="cursor: default;" for="nsfw"><input style="cursor: pointer;"type="checkbox" class="" name="nsfw" id="" value="1">Känsligt
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
</div>

<div class="col-xs-12">
    <div class="panel panel-primary">

        <div class="panel-heading" href="#allbloglist" data-toggle="collapse" style="cursor: pointer;">
            <h3 class="panel-title">Alla bloggar</h3>
        </div>
        <div class="panel-body collapse" id="allbloglist">
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
                            <a href="/<?= htmlentities($blog->url_name) ?>">urbanblog.com/<?= htmlentities($blog->url_name) ?></a>
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
</div>


    <div id="errors">
        <h5>
            <?php foreach ($data->errors as $value) {
                echo htmlentities($value);
} ?>
        </h5>
    </div>
