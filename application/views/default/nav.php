<div id="nav" class="navbar">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="nav-collapse collapse">
            <h5 class="navbar-text pull-right">
            	Welcome back, <a href="/user/edit/<?php print $user['ID']; ?>" class="edituser navbar-link"><?php print $user['firstname']; ?><a/>
            	<a id="logout" class="btn btn-small" href="/login/logout">Log Out</a>
            </h5>
          <ul class="nav">
		    <li><a href="/">All Postings</a></li>
		    <li><a href="/post/user/<?php print $user['ID']; ?>">Your Postings</a></li>
		    <li><a href="/post/add">New Posting</a></li>
		    <?php if($this->authenticate->check_auth('administrators')){ ?>
		    	<li class="dropdown">
		    	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Administrate</a>
			    	<ul class="dropdown-menu">
			    		<?php if($this->authenticate->check_auth('super-administrators')){ ?>
			    		<li class="dropdown-submenu"><a href="/org">Organizations</a>
			    			<ul class="dropdown-menu">
			    				<li><a href="/org/add">Add New</a></li>
			    			</ul>
			    		</li>
			    		<?php } ?>
			    		<li class="dropdown-submenu"><a href="/category">Categories</a>
			    			<ul class="dropdown-menu">
			    				<li><a href="/category/add">Add New</a></li>
			    			</ul>
			    		</li>
			    		<li class="dropdown-submenu"><a href="/user">Users</a>
			    			<ul class="dropdown-menu">
			    				<li><a href="/user/add">Add New</a></li>
			    			</ul>
			    		</li>
			    		
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