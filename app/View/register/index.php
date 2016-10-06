<form action="/register/send" method="POST">

	<input type="text" name="username" placeholder="Username" required><br/>
	<input type="password" name="password" placeholder="Password" required><br/>
	<input type="email" name="email" placeholder="Email" required><br/>
	<input type="text" name="alias" placeholder="Alias" required><br/>
	<input type="text" name="firstname" placeholder="Firstname" required><br/>
	<input type="text" name="surname" placeholder="Surname" required><br/>
	<input type="date" name="birthday" placeholder="yyyy-mm-dd" min="1899-11-28" max="<?php echo date('Y-m-d');?>" required><br/>
	<input type="submit" name="submit">
</form>
