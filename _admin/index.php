<?php
@include('db.php');
$cursor = $pages->find();
$list = iterator_to_array($cursor);

$say='';
if ($_REQUEST['say']=='Y') {
	$say = '<div style="background-color:#FFD700;padding:10px;text-align:center;border:2px solid #DAA520;">Page Saved OK</div>';
}
if ($_REQUEST['say']=='R') {
        $say = '<div style="background-color:#FFD700;padding:10px;text-align:center;border:2px solid #DAA520;">Page Deleted OK</div>';
}

$content = '
<h2>FAF Page Admin</h2>
'.$say.'
<p><strong>Edit existing pages</strong></p>

<table border="1" cellspacing="0" cellpadding="3">
<tr><td align="center"><strong>URL</strong></td>
<td align="center"><strong>Title</strong></td>
<td align="center"><strong>Edit</strong></td>
</tr>
';
foreach ($list as $v) {
	$content .= '
<tr><td><a href="'.$v['page'].'" target="_blank">'.$v['page'].'</a></td><td><a href="editpage.php?id='.$v['_id'].'">'.htmlspecialchars($v['title']).'</a></td><td align="center"><a href="editpage.php?id='.$v['_id'].'">edit</a></td></tr>
';
}
$content .= '
</table>
<hr />
<p><strong>Create a New Page</strong></p>

<form method="post" action="newpage.php">
<table border="1" cellspacing="0" cellpadding="3">
<tr><td>URL</td><td><input type="text" name="q[page]" value="/bin/c/" size="32" /></td></tr>
<tr><td>Title</td><td><input type="text" name="q[title]" value="" size="60" /></td></tr>
<tr><td>Keywords</td><td><input type="text" name="q[keywords]" value="" size="60" /></td></tr>
<tr valign="top"><td>Description</td><td><textarea name="q[description]" cols="50" rows="4"></textarea></td></tr>
<tr valign="top"><td>Content</td><td><textarea name="q[content]" cols="80" rows="15"></textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="awef" value="Submit" /></td></tr>
</table>
</form>
';

output($content,$layout);
$m->close();

?>
