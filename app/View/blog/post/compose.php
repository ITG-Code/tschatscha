Skapa en post
<div id="errors">
    <?php foreach ($data->errors as $value) {
        echo $value;
    } ?>
</div>
<form action="/<?php echo $data->blogname; ?>/sendPost" method="POST">
    <input type="hidden" name="newpost" value="<?= isset($data->autoFillPost->id) ? 1: 0?>"/>
	<div class="registerForm">
		<table class="form">
			<tr>
				<td>
					<label for="Title">Title: </label>
				</td>
				<td>
					<input type="text" name="Title" placeholder="Title" id="Title" value="<?=isset$data-> ? $data->autoFillPost->title : ''?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Url">Url-title: </label>
				</td>
				<td>
					<input type="text" name="Url" placeholder="Url-title" id="Url" value="<?=isset($data->autoFillPost->title) ? $data->autoFillPost->url_title : ''?>"
					required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Content">Content: </label>
				</td>
				<td>
					<textarea type="text" name="Content" placeholder="Content" id="Content" data-provide="markdown" rows="10" cols="40" required><?=isset($data->autoFillPost->content) ? $data->autoFillPost->content : ''?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Date">Publishing-day: </label>
				</td>
				<td>
					<input type="datetime-local" name="Date"  value="<?=isset($data->autoFillPost->publishing_date) ? $data->autoFillPost->publishing_date : date('Y-m-d H:i')?>" placeholder="yyyy-mm-dd hh:mm"  id="Date" >
				</td>
			</tr>
			<tr>
				<td>
					<label for="Anon">Allow anonymous viewers: </label>
				</td>
				<td>
                    <?php if(isset($data->autoFillPost->checked) && $data->autoFillPost->checked == 1) { ?>
					    <input type="checkbox" name="Anon" id="Anon" checked>
                    <?php } elseif(isset($data->autoFillPost->checked) && $data->autoFillPost->checked == 0) { ?>
                        <input type="checkbox" name="Anon" id="Anon">
                    <?php }else{ ?>
                        <input type="checkbox" name="Anon" id="Anon" checked>
                    <?php } ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="auth">authority view: </label>
				</td>
				<td>
					<select name="auth" id="auth">
						<option value="0" <?php echo (isset($data->autoFillPost->visibility )&& $data->autoFillPost->visibility) == 0 ? "selected": '';?>>Public</option>
						<option value="1" <?php echo (isset($data->autoFillPost->visibility )&& $data->autoFillPost->visibility) == 1 ? "selected": '';?>>Unlisted</option>
						<option value="3 "<?php echo (isset($data->autoFillPost->visibility )&& $data->autoFillPost->visibility) == 3 ? "selected": '';?>>Private</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Tags">Tags: </label>
				</td>
				<td>
					<input type="text" name="Tags" placeholder="Ex. Party, Holiday" id="Tags">
				</td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</div>
</form>
