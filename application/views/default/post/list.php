<div id="post-list" class="container-fluid list">
      <div class="header row">
        <div class="col-md-1">
			<h4>Listing Number</h4>
		</div><!-- end col-md-3 -->
        <div class="col-md-1">
			<h4>Photo</h4>
		</div><!-- end col-md-3 -->
        <div class="col-md-3">
			<h4>Title</h4>
		</div><!-- end col-md-3 -->
		<div class="col-md-1">
			<h4>Price</h4>
		</div><!-- end col-md-1 -->
		<div class="col-md-2">
			<h4>Date Added</h4>
		</div><!-- end col-md-2 -->
		<div class="col-md-2">
			<h4>Categories</h4>
		</div><!-- end col-md-2 -->
		<div class="col-md-1">
			<h4></h4>
		</div><!-- end col-md-1 -->
      </div><!--/row-->
	<?php 
	if(count($posts)>0){
		foreach($posts AS $post){
			print display_post($post,$user);
		} //end cats
    } else {
        print '<div class="row">
            <div class="col-md-12">
                You have no posts on '.SITENAME.'.
            </div>
        </div>';
    }	 ?>

	<div id="footer" class="row">
	</div><!-- end footer -->

    </div><!--/.fluid-container-->
    
<?php function display_post($post,$user){
    global $org_id;
	$display = FALSE;
	setlocale(LC_MONETARY, 'en_US');
		$CI =& get_instance();
		$postcats = '';
		foreach($post->categories AS $cat){
			$postcats .= '<li>'.$cat->catpath.'</li>';
		}
				$display .= '
		<div class="stripe post clicky row" href="/post/view/'.$post->post_id.'">
			<div class="col-md-1 id">
				'.str_pad((string)$post->post_id,8,'0',STR_PAD_LEFT).'
			</div>
			<div class="col-md-1 id">';
				if(isset($post->attachments[0])){
					$display .= '<img src="'.$post->attachments[0]->attachment_url.'" style="height: 50px;width:50px;" />';
				}
			$display .= '
			</div>
			<div class="col-md-3 title">
				'.$post->title.'
			</div>
			<div class="col-md-1 price">
				'.money_format('%#1.2n', (float) $post->cost).'
			</div>
			<div class="col-md-2 date-added">
				'.date("F j, Y",$post->dateadded).'
			</div>
			<div class="col-md-2 author">
				<ul>'.$postcats.'</ul>
			</div>
			<div class="col-md-1 edit">';
				if($CI->authenticate->check_auth('administrators')||$CI->common->is_author($user['ID'],$post->author_id)){
					$display .= '<a href="/post/edit/'.$post->post_id.'" class="pull-right btn btn-sm btn-default">Edit</a>';
				} 
			$display .= '
			</div>
		</div>';
	return $display;
}?>