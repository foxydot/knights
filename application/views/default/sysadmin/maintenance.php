	<div class="container-fluid">
	    <ul class="list col-md-6 col-md-offset-3">
		<li><strong>Last Updated:</strong> <?php print date("m.d.Y",$system_info['last_update']); ?></li>
		<li><strong>Current Version:</strong> <?php print $system_info['version']; ?></li>
	<?php if($system_info['version']==$update_database_version){ ?>
	<li>Database is updated to the current revision.</li>
	<?php } else { ?>
	<li>
<form method="post">
<input type="hidden" name="doit" value="doit" />Update Database to Version <?php print $update_database_version; ?>?
<input type="submit" value="YES">
</form></li>
	<?php } ?>
        <li><a href="/sysadmin/backup_db" class="btn btn-default">Backup Database</a></li>
    	<li><a href="/sysadmin/edit_post_types" class="btn btn-default">Edit Post Types</a></li>
	</ul>
</div>