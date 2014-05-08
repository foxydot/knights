	<ul class="list">
		<li><strong>Last Updated:</strong> <?php print date("m.d.Y",$system_info['last_update']); ?></li>
		<li><strong>Current Version:</strong> <?php print $system_info['version']; ?></li>
		<li><a href="/install/backup_db">Backup Database</a></li>
	<?php if($system_info['version']==$update_database_version){ ?>
	<li>Database is updated to the current revision.</li>
	<?php } else { ?>
	<li>
<form method="post">
<input type="hidden" name="doit" value="doit" />Update Database to Version <?php print $update_database_version; ?>?
<input type="submit" value="YES">
</form></li>
	<?php } ?>
	</ul>
