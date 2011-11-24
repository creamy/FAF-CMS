<?php
@include('db.php');

$q = $pages->findOne(array('_id' => new MongoId($_REQUEST['id'])));

foreach ($q as $k=>$v) {
	$q[$k]=htmlspecialchars($v);
}


$content = '
<h2>FAF Page Admin</h2>

<p><a href="index.php">Cancel Changes - Return To Admin Home</a></p>

<p><strong>Edit Page</strong></p>

<form method="post" action="updatepage.php">
<input type="hidden" name="id" value="'.htmlspecialchars($_REQUEST['id']).'">
<table border="1" cellspacing="0" cellpadding="3">
<tr><td>URL</td><td><input type="text" name="q[page]" value="'.$q['page'].'" size="32" /></td></tr>
<tr><td>Title</td><td><input type="text" name="q[title]" value="'.$q['title'].'" size="60" /></td></tr>
<tr><td>Keywords</td><td><input type="text" name="q[keywords]" value="'.$q['keywords'].'" size="60" /></td></tr>
<tr valign="top"><td>Description</td><td><textarea name="q[description]" cols="50" rows="4">'.$q['description'].'</textarea></td></tr>
<tr valign="top"><td>Content</td><td><textarea name="q[content]" cols="80" rows="15">'.$q['content'].'</textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="awef" value="Submit" /></td></tr>
</table>
</form>

<p>&nbsp;</p>
<p><a href="deletepage.php?id='.urlencode($_REQUEST['id']).'">Delete This Page</a></p>

';

output($content,$layout);
$m->close();

?>
