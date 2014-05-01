<?php $body_class = 'list'; ?>
<?php include_once '_header.php'; ?>
<?php include_once '_nav.php'; ?>
<div class="container">
	<div class="row tabs">
	</div>
	<div class="row header">  
		<div class="col-md-1"></div>
		<div class="col-md-4">Item Title</div>
		<div class="col-md-2">Price</div>
		<div class="col-md-2">Date Posted</div>		
		<div class="col-md-3">Categories</div>
	</div>
	
	<div class="row category parent">  
		<div class="col-md-12">Active Postings</div>
		<?php for($i=1;$i<=5;$i++): ?>
		<div class="row child stripe listing">  
			<div class="col-md-1 subs"><div></div></div>
			<div class="col-md-4"><a href="edit-posting.php">Item <?php print $i;?></a></div>
			<div class="col-md-2">$50.00</div>		
			<div class="col-md-2"><?php print date('m/d/Y'); ?></div>		
			<div class="col-md-3">Category1, Category2</div>
		</div>
		<?php endfor; ?>
	</div>
	<div class="row category parent">  
		<div class="col-md-12">Draft Postings</div>
		<?php for($i=1;$i<=3;$i++): ?>
		<div class="row child stripe listing">  
			<div class="col-md-1 subs"><div></div></div>
			<div class="col-md-4"><a href="edit-posting.php">Item <?php print $i;?></a></div>
			<div class="col-md-2">$50.00</div>		
			<div class="col-md-2"><?php print date('m/d/Y'); ?></div>		
			<div class="col-md-3">Category1, Category2</div>
		</div>
		<?php endfor; ?>
	</div>
</div>
<?php include_once '_footer.php'; ?>


