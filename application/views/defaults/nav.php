				<div id="logo">
					<a href="/"><img src="/assets/images/production/logo.png" alt="<?php print SITENAME; ?>" /></a></div>
				<ul id="nav" class="center">
				  	<?php if($this->authenticate->check_auth('users')){ ?>
				  	<li class="logout"><a href="/login/logout">Logout</a></li>
				  	<?php } else { ?>
				  	<li class="login"><a href="/login">Login</a></li>
				  	<?php } ?>	
				  	<?php if($this->authenticate->check_auth('users')){ ?>
					  	<?php if(isset($this->session->userdata['user_access'])){ ?>
					  	<li class="highlight"><a href="/account/index">My Account</a></li>
						<?php } ?>
				  	<?php } else { ?>
				  	<li class="signup"><a title="Free Signup" href="/register"></a></li>
				  	<?php } ?>	
				</ul>