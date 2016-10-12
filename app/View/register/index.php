<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<form action="/register/send" method="POST">
	<div class="registerForm">
	<table class="form">
		<tr>
			<td>
		<label for="Username">Username: </label>
			</td>
			<td>
		<input type="text" name="username" placeholder="Username" id="Username" required>
			</td>
		</tr>
		<tr>
			<td>
		<label for="Password">Password: </label>
			</td>
			<td>
		<input type="password" name="password" placeholder="Password" id="Password" required>
			</td>
		</tr>
		<tr>
			<td>
		<label for="Email"> E-mail</label>
			</td>
			<td>
		<input type="email" name="email" placeholder="Email" id="Email" required>
			</td>
		</tr>
		<tr>
			<td>
		<label for="Alias"> Alias: </label>
			</td>
			<td>
		<input type="text" name="alias" placeholder="Alias" id="Alias" required>
			</td>
		</tr>
		<tr>
			<td>
		<label for="Firstname">Firstname: </label>
			</td>
			<td>
		<input type="text" name="firstname" placeholder="Firstname" id="Firstname" required>
			</td>
		</tr>
		<tr>
			<td>
		<label for="Surname">Surname: </label>
			</td>
			<td>
		<input type="text" name="surname" placeholder="Surname" id="Surname" required>
			</td>
		</tr>
		<tr>
			<td>
		<label for="Date">Date: </label>
			</td>
			<td>
		<input type="date" name="birthday" placeholder="yyyy-mm-dd" min="1899-11-28" max="<?php echo date('Y-m-d'); ?>" id="Date" required>
			</td>
		</tr>
	</table>
		<input type="submit" name="submit" value="Register">
		
	</div>
</form>
