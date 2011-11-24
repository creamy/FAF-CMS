<?php
@include('db.php');
$q=$_REQUEST['q'];
$q['_id'] =  new MongoId($_REQUEST['id']);
$pages->save($q);


$m->close();
Header("Location: index.php?say=Y");
exit();
?>
