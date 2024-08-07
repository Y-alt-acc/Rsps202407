<?php 

require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if(isset($_SESSION["user"])){
    goToHomeuser();
}
$username = $_POST['user_name'];
$password = $_POST['password'];

if(loginadsweb($username,$password))
{
    session_start();
    $_SESSION["user"] = $username;
    goToHomeuser();
}else {
    redirect('./login.html');
}
?>