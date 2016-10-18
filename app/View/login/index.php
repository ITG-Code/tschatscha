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
<script src='https://www.google.com/recaptcha/api.js'></script>
