<ul class="opt2">
	<li><a data-toggle="modal" data-target="#modal" href="/post/add" class="add addpost">New Post</a></li>
	<?php if($archive){ ?>
		<li><a href="/post">Active Posts</a></li>
	<?php } else { ?>
		<li><a href="/post/view_archive">Review Archived Posts</a></li>
	<?php } ?>
	<li><a data-toggle="modal" data-target="#modal" href="/user/edit/<?php print $user['ID']; ?>" class="edituser">Author Settings</a></li>
	<li><a href="/user">Users</a></li>
</ul><!-- end opt2 -->