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
					<label for="Title">Titel: </label>
				</td>
				<td>
					<input type="text" name="Title" placeholder="Titel" id="Title" value="<?= isset($data->autoFillPost->title) ? htmlentities($data->autoFillPost->title) :'' ?>" required>
				</td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td>
					<label for="Content">Inlägg: </label>
				</td>
				<td>
					<textarea type="text" name="Content" placeholder="Inläggets innehåll" id="Content" data-provide="markdown" rows="10" cols="40" required><?=isset($data->autoFillPost->content) ? htmlentities($data->autoFillPost->content) : ''?></textarea>
				</td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td>
					<label for="Anon">Tillåt anonyma kommentarer: </label>
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
					<label for="auth">Inlägget är: </label>
				</td>
				  <td>
					         <select name="auth" id="auth">
						               <option value="0" <?php echo (isset($data->autoFillPost->visibility )&& $data->autoFillPost->visibility) == 0 ? "selected": '';?>>Allmänt</option>
						                <option value="1" <?php echo (isset($data->autoFillPost->visibility )&& $data->autoFillPost->visibility) == 1 ? "selected": '';?>>Olistat</option>
						                <option value="3 "<?php echo (isset($data->autoFillPost->visibility )&& $data->autoFillPost->visibility) == 3 ? "selected": '';?>>Privat</option>
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

		<input type="submit" class="btn btn-success" name="submit" value="Redigera inlägget!">
	</div>
</form>
