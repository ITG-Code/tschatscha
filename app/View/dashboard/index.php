<div class="wrapper">
    You are logged in
    <?php echo $data->user->alias ?>!
    <a href="../account/index">Account settings</a>
    <form action="/logout" method="post">
        <input type="submit" name="Loggout" value="loggout">
    </form>
    <h3>Your Blogs</h3>
    <table class="myBlogs">
         <tr class="myBlogsSpace">
            <th><b>Blogname</b></th>
            <th><b>Latest change</b></th>
        </tr>
        <?php foreach ($data->bloglist as $value) { ?>
        <tr>
            <td>
                <a href="/<?= $value->url_name ?>"><?= $value->name ?></a>
            </td>
            <td>
                <?= $value->changed_at ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <br>
    <h3>Blogs you follow</h3>
    <table class="myBlogs">
        <tr class="myFollowSpace">
            <th><b>Blogname</b></th>
            <th><b>Latest change</b></th>
        </tr>
        <?php foreach ($data->followlist as $value) { ?>
        <tr>
            <td>
                <a href="/<?= $value->url_name ?>"><?= $value->name ?></a>
            </td>
            <td>
                <?= $value->updated_time ?>
            </td>
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
    <br>
    <br>
    <h3>People who wants to follow your blogs</h3>
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
                    <input type="submit" name="accept" value="accept">
                </form>
            </td>
            <td>
                <form action="/blog/deleteFollower" method="post">
                    <input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
                    <input type="hidden" name="id" value="<?= $value->id ?>">
                    <input type="submit" name="deny" value="deny">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <br>
    <h4>Create blog</h4>
    <div id="errors">
        <h5>
            <?php foreach ($data->errors as $value) {
                echo $value;
            } ?>
        </h5>
    </div>
    <form id="createBlog" action="/blog/create" method="post" enctype="multipart/form-data">
       </br> Blogname: </br><input type="text" name="blogname" required> </br>
        URL: </br><input type="text" name="urlname" required></br>
        Tags:</br><input type="text" name="tags"></br>
        NSFW: <input type="checkbox" name="nsfw" value="1"/></br>
        <input type="submit" name="submitblog" value="Create">
    </form>
</div>
