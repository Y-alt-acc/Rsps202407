<?php 
require_once '../../Function/serverfunction.php';
require_once '../../Function/commonfunction.php';

$data = $_POST['data'];
conquery(removeSingle(3,$data));
goToView();
?>