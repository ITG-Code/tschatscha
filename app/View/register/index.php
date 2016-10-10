<form action="/register/send" method="POST">
	<div>
		<label for="Username">Username: </label>
		<input type="text" name="username" placeholder="Username" id="Username" required><br/>
	</div>
	<div>
		<label for="Password">Password: </label>
		<input type="password" name="password" placeholder="Password" id="Password" required><br/>
	</div>
	<div>
		<label for="Email"> E-mail</label>
		<input type="email" name="email" placeholder="Email" id="Email" required><br/>
	</div>
	<div>
		<label for="Alias"> Alias: </label>
		<input type="text" name="alias" placeholder="Alias" id="Alias" required><br/>
	</div>
	<div>
		<label for="Firstname">Firstname: </label>
		<input type="text" name="firstname" placeholder="Firstname" id="Firstname" required><br/>
	</div>
	<div>
		<label for="Surname">Surname: </label>
		<input type="text" name="surname" placeholder="Surname" id="Surname" required><br/>
	</div>
	<div>
		<label for="Date">Date: </label>
		<input type="date" name="birthday" placeholder="yyyy-mm-dd" min="1899-11-28" max="<?php echo date('Y-m-d'); ?>" id="Date" required>
	</div>
    <div>
		<input type="submit" name="submit" value="Register">
	</div>
</form>
