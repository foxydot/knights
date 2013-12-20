<form method="post">
    <?php //TODO: Add description, invoice tools, etc. ?>
    <div class="row-fluid"><div class="span4">Key</div><div class="span4">Value</div></div>
<?php
    $i = 0;
    foreach($types AS $k=>$v){
        print '<div class="row-fluid"><input class="span4" name="key['.$i.']" value="'.$k.'" /><input class="span4" name="value['.$i.']" value="'.$v.'" /></div>';
        $i++;
    }
    for($j=0;$j<3;$j++){
        print '<div class="row-fluid"><input class="span4" name="key['.$i.']" /><input class="span4" name="value['.$i.']" /></div>';
        $i++;
    }
?>
<input type="submit" value="UPDATE">
</form>