<?php $CI =& get_instance(); ?>
<div id="help-list" class="container-fluid list accordion">
	<?php 
		foreach($articles AS $article){
			


			$display = '
		<div class="stripe row-fluid accordion-group">
				<div class="span11 accordion-heading">
					<h5 class="heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#help-list" href="#'.$article->slug.'-posts"><i class="icon-expand icon-large pull-left"></i> '.$article->title.'</a></h5>
				</div>
				<div class="span1 edit">';
					if($CI->authenticate->check_auth('super-administrators')){
						$display .= '<a href="/help/edit/'.$article->ID.'" class="btn">Edit</a>';
					}
					$display .= '
				</div>
				<div id="'.$article->slug.'-posts" class="row-fluid accordion-body collapse">';
				$display .= '
		<div class="stripe post row-fluid accordion-inner span12">
		'.$article->content.'
		</div>';
			$display .= '
				</div>
			</div>';
			print $display;
		} //end cats 
		
		?>

	<div id="footer" class="row">
	</div><!-- end footer -->

    </div><!--/.fluid-container-->