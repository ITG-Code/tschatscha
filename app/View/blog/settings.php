
Give other users authority
<form method="post" action="blog/setAuthority">
	Choose blog: <select name="blog_id">
	<option value="blog_id" name="myBlogs"> Här kommer bloggnamnen dyka upp  </option>
	</select>
	<br/>
	<label> Co-writer</label> 
	<input type="radio" name="authority"/></br>
	<label> Private view </label> 
	<input type="radio" name="authority"/></br>
	<label> Moderate </label> 
	<input type="radio" name="authority"/></br>
	<input type="submit" value="Confirm"/>

</form>

<form method="post" action="userModel/searchForUser">
	<label>Sök efter alias</label>
	<input type="search" name="userQuery"/> <input type="submit" value="Search"/>
	<div class="searchResult">
	
	</div>
	</form>