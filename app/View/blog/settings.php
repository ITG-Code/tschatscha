<form method="post" action="blog/setAuthority">
	<label> Co-writer</label> 
	<input type="radio" name="authority"/></br>
	<label> Private view </label> 
	<input type="radio" name="authority"/></br>
	<label> Moderate </label> 
	<input type="radio" name="authority"/></br>
	<input type="submit" value="Confirm"/>
</form>

<form method="post" action="UserModel/searchForUser">
	<label>Sök efter alias</label>
	<input type="search" name="userQuery"/> <input type="submit" value="Search"/>
	<div class="searchResult">
<!-- 	<?php
	$searchResult;
	?> -->
	</div>
	</form>