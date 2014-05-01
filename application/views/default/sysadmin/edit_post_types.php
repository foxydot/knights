<form method="post">
    <?php //TODO: Add description, invoice tools, etc. ?>
    <div class="row"><div class="col-md-4">Key</div><div class="col-md-4">Value</div></div>
<?php
    $i = 0;
    foreach($types AS $k=>$v){
        print '<div class="row"><input class="col-md-4" name="key['.$i.']" value="'.$k.'" /><input class="col-md-4" name="value['.$i.']" value="'.$v.'" /></div>';
        $i++;
    }
    for($j=0;$j<3;$j++){
        print '<div class="row"><input class="col-md-4" name="key['.$i.']" /><input class="col-md-4" name="value['.$i.']" /></div>';
        $i++;
    }
?>
<input type="submit" value="UPDATE">
</form>