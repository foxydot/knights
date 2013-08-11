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
			<h4>Poster</h4>
		</div><!-- end span2 -->
		<div class="span1">
			<h4></h4>
		</div><!-- end span1 -->
      </div><!--/row-->
	<?php 
		foreach($catsposts[0] AS $cat){
			if(count($cat->posts)>0 || $cat->has_children):
			print display_cat($catsposts,$cat);
		endif;
		} //end cats ?>

	<div id="footer" class="row">
	</div><!-- end footer -->

    </div><!--/.fluid-container-->
    
<?php function display_cat($cats,$cat,$level=0){
	$display = FALSE;
	setlocale(LC_MONETARY, 'en_US');
	if(count($cat->posts)>0 || $cat->has_children):
		$CI =& get_instance();
		$data_parent = $level>0?'post-list-'.$cat->ID:'post-list';
		$display = '
		<div class="stripe row-fluid accordion-group">
				<div class="span12 accordion-heading">
					<h5 class="heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$data_parent.'" href="#'.$cat->slug.'-posts"><i class="icon-expand icon-large pull-left"></i> '.$cat->title.'</a></h5>
				</div>
				<div id="'.$cat->slug.'-posts" class="row-fluid accordion-body collapse">';
				foreach($cat->posts AS $post){ 
				$display .= '
		<div class="stripe post clicky row-fluid accordion-inner" href="/post/view/'.$post->post_id.'">
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
				'.$post->firstname.' '.$post->lastname.'
			</div>
			<div class="span1 edit">';
				if($CI->authenticate->check_auth('administrators')||$CI->common->is_author($user['ID'],$post->author_id)){
					$display .= '<a href="/post/edit/'.$post->post_id.'" class="btn">Edit</a>';
				} 
			$display .= '
			</div>
		</div>';
				} //end posts
			if(isset($cats[$cat->ID])){
				$display .= '<div id="post-list-'.$cat->ID.'" class="list accordion">			
		<div class="row-fluid accordion-group">
						<div id="'.$cat->slug.'-children" class="post row-fluid accordion-inner">';
				foreach($cats[$cat->ID] AS $c){
					$display .= display_cat($cats,$c,$level+1);
				}
				$display .= '</div>
					</div>
				</div>';
			}
			$display .= '
				</div>
			</div>';
		endif;
	return $display;
}?>