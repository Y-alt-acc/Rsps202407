<?php 

require_once 'serverfunction.php';
require_once 'commonfunction.php';
if(isset($_SESSION["user"])){
    redirect('./homeUser.html');
}
$username = $_POST['user_name'];
$password = $_POST['password'];

if(loginadsweb($username,$password))
{
    session_start();
    $_SESSION["user"] = $username;
    redirect('./homeUser.html');
}else {
    redirect('./login.html');
}
?>