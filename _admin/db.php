<?php
$m = new Mongo("mongodb://127.0.0.1:27017");
$pages = $m->fafcms->pages;

$layout = @join('',@file('/path/to/layout.html'));

function output($content,$layout) {
	$html = str_replace('<!--Content-->',$content,$layout);
	echo $html;
}
?>
