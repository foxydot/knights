<?php $body_class = 'list'; ?>
<?php include_once '_header.php'; ?>
<?php include_once '_nav.php'; ?>
<div class="container">
	<div class="row tabs">
	</div>
	<div class="row header">  
		<div class="span1"></div>
		<div class="span4">Item Title</div>
		<div class="span2">Price</div>
		<div class="span2">Date Posted</div>		
		<div class="span3">Categories</div>
	</div>
	
	<div class="row category parent">  
		<div class="span12">Active Postings</div>
		<?php for($i=1;$i<=5;$i++): ?>
		<div class="row child stripe listing">  
			<div class="span1 subs"><div></div></div>
			<div class="span4"><a href="edit-posting.php">Item <?php print $i;?></a></div>
			<div class="span2">$50.00</div>		
			<div class="span2"><?php print date('m/d/Y'); ?></div>		
			<div class="span3">Category1, Category2</div>
		</div>
		<?php endfor; ?>
	</div>
	<div class="row category parent">  
		<div class="span12">Draft Postings</div>
		<?php for($i=1;$i<=3;$i++): ?>
		<div class="row child stripe listing">  
			<div class="span1 subs"><div></div></div>
			<div class="span4"><a href="edit-posting.php">Item <?php print $i;?></a></div>
			<div class="span2">$50.00</div>		
			<div class="span2"><?php print date('m/d/Y'); ?></div>		
			<div class="span3">Category1, Category2</div>
		</div>
		<?php endfor; ?>
	</div>
</div>
<?php include_once '_footer.php'; ?>


