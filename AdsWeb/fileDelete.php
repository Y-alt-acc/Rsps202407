<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';

$data = $_POST['data'];
conquery(removeSingle(1,$data));
redirect('./fileView.php');
?>