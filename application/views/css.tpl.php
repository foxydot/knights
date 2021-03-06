<?php
$colorscheme = unserialize($org->meta['colorscheme']->meta_value);
extract($colorscheme);
header('Content-Type: text/css');
print 'body{
    background-color: '.$background.';
    background-image: url('.$org->meta['background_url']->meta_value.');
    color: '.$text.';
}
a{
    color: '.$link.';
}
a:hover{
    color: '.$highlight.';
}
.navbar{
    background-color: '.$navbackground.';
    border-color: '.adjustColorLightenDarken($navbackground, 20).';
}
.navbar-default .navbar-nav li a{
    color: '.$navtext.'
}
.navbar-default .navbar-nav li  a:hover{
    color: '.adjustColorLightenDarken($navtext, 20).'
}
.btn-default,input[type="submit"], a.button,.nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus{
    background: '.$button.';
  background: -webkit-gradient(linear,
                               left bottom,
                               left top,
                               color-stop(0, '.adjustColorLightenDarken($button, 20).'),
                               color-stop(1, '.adjustColorLightenDarken($button, -20).'));
  background: -ms-linear-gradient(bottom,
                                  '.adjustColorLightenDarken($button, 20).',
                                  '.adjustColorLightenDarken($button, -20).');
  background: -moz-linear-gradient(center bottom,
                                   '.adjustColorLightenDarken($button, 20).' 0%,
                                   '.adjustColorLightenDarken($button, -20).' 100%);
    border-color: '.adjustColorLightenDarken($button, 20).' !important;
    color: '.$buttontext.' !important;
}
.btn-default:hover,input[type="submit"]:hover, a.button:hover,.nav-pills > li > a:hover, .nav-pills > li > a:focus {
    background: '.$button.';
  background: -webkit-gradient(linear,
                               left bottom,
                               left top,
                               color-stop(0, '.adjustColorLightenDarken($button,-20).'),
                               color-stop(1, '.adjustColorLightenDarken($button, 20).'));
  background: -ms-linear-gradient(bottom,
                                  '.adjustColorLightenDarken($button, -20).',
                                  '.adjustColorLightenDarken($button, 20).');
  background: -moz-linear-gradient(center bottom,
                                   '.adjustColorLightenDarken($button, -20).' 0%,
                                   '.adjustColorLightenDarken($button, 20).' 100%);
    border-color: '.adjustColorLightenDarken($button, 40).' !important;
    color: '.$buttontext.' !important;
}';

/**
 * @param $color_code
 * @param int $percentage_adjuster
 * @return array|string
 * @author Jaspreet Chahal
 */
function adjustColorLightenDarken($color_code,$percentage_adjuster = 0) {
    $percentage_adjuster = round($percentage_adjuster/100,2);
    if(is_array($color_code)) {
        $r = $color_code["r"] - (round($color_code["r"])*$percentage_adjuster);
        $g = $color_code["g"] - (round($color_code["g"])*$percentage_adjuster);
        $b = $color_code["b"] - (round($color_code["b"])*$percentage_adjuster);

        return array("r"=> round(max(0,min(255,$r))),
            "g"=> round(max(0,min(255,$g))),
            "b"=> round(max(0,min(255,$b))));
    }
    else if(preg_match("/#/",$color_code)) {
        $hex = str_replace("#","",$color_code);
        $r = (strlen($hex) == 3)? hexdec(substr($hex,0,1).substr($hex,0,1)):hexdec(substr($hex,0,2));
        $g = (strlen($hex) == 3)? hexdec(substr($hex,1,1).substr($hex,1,1)):hexdec(substr($hex,2,2));
        $b = (strlen($hex) == 3)? hexdec(substr($hex,2,1).substr($hex,2,1)):hexdec(substr($hex,4,2));
        $r = round($r - ($r*$percentage_adjuster));
        $g = round($g - ($g*$percentage_adjuster));
        $b = round($b - ($b*$percentage_adjuster));

        return "#".str_pad(dechex( max(0,min(255,$r)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$g)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$b)) ),2,"0",STR_PAD_LEFT);

    }
}