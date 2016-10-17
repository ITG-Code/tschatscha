Give other users authority

<form method="post" action="/<?= $data->blogname ?>/settings">
    <label> Co-writer</label>
    <input type="radio" name="authority" value="<?= Authority::BLOG_CO_WRITER ?>"/></br>
    <label> Private view </label>
    <input type="radio" name="authority" value="<?= Authority::POST_PRIVATE_VIEW ?>"/></br>
    <label> Moderate </label>
    <input type="radio" name="authority" value="<?= Authority::BLOG_MODERATE ?>"/></br>
 
    <input type="submit" value="Confirm"/>
    <label>Tags</label>
    <input type="checkbox" name="tags"/>
    

    <label>Search for user</label>
    <input type="text" name="userQuery"/>
    <input type="submit" value="Search"/>   

<div class="searchResult">
    <table align="left" cellspacing="5" cellpadding="8">
        <tr>
            <td align="left"><b>Search result</b></td>
            <td align="left"><b>Email</b></td>
        </tr>
            <?php foreach ($data->usersearch as $value) { ?>
                <tr>
                    <td align="left">
                        <input type="radio" name="user_id" value="<?=$value->id?>"> <?= $value->name ?>
                    </td>
                    <td align="left">
                        <?= $value->email ?>
                    </td>
                </tr>
            <?php } ?>
       
        </table>
    </div>
</form>
<form method="post" action="/<?= $data->blogname ?>/updateTags">
    <div>
        <table>
            Remove tags
            <?php foreach ($data->tags as $value) { ?>
            <tr>
                <td>
                    <label for="tag[]"><?=$value->name?></label>
                </td>
                <td>
                    <input type="checkbox" id="tag[]" name="tag[]" value="<?=$value->tag_id?>">   
                </td>
            </tr>            
            <?php } ?>
        </table>   
    </div>
    <div>
        <table>
            <tr>
                <td>
                    <label for="Tags">Add tags: </label>
                </td>
                <td>
                    <input type="text" name="Tags" placeholder="Ex. Party Holiday" id="Tags">
                </td>
            </tr>
        </table>
    </div>
    <input type="submit" name="tagChange" value="Uppgdate tags">
</form>
<div>
</div>

