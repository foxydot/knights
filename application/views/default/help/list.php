<?php $CI =& get_instance(); ?>
<?php 
    $admin = FALSE;
    $mainspan = 12;
    if($CI->authenticate->check_auth('administrators')){
        $admin = TRUE;
        $mainspan = 11;
    }
?>
<div id="help-list" class="container list panel-group">
	<?php 
		foreach($articles AS $article){
			$display = '
		<div class="stripe row panel panel-default sortable">';
                    /*if($admin){
                        $display .= '
                        <div class="col-md-1 edit">
                            <col-md- class="ui-icon ui-icon-arrowthick-2-n-s"></col-md->
                        </div>';
                    }*/
                    $display .= '
				<div class="col-md-'.$mainspan.' panel-heading">
					<h5 class="heading"><a class="panel-group-toggle" data-toggle="collapse" data-parent="#help-list" href="#'.$article->slug.'-posts"><i class="icon-expand icon-large pull-left"></i> '.$article->title.'</a></h5>
				</div>';
					if($admin){
						$display .= '
                <div class="col-md-1 edit">
                    <a href="/help/edit/'.$article->ID.'" class="btn">Edit</a>
                </div>';
					}
					$display .= '
				<div id="'.$article->slug.'-posts" class="row panel-collapse collapse">';
				$display .= '
		<div class="stripe post row panel-body col-md-12">
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