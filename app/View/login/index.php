<form action="/login/send" method="post">
	<div>
		<label for="username">Username: </label>
		<input type="text" name="username" placeholder="username" id="username" required><br/>	
	</div>
	<div>
		<label for="password">Password: </label>
		<input type="password" name="password" placeholder="password" id="password" required><br/>	
	</div>
	<div class="g-recaptcha" data-sitekey="6Lf6aQgUAAAAAMp-uBJa-Fg6m-tGx04qfUyTYdoN"></div>
	<div>
		<input type="submit" name="login" value="Login"><br/>	
	</div>
</form>
<script src='https://www.google.com/recaptcha/api.js'></script>