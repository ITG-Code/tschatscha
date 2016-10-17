<div class="wrapper">
<a href='/login'>Logga in här</a><br><a href='/register'>Registrera här</a>


<ul>
    <?php
    foreach ($data->bloglist as $blog) {
        echo "<ul>";

        echo "<a href=\"/{$blog->url_name}\">{$blog->name}</a> - ";
        if (!isset($blog->first_name))
            echo "{$blog->first_name} \"{$blog->alias}\" {$blog->sur_name}";
        else
            echo $blog->alias;
        echo "</ul>";
    }
    ?>
</ul>
</div>