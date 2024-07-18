<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';
if (isset($_POST["submit"]))
{   
    conquery( update($_POST['id'],$_POST['img_txt'],$_POST['exp_date']));
}
if($_FILES['images'] != NULL)
{
    if (file_exists($_POST['img_path'])) 
    {
        unlink($_POST['img_path']);
    }
    $uploadedImage = $_FILES['images'];
    move_uploaded_file($uploadedImage["tmp_name"], $_POST['img_path']);
}
redirect('./fileView.php');

?>