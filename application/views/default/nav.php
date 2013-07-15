<?php /* ?>
<ul class="opt2">
	<li><a data-toggle="modal" data-target="#modal" href="/post/add" class="add addpost">New Post</a></li>
	<?php if($archive){ ?>
		<li><a href="/post">Active Posts</a></li>
	<?php } else { ?>
		<li><a href="/post/view_archive">Review Archived Posts</a></li>
	<?php } ?>
	<li><a href="/user">Users</a></li>
</ul><!-- end opt2 -->

<?php */ ?>

<div class="navbar">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="nav-collapse collapse">
            <h5 class="navbar-text pull-right">
            	Welcome back, <a data-toggle="modal" data-target="#modal" href="/user/edit/<?php print $user['ID']; ?>" class="edituser navbar-link"><?php print $user['firstname']; ?><a/>
            	<a id="logout" href="/login/logout">Log Out</a>
            </h5>
          <ul class="nav">
		    <li><a href="/wireframes/list.php">All Postings</a></li>
		    <li><a href="/wireframes/list-edit.php">Your Postings</a></li>
		    <li><a href="/wireframes/edit-posting.php">New Posting</a></li>
		    <li><a href="/wireframes/user.php">Account Settings</a></li>
		    <li><a href="/wireframes/help.php">Help</a></li>
		    </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>		