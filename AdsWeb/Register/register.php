<?php 

require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if(isset($_SESSION["user"]) && $_SESSION["user"] == "admin"){
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    conquery(userAdd($username, $password));
    goToHomeuser();
}else {
    goToHome();
}
?>