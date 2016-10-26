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
    <p style="font-size:10px;">Skriven
        av: <?= htmlentities($post->first_name), " ", htmlentities($post->alias), " ", htmlentities($post->sur_name) ?>
        | Publicerad: <?= $post->publishing_date ?></p>
    <div>
        <p style="font-size:10px;">Taggar: <?= htmlentities($post->tags) ?></p>
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
                <article class="well well-sm">
                    <header>
                        Skriven av: <?= htmlentities($comment->name) ?>
                        </br>
                        Kommentar: <?= htmlentities($comment->content) ?>
                    </header>
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
                        <input type="submit" name="submit" value="Submit">
                    </form>
                </header>
            </article>
        <?php } ?>

    <?php } ?>
    </footer>
    </article>
    </div>
    <?php } ?>