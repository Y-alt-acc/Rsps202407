<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';

$data = $_POST['data'];
conquery(removeSingle($data));
redirect('./fileView.php');
?>