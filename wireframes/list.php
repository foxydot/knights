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
		<div class="span3">Poster</div>
	</div>
	
	<?php for($j=1;$j<5;$j++): ?>
	<div class="row category parent">  
		<div class="span12">Category <?php print $j; ?></div>
		<?php for($i=1;$i<5;$i++): ?>
		<div class="row child stripe listing">  
			<div class="span1 subs"><div></div></div>
			<div class="span4"><a href="posting.php">Item <?php print $i;?></a></div>
			<div class="span2">$50.00</div>		
			<div class="span2"><?php print date('m/d/Y'); ?></div>		
			<div class="span3">Poster Name</div>
		</div>
		<?php endfor; ?>
	</div>
	<?php endfor; ?>
</div>
<?php include_once '_footer.php'; ?>


