<div id="post-list" class="container list panel-group">
      <div class="row">
          <div class="alert alert-info">
            <button href="#" type="button" class="close" data-dismiss="alert">&times;</button>
            Categories displayed below include <strong>active</strong> listings. For a full overview of all categories, please look under “New Posting.”
        </div>
      </div>
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
			<h4>Seller</h4>
		</div><!-- end col-md-2 -->
		<div class="col-md-1">
			<h4></h4>
		</div><!-- end col-md-1 -->
      </div><!--/row-->
	<?php 
	if($catsposts):
		foreach($catsposts[0] AS $cat){
			if(count($cat->posts)>0 || $cat->has_children):
			print display_cat($catsposts,$cat);
		endif;
		} //end cats 
    endif;?>
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
		<div class="stripe row panel panel-default">
				<div class="col-md-12 panel-heading">
					<h5 class="heading"><a class="panel-group-toggle" data-toggle="collapse" data-parent="#'.$data_parent.'" href="#'.$cat->slug.'-posts"><i class="icon-expand icon-large pull-left"></i> '.$cat->title.'</a></h5>
				</div>
				<div id="'.$cat->slug.'-posts" class="row panel-collapse collapse">';
				foreach($cat->posts AS $post){
				$display .= '
		<div class="stripe post clicky row panel-body" href="/post/view/'.$post->post_id.'">
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
				'.$post->firstname.' '.$post->lastname.'
			</div>
			<div class="col-md-1 edit">';
				if($CI->authenticate->check_auth('administrators')||$CI->common->is_author($user['ID'],$post->author_id)){
					$display .= '<a href="/post/edit/'.$post->post_id.'" class="btn">Edit</a>';
				} 
			$display .= '
			</div>
		</div>';
				} //end posts
			if(isset($cats[$cat->ID])){
				$display .= '<div id="post-list-'.$cat->ID.'" class="list panel-group">			
		<div class="row panel panel-default">
						<div id="'.$cat->slug.'-children" class="post row panel-body">';
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