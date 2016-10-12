<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<div class="wrapper">
    <form action="/account/change_alias" method="POST">
        <fieldset>
            <label for="alias">Alias</label>
            <input type="text" name="alias" required><br/>
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" name="confirmpassword" required><br/>
            <input type="submit" name="submit" value="change">
        </fieldset>
    </form>
    <form action="/account/change_email" method="POST">
        <fieldset>
            <label for="email">Email</label>
            <input type="text" name="email" required><br/>
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" name="confirmpassword" required><br/>
            <input type="submit" name="submit" value="change">
        </fieldset>
    </form>
    <form action="/account/change_password" method="POST">
        <fieldset>
            <label for="newpassword">New Password</label>
            <input type="password" name="newpassword" required><br/>
            <label for="confirmnewpassword">Confirm New Password</label>
            <input type="password" name="confirmnewpassword" required><br/>
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" name="confirmpassword" required><br/>
            <input type="submit" name="submit" value="change">
        </fieldset>
    </form>

</div>
