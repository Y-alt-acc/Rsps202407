<?php 
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';

$tag = $_POST['med_tag'];
$folder = $_POST['folder'];
conquery(removeMediaFolder($tag,$folder));
goToView();
?>