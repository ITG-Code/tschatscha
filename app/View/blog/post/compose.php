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
					<label for="Title">Titel: </label>
				</td>
				<td>
					<input type="text" name="Title" placeholder="Titel" id="Title" value="<?=isset($data->autoFillPost->title) ? $data->autoFillPost->title : ''?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Url">Url-titel: </label>
				</td>
				<td>
					<input type="text" name="Url" placeholder="Url-titel" id="Url" value="<?=isset($data->autoFillPost->url_title) ? $data->autoFillPost->url_title : ''?>"
					required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Content">Inlägg: </label>
				</td>
				<td>
					<textarea type="text" name="Content" placeholder="Inläggets innehåll" id="Content" data-provide="markdown" rows="10" cols="40" required><?=isset($data->autoFillPost->content) ? $data->autoFillPost->content : ''?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Date">Publiceringsdatum: </label>
				</td>
				<td>
					<input type="datetime-local" name="Date"  value="<?=isset($data->autoFillPost->publishing_date) ? $data->autoFillPost->publishing_date : date('Y-m-d H:i')?>" placeholder="åååå-mm-dd hh:mm"  id="Date" >
				</td>
			</tr>
			<tr>
				<td>
					<label for="Anon">Tillåt anonyma tittare: </label>
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
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Tags">Taggar: </label>
				</td>
				<td>
					<input type="text" name="Tags" placeholder="Ex. Party, Holiday" id="Tags">
				</td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</div>
</form>
