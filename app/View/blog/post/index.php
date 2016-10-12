Skapa en post
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://www.codingdrama.com/bootstrap-markdown/js/to-markdown.js"></script>
<script type="text/javascript" src="http://www.codingdrama.com/bootstrap-markdown/js/markdown.js"></script>
<script type="text/javascript" src="/js/bootstrap-markdown.js"></script>

<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/bootstrap-markdown.min.css">
<div id="errors">
<?php foreach($data->errors as $value){
	echo $value;
} ?>
</div>
<form action="/<?php echo $data->blogname; ?>/sendPost" method="POST">
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
					<input type="text" name="Url" placeholder="Url-title" id="Url"
					required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Content">Content: </label>
				</td>
				<td>
					<textarea type="text" name="Content" placeholder="Content" id="Content" data-provide="markdown" rows="10" cols="40" required></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Date">Publishing-day: </label>
				</td>
				<td>
					<input type="datetime-local" name="Date"  value="<?php echo date('Y-m-d H:i'); ?>" placeholder="yyyy-mm-dd hh:mm" min="<?php echo date('Y-m-d H:i'); ?>" id="Date" required>
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
