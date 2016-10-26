<?php if ((($data->auth >= $post->visibility) || ($post->visibility == 1 && !$data->linked_title)) && ($data->anon + $post->anonymous_allowance >= 1)) { ?>
    <div class="col-md-12">
    <article class="well well-sm">
    <header>
        <?php if (htmlentities($data->linked_title)) { ?>
            <h2>
                <a href="/<?= htmlentities($data->blogname) ?>/post/<?= htmlentities($post->url_title) ?>"><?= htmlentities($post->title) ?></a>
            </h2>
        <?php } else { ?>
            <h2><?= $post->title ?></h2>
        <?php } ?>
    </header>
    <p>
        <?php
        $content = $data->parsedown->text($post->content);
        $content = str_replace("<img", "<img class='img-responsive'", $content);
        echo $content;
        ?>
    </p>
    <footer>
    <p style="font-size:12px;">Skriven
        av: <?= htmlentities($post->first_name), " ", htmlentities($post->alias), " ", htmlentities($post->sur_name) ?>
        | Publicerad: <?= $post->publishing_date ?></p>
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
                            <input type="submit" class="btn btn-success" name="<?= $post->id ?>" value="Redigera"/>
                        </form>
                    </td>
                    <td>
                        <form name="delete" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/delete"
                              method="post">
                            <input type="hidden" name="delete" value="<?= $post->id ?>"/>
                            <input type="submit" class="btn btn-danger" name="<?= $post->id ?>" value="Ta bort"/>
                        </form>
                    </td>
                </tr>
            </table>

        <?php } ?>

        <?php if (!$data->linked_title) { ?>

            <?php foreach ($data->comments as $comment) { ?>
                <article style="background-color:RGB(235,235,235);" class="well well-sm">
                    <header>
                      <p>
                        Skriven av: <?= htmlentities($comment->name) ?>
                      </p>
                      <p>
                        Kommentar: <?= htmlentities($comment->content) ?>
                      </p>
                    </header>
                  <p style="font-size:12px;">
                    Skriven: <?= htmlentities($comment->created_at) ?>
                  </p>
                      <?php if ($data->auth >= Authority::BLOG_MODERATE) { ?>
                        <table>
                            <tr>
                                <td>
                                  <form name="delete" action="/<?= $data->blogname ?>/post/<?= $post->url_title ?>/deleteComment"
                                        method="post">
                                      <input type="hidden" name="delete" value="<?= $comment->id ?>"/>
                                      <input type="submit" class="btn btn-danger" name="<?= $comment->id ?>" value="Ta bort innehåll"/>
                                  </form>
                                </td>
                              </tr>
                        </table>

                    <?php } ?>
                </article>
            <?php } ?>

            <article class="well well-sm">
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
            </article>
        <?php } ?>

    <?php } ?>
  </article>
    </footer>
    </div>
    <?php } ?>
