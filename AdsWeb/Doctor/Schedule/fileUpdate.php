<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';
if (isset($_POST["submit"]))
{   
    update(3, $_POST['id'], $_POST['media_tag'],$_POST['media_txt'],$_POST['exp_date']);
}
if($_FILES['media'] != NULL)
{
    unlink($_POST['media_path']);
    $uploadedImage = $_FILES['media'];
    move_uploaded_file($uploadedImage["tmp_name"], $_POST['media_path']);
}
redirect('./fileView.php');

?>