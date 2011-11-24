<?php

//comment the following line if you want to drop the database.
exit();

@include('db.php');
$pages->drop();
$m->close();
Header("Location: index.php?say=R");
exit();
?>
