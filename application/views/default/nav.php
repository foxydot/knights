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

<div id="nav" class="navbar">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="nav-collapse collapse">
            <h5 class="navbar-text pull-right">
            	Welcome back, <a data-toggle="modal" data-target="#modal" href="/user/edit/<?php print $user['ID']; ?>" class="edituser navbar-link"><?php print $user['firstname']; ?><a/>
            	<a id="logout" href="/login/logout">Log Out</a>
            </h5>
          <ul class="nav">
		    <li><a href="/">All Postings</a></li>
		    <li><a href="/post/user/<?php print $user['ID']; ?>">Your Postings</a></li>
		    <li><a href="/post/add">New Posting</a></li>
		    <?php if($this->authenticate->check_auth('administrators',true)){ ?>
		    	<li class="dropdown">
		    	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Administrate</a>
			    	<ul class="dropdown-menu">
			    		<?php if($this->authenticate->check_auth('super-administrators',true)){ ?>
			    		<li><a href="/org">Organizations</a></li>
			    		<?php } ?>
			    		<li><a href="/category">Categories</a></li>
			    		<li><a href="/user">Users</a></li>
			    		
			    	</ul>
		    	</li>
		    <?php } ?>
		    <li><a href="/user/edit/<?php print $user['ID']; ?>">Account Settings</a></li>
		    <li><a href="/help">Help</a></li>
		    </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>		