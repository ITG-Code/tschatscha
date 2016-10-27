<?php if ((($data->auth >= $post->visibility) || ($post->visibility == 1 && !$data->linked_title)) && ($data->anon + $post->anonymous_allowance >= 1)) { ?>
    <div class="col-md-12">
      <article class="panel panel-primary">
        <div class="panel-heading">
          <?php if (htmlentities($data->linked_title)) { ?>
              <h2 class="panel-title">
                  <a href="/<?= htmlentities($data->blogname) ?>/post/<?= htmlentities($post->url_title) ?>"><?= htmlentities($post->title) ?></a>
              </h2>
          <?php } else { ?>
              <h2 class="panel-title"><?= $post->title ?></h2>
          <?php } ?>
          <h3 class=""></h3>
        </div>
        <div class="panel-body">
          <p>
              <?php
              $content = $data->parsedown->text($post->content);
              $content = str_replace("<img", "<img class='img-responsive'", $content);
              echo $content;
              ?>
          </p>
        </div>
        <div class="panel-footer">
          <p>Skriven av: <?= htmlentities($post->first_name), " ", htmlentities($post->alias), " ", htmlentities($post->sur_name) ?> </p>
          <p> Publicerad: <?= $post->publishing_date ?></p>
          <div>
              <p style="font-size:12px;">Taggar: <?= htmlentities($post->tags) ?></p>
          </div>
          <?php if (!$data->linked_title) { ?>
              <?php if ($data->auth >= Authority::BLOG_CO_WRITER) { ?>
                  <table>
                      <tr>
                          <td>
                              <form name="edit" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/edit"
                                    method="post">
                                  <input type="submit" class="btn btn-success" name="<?= $post->id ?>"
                                         value="Redigera"/>
                              </form>
                          </td>
                          <td>
                              <form name="delete"
                                    action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete"
                                    method="post">
                                  <input type="hidden" name="delete" value="<?= $post->id ?>"/>
                                  <input type="submit" class="btn btn-danger" name="<?= $post->id ?>"
                                         value="Ta bort"/>
                              </form>
                          </td>
                      </tr>
                  </table>

              <?php } ?>
          <?php } ?>
        </div>
      </article>

        <?php if (!$data->linked_title) { ?>
            <?php foreach ($data->comments as $comment) {
                if ($comment->parent_id == NULL){?>
                <section class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Skriven av: <?= htmlentities($comment->name) ?></h3>
                  </div>
                  <div class="panel-body">
                      <p><?= $data->parsedown->text($comment->content) ?></p>
                  </div>
                  <div class="panel-footer">
                        <p style="font-size:12px;">Skriven: <?= htmlentities($comment->created_at) ?></p>
                        <?php if ($data->auth >= Authority::BLOG_MODERATE) { ?>
                          <form name="delete"
                                action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/deleteComment"
                                method="post">
                              <input type="hidden" name="delete" value="<?= $comment->id ?>"/>
                              <input type="submit" class="btn btn-danger" name="<?= $comment->id ?>"
                                     value="Ta bort innehåll"/>
                          </form>
                          <form name="edit"
                                action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/editComment"
                                method="post">
                              <input type="hidden" name="edit" value="<?= $comment->id ?>"/>
                              <input type="submit" class="btn btn-info" name="<? $comment->id?>"
                                     value="Redigera"/>
                          </form>
                        <?php } ?>
                  </div>
                </section>
            <?php }foreach ($data->replies as $reply) {
                    if ($reply->parent_id == $comment->id){?>
                        <section class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title">Skriven av: <?= htmlentities($comment->name) ?></h3>
                            </div>
                            <div class="panel-body">
                                <p><?= $data->parsedown->text($reply->content) ?></p>
                            </div>
                            <div class="panel-footer">
                                <p style="font-size:12px;">Skriven: <?= htmlentities($reply->created_at) ?></p>
                                <?php if ($data->auth >= Authority::BLOG_MODERATE) { ?>
                                    <form name="delete"
                                          action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/deleteComment"
                                          method="post">
                                        <input type="hidden" name="delete" value="<?= $comment->id ?>"/>
                                        <input type="submit" class="btn btn-danger" name="<?= $comment->id ?>"
                                               value="Ta bort innehåll"/>
                                    </form>
                                <?php } ?>
                            </div>
                        </section>
                    <?php }
                } }?>


            <div class="well well-sm">
                <header>
                    <label for="content">Kommentera:</label>
                    <form method="post" action="/<?= $data->blogname ?>/createComment">
                    <textarea class="form-control" name="content" id="content" rows="3" pattern="^[A-Za-z]{1,}$"
                              value="content" required></textarea>
                        <input type="hidden" name="id" value="<?= $post->id ?>"/>
                        <input type="hidden" name="url_title" value="<?= $post->url_title ?>"/>
                        <input type="submit" class="btn btn-success" name="submit" value="Kommentera">
                    </form>
                </header>
            </div>
        <?php } ?>
    </div>
<?php if ($data->auth >= Authority::BLOG_CO_WRITER) { ?>
    <table>
        <tr>
            <td>
                <form name="delete" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete" method="post">
                    <input type="hidden" name="delete" value="<?= $post->id ?>"/>
                    <input type="submit" name="<?= $post->id ?>" value="Ta bort"/>
                </form>
            </td>
            <td>
                <form name="edit" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/edit" method="post">
                    <input type="submit" name="<?= $post->id ?>" value="redigera"/>
                </form>
            </td>
        </tr>
    </table>
<?php } ?>
<?php } ?>
