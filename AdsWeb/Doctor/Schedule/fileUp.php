<?php 
require_once '../../Function/serverfunction.php';
require_once '../../Function/commonfunction.php';

$data = $_POST['data'];
swapPos(3, $data,$data-1);
goToView();
?>