<?php $body_class = 'list'; ?>
<?php include_once '_header.php'; ?>
<?php include_once '_nav.php'; ?>
<div class="container">  
	<div class="row header">  
		<div class="span11"><input type="text" placeholder="Item Title" /></div>
		<div class="span1"><a href="posting.php" class="button">Submit</a></div>
	</div>
	<div class="row">  
		<div class="span4">
		<h3>Upload Image</h3>
		<input type="file" placeholder="upload image" />
			<div class="post-image-gallery">
				<div class="subs">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
		</div>
		<div class="span8">
			<div class="row"><div class="span6">Price: $<input type="text" placeholder="0.00" /></div><div class="span2"><input type="checkbox"> Item is a service.</div></div>
			<div class="row"><h3>Item description.</h3> <!-- start slipsum code -->
			<textarea style="width: 100%; height: 300px;">WYSIWYG editor</textarea>
			</div>
			<div class="row"><h3>List in categories:</h3>
			<?php for($i=1;$i<=12;$i++):?>
			<div class="span2"><input type="checkbox"> Category <?php print $i; ?></div>
			<?php endfor; ?>
			</div>
		</div>
	</div>
</div>
<?php include_once '_footer.php'; ?>


