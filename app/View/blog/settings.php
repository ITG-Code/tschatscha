
Give other users authority
Choose blog: 
<form method="post" action="/blog/settings">
	<select name="chooseBlog">
	<?php
	
	$data->blogpicker;

	foreach ($data->blogpicker as $value) {
		echo"<option name='chooseBlog'>".$value->blogName."</option>";
	}
	
	
	?> 
	</select>
	</form>

	<br/>
	<form method="post" action="/blog/settings">	
	<label> Co-writer</label> 
	<input type="radio" name="authority"/></br>
	<label> Private view </label> 
	<input type="radio" name="authority"/></br>
	<label> Moderate </label> 
	<input type="radio" name="authority"/></br>
	<input type="submit" value="Confirm"/>

</form>

<form method="post" action="/blog/settings">
	<label>Sök efter alias</label>
	<input type="text" name="userQuery"/> <input type="submit" value="Search"/>
	</form>
	<div class="searchResult">
	<?php
		$data->usersearch;


	?>
	</div>
