<header>
	<div class="container wrap logo-container">
		<a href="/"><img id="logo" src="<?php print ADMIN_THEME_URL //TODO: Set up to use the logo in the admin panel. ?>/img/logo.png" alt="<?php print SITENAME; ?>" /></a>
	</div>
	<div class="search pull-right">
        <form action="/post/search" method="post">
            <input type="text" name="search_terms" id="search_terms" placeholder="Search" />
            <input type="submit" value="&#xf002;" />
        </form>
    </div> 
</header>