<?php if($this->authenticate->check_auth('users')): ?>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- mobile display -->
    <div class="navbar-header hidden-sm hidden-md hidden-lg">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Menu</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="/">All Postings</a></li>
        <li><a href="/post/user/<?php print $user['ID']; ?>">My Postings</a></li>
        <li><a href="/post/add">New Posting</a></li>
        <?php if($this->authenticate->check_auth('administrators')){ ?>
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Administrate <b class="caret"></b></a>
                    <ul class="dropdown-menu fa-ul">
                        <?php if($this->authenticate->check_auth('super-administrators')){ ?>
                        <li><a href="/org">Organizations</a></li>
                        <li><a href="/org/add"><i class="fa fa-plus-square"></i> Add New</a></li>
                        <li class="divider"></li>
                        <li><a href="/help">Help</a></li>
                        <li><a href="/help/add"><i class="fa fa-plus-square"></i> Add New</a></li>
                        <li class="divider"></li>
                        <?php } ?>
                        <li><a href="/category">Categories</a></li>
                        <li><a href="/category/add"><i class="fa fa-plus-square"></i> Add New</a></li>
                        <li class="divider"></li>
                        <li><a href="/user">Users</a></li>
                        <li><a href="/user/add"><i class="fa fa-plus-square"></i> Add New</a></li>
                    </ul>
                </li>
            <?php } ?>
        <li><a href="/user/edit/<?php print $user['ID']; ?>">Account Settings</a></li>
        <li><a href="/help">Help</a></li>
      </ul>
      <?php if($this->authenticate->check_auth()): ?>
      <form class="navbar-form navbar-left" role="search" action="/post/search" method="post">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search_terms" id="search_terms">
        </div>
        <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
      </form>
      <?php endif; ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/user/edit/<?php print $user['ID']; ?>" class="edituser">Welcome back, <?php print $user['firstname']; ?></a></li>
        <li>
          <a id="logout" class="btn btn-default btn-sm" href="/login/logout">Log Out</a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php endif; ?>	