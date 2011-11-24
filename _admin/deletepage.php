<?php
@include('db.php');
$pages->remove(array('_id' => new MongoId($_REQUEST['id'])), true);
$m->close();
Header("Location: index.php?say=R");
exit();
?>
