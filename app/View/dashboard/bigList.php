<div class="col-md-6 col-xs-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
 		 <h3 class="panel-title">Personer som följer dig</h3>
		</div>
		<div class="panel-body">
	  	<table class="myBlogs">
	    	<tr class="myFollowSpace">
	      		<th><b>Namn</b></th>
	      		<th><b>blogg</b></th>
	   		</tr>
	    	<?php foreach ($data->list as $value) { ?>
	      	<tr>
	        	<td>
	        	 	<?= $value->name ?>
	        	</td>
		        <td>
		         	<?= $value->blog_name ?>
		        </td>
		        <td>
			         <form action="/blog/deleteFollower" method="post">
			        	<input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
			            <input type="hidden" name="id" value="<?= $value->id ?>">
			            <input type="submit" class="btn btn-danger" name="deny" value="Ta bort">
			         </form>
		        </td>
	      	</tr>
	      	<?php } ?>
	    </table>
		<?php if(empty($data->list)){?>
		<p class="text-muted">Inga nya förfrågningar</p>
		<?php } ?>
	    </div>
  	</div>
</div>

<div class="col-md-6 col-xs-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
 		 <h3 class="panel-title">Följningsförfrågningar</h3>
		</div>
		<div class="panel-body">
	  	<table class="myBlogs">
	    	<tr class="myFollowSpace">
	      		<th><b>Namn</b></th>
	      		<th><b>blogg</b></th>
	   		</tr>
	    	<?php foreach ($data->acceptlist as $value) { ?>
	      	<tr>
	        	<td>
	        	 	<?= $value->name ?>
	        	</td>
		        <td>
		         	<?= $value->blog_name ?>
		        </td>
		        <td>
		        	<form action="/blog/acceptFollower" method="post">
		            	<input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
		            	<input type="hidden" name="id" value="<?= $value->id ?>">
		            	<input type="submit" class="btn btn-success" name="accept" value="Godkänd">
		          	</form>
		        </td>
		        <td>
			         <form action="/blog/deleteFollower" method="post">
			        	<input type="hidden" name="blog_id" value="<?= $value->blog_id ?>">
			            <input type="hidden" name="id" value="<?= $value->id ?>">
			            <input type="submit" class="btn btn-danger" name="deny" value="Ta bort">
			         </form>
		        </td>
	      	</tr>
	      	<?php } ?>
	    </table>
		<?php if(empty($data->acceptlist)){?>
		<p class="text-muted">Inga nya förfrågningar</p>
		<?php } ?>
	    </div>
  	</div>
</div>
