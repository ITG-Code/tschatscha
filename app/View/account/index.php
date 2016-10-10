<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<div class="wrapper">
	<form action="/account/send" method="POST">
		<div>
			<table class="form">
				<tr>
					<td><label for="alias">Change alias</label></td>
					<td><input type="text" name="alias" id="alias"></td>
				</tr>
				<tr>
					<td><label for="email">Change email</label></td>
					<td><input type="email" name="email" id="email"></td>
				</tr>
				<tr>
					<td><label for="newPassword">Change password</label></td>
					<td><input type="password" name="newPassword" id="newPassword"></td>
				</tr>
				<tr>
					<td><label for="confirmPassword">Confirm change password</label></td>
					<td><input type="password" name="confirmPassword" id="confirmPassword"></td>
				</tr>
				<tr>
					<td><label for="nsfw">Is your blog NSFW?</label></td>
					<td><input type="checkbox" name="nsfw" id="nsfw" value="1"></td>
				</tr>
				<tr>
					<td><label for="password"> Confirmation Password</label></td>
					<td><input type="password" name="oldPassword" id="password"></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="change">
		</div>
	</form>
</div>
