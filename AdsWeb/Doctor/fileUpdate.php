<?php 
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if (isset($_POST["submit"]))
{   
    update(2, $_POST['id'], $_POST['doc_name'],$_POST['doc_txt']);
}
if($_FILES['doc'] != NULL)
{
    unlink($_POST['doc_path']);
    $uploadedImage = $_FILES['doc'];
    move_uploaded_file($uploadedImage["tmp_name"], $_POST['doc_path']);
}
goToView();

?>