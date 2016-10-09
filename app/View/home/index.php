<a href='/login'>Logga in här</a><br><a href='/register'>Registrera här</a>


<ul>
    <?php
    foreach ($data->bloglist as $blog) {
        echo "<ul>";
        echo "<a href=\"/blog/{$blog->url_name}\">{$blog->name}</a> - ",
        (!isset($blog->first_name)) ? "{$blog->first_name} \"{$blog->alias}\" {$blog->sur_name}" : $blog->alias;
        echo "</ul>";
    }
    ?>
</ul>
