<?php 
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if (isset($_POST["submit"]))
{   
    update(1, $_POST['id'], $_POST['media_tag'],$_POST['media_txt'],$_POST['exp_date']);
}
if($_FILES['media']['size'] != 0)
{
    unlink($_POST['media_path']);
    $uploadedImage = $_FILES['media'];
    move_uploaded_file($uploadedImage["tmp_name"], $_POST['media_path']);
}
goToView();

?>