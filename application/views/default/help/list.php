<?php $CI =& get_instance(); ?>
<?php 
    $admin = FALSE;
    $mainspan = 12;
    if($CI->authenticate->check_auth('administrators')){
        $admin = TRUE;
        $mainspan = 11;
    }
?>
<div id="help-list" class="container-fluid list panel-group">
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
				<div class="panel-heading">
					<h5 class="heading"><a class="panel-group-toggle" data-toggle="collapse" data-parent="#help-list" href="#'.$article->slug.'-posts"><i class="fa fa-chevron-circle-down fa-lg pull-left"></i> '.wildcard_replacements($article->title).'</a>
				';
					if($admin){
						$display .= '
                <div class="edit pull-right">
                    <a href="/help/edit/'.$article->ID.'" class="btn btn-default btn-sm">Edit</a>
                </div>';
					}
					$display .= '
					</h5>
					</div>
				<div id="'.$article->slug.'-posts" class="panel-collapse collapse">';
				$display .= '
		<div class="stripe post panel-body">
		'.wildcard_replacements($article->content).'
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