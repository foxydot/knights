<?php $CI =& get_instance(); ?>
<?php 
    $admin = FALSE;
    $mainspan = 12;
    if($CI->authenticate->check_auth('administrators')){
        $admin = TRUE;
        $mainspan = 11;
    }
?>
<div id="help-list" class="container-fluid list accordion">
	<?php 
		foreach($articles AS $article){
			$display = '
		<div class="stripe row-fluid accordion-group sortable">';
                    /*if($admin){
                        $display .= '
                        <div class="span1 edit">
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        </div>';
                    }*/
                    $display .= '
				<div class="span'.$mainspan.' accordion-heading">
					<h5 class="heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#help-list" href="#'.$article->slug.'-posts"><i class="icon-expand icon-large pull-left"></i> '.$article->title.'</a></h5>
				</div>';
					if($admin){
						$display .= '
                <div class="span1 edit">
                    <a href="/help/edit/'.$article->ID.'" class="btn">Edit</a>
                </div>';
					}
					$display .= '
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