<?php 
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';

$data = $_POST['data'];
conquery(removeSingle(2,$data));
goToView();
?>