<div class="wrapper">
  <div class="panel panel-default">
    <div class="panel-heading" id="panel-heading">
      <h3 class="panel-title" href="#changealias" data-toggle="collapse">Byt alias</h3>
    </div>
    <div class="panel-body collapse" id="changealias">
      <form class="form-horizontal" action="/account/change_alias" method="post">
        <fieldset>
          <div class="form-group">
            <label for="alias">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias" placeholder="Alias">
            <p class="help-block">Det alias du vill ha i framtiden</p>
          </div>
          <div class="form-group">
            <label for="confirmpassword">Lösenord</label>
            <input type="password" class="form-control" name="confirmpassword" placeholder="">
            <p class="help-block">Verifiera med ditt lösenord</p>
          </div>
          <div class="form-group">
            <input type="submit" class="form-control btn btn-primary" value="Byt alias">
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" id="panel-heading">
      <h3 class="panel-title" href="#change_email" data-toggle="collapse">Byt Email</h3>
    </div>
    <div class="panel-body collapse" id="change_email">
      <form class="form-horizontal" action="/account/change_email" method="post">
        <fieldset>
          <div class="form-group">
            <label for="alias">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            <p class="help-block">Din nya email</p>
          </div>
          <div class="form-group">
            <label for="confirmpassword">Lösenord</label>
            <input type="password" class="form-control" name="confirmpassword" placeholder="">
            <p class="help-block">Verifiera med ditt lösenord</p>
          </div>
          <div class="form-group">
            <input type="submit" class="form-control btn btn-primary" value="Byt alias">
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" id="panel-heading">
      <h3 class="panel-title" href="#change_password" data-toggle="collapse">Byt Lösenord</h3>
    </div>
    <div class="panel-body collapse" id="change_password">
      <form class="form-horizontal" action="/account/change_password" method="post">
        <fieldset>
          <div class="form-group">
            <label for="alias">Nytt Lösenord</label>
            <input type="password" class="form-control" id="email" name="newpassword" placeholder="Nytt lösenord">
            <p class="help-block">Det lösenord du vill ha i framtiden</p>
          </div>
          <div class="form-group">
            <label for="alias">Bekräfta nytt Lösenord</label>
            <input type="password" class="form-control" id="email" name="confirmnewpassword" placeholder="Bekräfta nytt lösenord">
          </div>
          <div class="form-group">
            <label for="confirmpassword">Lösenord</label>
            <input type="password" class="form-control" name="confirmpassword" placeholder="">
            <p class="help-block">Verifiera med ditt lösenord</p>
          </div>
          <div class="form-group">
            <input type="submit" class="form-control btn btn-primary" value="Byt alias">
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
