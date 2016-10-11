Skapa en post

<form action="/register/send" method="POST">
	<div class="registerForm">
		<table class="form">
			<tr>
				<td>
					<label for="Title">Title: </label>
				</td>
				<td>
					<input type="text" name="Title" placeholder="Title" id="Title" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Url">Url-title: </label>
				</td>
				<td>
					<input type="text" name="Url" placeholder="Url-title" id="Url" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Content">Content: </label>
				</td>
				<td>
					<input type="textarea" class="md-editor" name="Content" placeholder="Content" id="Content" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Date">Publishing-day: </label>
				</td>
				<td>
					<input type="date" name="Date" placeholder="yyyy-mm-dd" min="<?php echo date('Y-m-d'); ?>" id="Date" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Anon">Allow anonymous viewers: </label>
				</td>
				<td>
					<input type="checkbox" name="Anon" id="Anon">
				</td>
			</tr>
			<tr>
				<td>
					<label for="auth">authority view: </label>
				</td>
				<td>
					<select name="auth" id="auth">
						<option value="0">Public</option>
						<option value="1">Unlisted</option>
						<option value="3">Private</option>
					</select>
				</td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Register">	
	</div>
</form>