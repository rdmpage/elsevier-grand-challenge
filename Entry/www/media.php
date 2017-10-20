<?php

// $Id: $

// Retrieve media blob and display it

require_once '../eav/eav.php';

$id = $_GET['id'];

db_get_media($id);

?>
