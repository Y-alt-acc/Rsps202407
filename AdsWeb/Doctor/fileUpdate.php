<?php 
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if (isset($_POST["submit"]))
{   
    update(2, $_POST['id'], $_POST['doc_name'],$_POST['doc_txt'],$_POST['doc_spe']);
}
if($_FILES['doc']['size'] != 0)
{
    unlink($_POST['doc_path']);
    $uploadedImage = $_FILES['doc'];
    move_uploaded_file($uploadedImage["tmp_name"], $_POST['doc_path']);
}
goToView();

?>