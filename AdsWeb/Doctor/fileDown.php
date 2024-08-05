<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';

$data = $_POST['data'];
swapPos(2, $data,$data+1);
redirect('./fileView.php');
?>