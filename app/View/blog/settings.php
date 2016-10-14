Give other users authority

<form method="post" action="/<?= $data->blogname ?>/settings">
    <label> Co-writer</label>
    <input type="radio" name="authority" value="<?= Authority::BLOG_CO_WRITER ?>"/></br>
    <label> Private view </label>
    <input type="radio" name="authority" value="<?= Authority::POST_PRIVATE_VIEW ?>"/></br>
    <label> Moderate </label>
    <input type="radio" name="authority" value="<?= Authority::BLOG_MODERATE ?>"/></br>
 
    <input type="submit" value="Confirm"/>

    <label>Sök efter alias</label>
    <input type="text" name="userQuery"/>
    <input type="submit" value="Search"/>   

<div class="searchResult">
    <table align="left" cellspacing="5" cellpadding="8">
        <tr>
            <td align="left"><b>Förnamn</b></td>
            <td align="left"><b>Alias</b></td>
            <td align="left"><b>Efternamn</b></td>
            <td align="left"><b>Email</b></td>
        </tr>
        
            <?php foreach ($data->usersearch as $value) { ?>
                <tr>
                    <td align="left">
                        <input type="radio" name="user_id" value="<?=$value->id?>"> <?= $value->first_name ?>
                    </td>
                    <td align="left">
                        <?= $value->alias ?>
                    </td>
                    <td align="left">
                        <?= $value->sur_name ?>
                    </td>
                    <td align="left">
                        <?= $value->email ?>
                    </td>
                </tr>
            <?php } ?>
       
        </table>
    </div>
</form>


