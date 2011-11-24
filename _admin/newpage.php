<?php
@include('db.php');
$q=$_REQUEST['q'];
$pages->insert($q);
$m->close();
Header("Location: index.php?say=Y");
exit();
?>
