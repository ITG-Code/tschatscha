<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="row">
  <div class="col-md-8">
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
  <div class="col-md-4">
    <form class="form-horizontal" action="/login/send" method="post">
      <div class="form-group">
        <label for="username">Användarnamn</label>
        <input type="text" class="form-control" id=""  name="username" placeholder="Användarnamn" required="">
        <p class="help-block">Namn du kommer logga in med</p>
      </div>
      <div class="form-group">
        <label for="password">Lösenord</label>
        <input type="password" class="form-control" id="" name="password" placeholder="Lösenord" required="">
        <p class="help-block">Help text here.</p>
      </div>
      <a href="#register" data-toggle="collapse">Inte registerad?</a>
      <div class="g-recaptcha" data-sitekey="6Lf6aQgUAAAAAMp-uBJa-Fg6m-tGx04qfUyTYdoN"></div>
      <div class="form-group">
        <input type="submit" name="login" value="Logga in" class="btn btn-primary">
      </div>
    </form>
    <form class="form-horizontal collapse collapse" id="register" action="/register/send" method="post">
      <div class="form-group">
        <label for="username">Användarnamn</label>
        <input type="text" class="form-control" id="" name="username"placeholder="Användarnamn" required="">
        <p class="help-block">Help text here.</p>
      </div>
      <div class="form-group">
        <label for="password">Lösenord</label>
        <input type="password" class="form-control" name="password" placeholder="Lösenord" required="">
        <p class="help-block">Help text here.</p>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email" required="">
        <p class="help-block">Verifiering av email görs</p>
      </div>
      <div class="form-group">
        <label for="alias">Alias</label>
        <input type="text" class="form-control" id="" name="alias" placeholder="Alias" required="">
        <p class="help-block">Namn som kommer synas</p>
      </div>
      <div class="form-group">
        <label for="firstname">Förnamn</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Förnamn" required="">
        <p class="help-block">Förnamn</p>
      </div>
      <div class="form-group">
        <label for="surname">Efternamn</label>
        <input type="text" class="form-control" id="surname" name="surname" placeholder="Efternamn" required="">
        <p class="help-block">Efternamn</p>
      </div>
      <div class="form-group">
        <label for="birthday"></label>
        <input type="text" class="form-control" id="birthday" name="birthday" placeholder="yyyy-mm-dd" min="1899-11-28" max="<?php echo date('Y-m-d'); ?>" id="Date" required>
        <p class="help-block">Help text here.</p>
      </div>
      <div class="g-recaptcha" data-sitekey="6Lf6aQgUAAAAAMp-uBJa-Fg6m-tGx04qfUyTYdoN"></div>
      <div class="form-group">
        <a href="/register/terms">terms of agreement:</a>
        <input type="checkbox" name="terms" id="terms">
        <p class="help-block">Help text here.</p>
      </div>

                     

                
      <div class="form-group">
        <input type="submit" class="form-control btn btn-primary" id="" value="Registrera" >
      </div>
    </form>
  </div>
</div>
