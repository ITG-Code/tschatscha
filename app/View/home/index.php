<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="row">
  <div class="col-md-8">
    <ul>
      <?php
      foreach ($data->bloglist as $blog) {
          echo "<ul>";

          echo "<a href=\"/{$blog->url_name}\">{$blog->name}</a> - ";
          if (!isset($blog->first_name)) {
              echo "{$blog->first_name} \"{$blog->alias}\" {$blog->sur_name}";
            } else {
                echo $blog->alias;
            }
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
        <p class="help-block"></p>
      </div>
      <div class="form-group">
        <label for="password">Lösenord</label>
        <input type="password" class="form-control" id="" name="password" placeholder="Lösenord" required="">
        <p class="help-block"></p>
      </div>
      <a href="/register/index">Inte registerad?</a>
      <div class="g-recaptcha" id="g-recaptcha-login" data-sitekey="6Lf6aQgUAAAAAMp-uBJa-Fg6m-tGx04qfUyTYdoN"></div>
      <div class="form-group">
        <input type="submit" name="login" value="Logga in" class="btn btn-primary">
      </div>
    </form>

  </div>
</div>
