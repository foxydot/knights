<div id="post-list" class="container-fluid list accordion">
      <div class="header row-fluid">
        <div class="span1">
			<h4>Listing Number</h4>
		</div><!-- end span3 -->
        <div class="span1">
			<h4>Photo</h4>
		</div><!-- end span3 -->
        <div class="span3">
			<h4>Title</h4>
		</div><!-- end span3 -->
		<div class="span1">
			<h4>Price</h4>
		</div><!-- end span1 -->
		<div class="span2">
			<h4>Date Added</h4>
		</div><!-- end span2 -->
		<div class="span2">
			<h4>Categories</h4>
		</div><!-- end span2 -->
		<div class="span1">
			<h4></h4>
		</div><!-- end span1 -->
      </div><!--/row-->
	<?php 
		foreach($posts AS $post){
			print display_post($post);
		} //end cats ?>

	<div id="footer" class="row">
	</div><!-- end footer -->

    </div><!--/.fluid-container-->
    
<?php function display_post($post){
	$display = FALSE;
	setlocale(LC_MONETARY, 'en_US');
		$CI =& get_instance();
		$postcats = '';
		foreach($post->categories AS $cat){
			$postcats .= '<li>'.$cat->catpath.'</li>';
		}
				$display .= '
		<div class="stripe post clicky row-fluid" href="/post/view/'.$post->post_id.'">
			<div class="span1 id">
				'.str_pad((string)$post->post_id,8,'0',STR_PAD_LEFT).'
			</div>
			<div class="span1 id">';
				if(isset($post->attachments[0])){
					$display .= '<img src="'.$post->attachments[0]->attachment_url.'" style="height: 50px;width:50px;" />';
				}
			$display .= '
			</div>
			<div class="span3 title">
				'.$post->title.'
			</div>
			<div class="span1 price">
				'.money_format('%#1.2n', (float) $post->cost).'
			</div>
			<div class="span2 date-added">
				'.date("F j, Y",$post->dateadded).'
			</div>
			<div class="span2 author">
				<ul>'.$postcats.'</ul>
			</div>
			<div class="span1 edit">';
				if($CI->authenticate->check_auth('administrators')||$CI->common->is_author($user['ID'],$post->author_id)){
					$display .= '<a href="/post/edit/'.$post->post_id.'" class="btn">Edit</a>';
				} 
			$display .= '
			</div>
		</div>';
	return $display;
}?>