Give other users authority
Choose blog:

<form method="post" action="/blog/settings">
    <label> Co-writer</label>
    <input type="radio" name="authority"/></br>
    <label> Private view </label>
    <input type="radio" name="authority"/></br>
    <label> Moderate </label>
    <input type="radio" name="authority"/></br>
    <input type="submit" value="Confirm"/>

</form>

<form method="post" action="/blog/settings">
    <label>Sök efter alias</label>
    <input type="text" name="userQuery"/>
    <input type="submit" value="Search"/>
</form>
<div class="searchResult">
    <table align="left" cellspacing="5" cellpadding="8">
        <tr>
            <td align="left"><b>Förnamn</b></td>
            <td align="left"><b>Alias</b></td>
            <td align="left"><b>Efternamn</b></td>
            <td align="left"><b>Email</b></td>
        </tr>
        <form action='' method='post'>
            <?php foreach ($data->usersearch as $value) { ?>
                <tr>
                    <td align="left">
                        <input type="checkbox" value="<?=$value->id?>"> <?= $value->first_name ?>
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
        </form>
    </table>
</div>
