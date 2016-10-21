Redigera ett inlägg!
<div id="errors">
    <?php foreach ($data->errors as $value) {
        echo $value;
    } ?>
</div>
<form action="/<?= $data->blogname; ?>/editPost" method="POST">
    <input type="hidden" name="newpost" value="<?= isset($data->autoFillPost->id) ? 1: 0?>"/>
	<div class="registerForm">
		<table class="form">
			<tr>
				<td>
					<label for="Title">Title: </label>
				</td>
				<td>
					<input type="text" name="Title" placeholder="Title" id="Title" value="<?= isset($data->autoFillPost->title) ? htmlentities($data->autoFillPost->title) :'' ?>" required>
				</td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td>
					<label for="Content">Content: </label>
				</td>
				<td>
					<textarea type="text" name="Content" placeholder="Content" id="Content" data-provide="markdown" rows="10" cols="40" required><?=isset($data->autoFillPost->content) ? htmlentities($data->autoFillPost->content) : ''?></textarea>
				</td>
			</tr>
			<tr>
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
                            <input type="hidden" name="post_id" value="<?= $data->autoFillPost->id  ?>">
                            <input type="hidden" name="history_id" value="<?= $data->autoFillPost->history_id ?>">
                            <input type="hidden" name="url_title" value="<?= $data->autoFillPost->url_title ?>">
                            <input type="hidden" name="publishing_date" value="<?= $data->autoFillPost->publishing_date ?>">
                            <input type="hidden" name="created_at" value="<?= $data->autoFillPost->created_at ?>">
          </td>
        </tr>
          </table>
					</select>
				</td>
			</tr>
			<tr>
			</tr>

		<input type="submit" name="submit" value="Submit">
	</div>
</form>
