<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';

$data = $_POST['data'];
conquery(removeSingle(2,$data));
redirect('./fileView.php');
?>