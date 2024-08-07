<?php
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if (isset($_POST["submit"])) 
{
    $conn = conStart();
    $stmt = $conn->prepare("INSERT INTO table_list_doctor(doc_user, doc_path, doc_name, doc_txt) VALUES ( ?, ?, ?, ?)");
    $stmt->bind_param("ssss",$user,$docPath, $docTag, $docTxt, );
    
    $user = $_SESSION['user'];
    
    $uploadedFile = $_FILES['wajah'];
    $docTag = $_POST['doc_tag'];
    $docTxt = $_POST['doc_txt'];
    $targetDir = "../wajah/".date("Y-m-d-h-i-s",time())."/";
    mkdir($targetDir);
    $fileName = basename($uploadedFile['name']);
    $targetFilePath = $targetDir. $fileName;
    if (file_exists($targetFilePath)) 
    {
        echo "Sorry, file already exists.<br>";
    } else {
        if (move_uploaded_file($uploadedFile["tmp_name"], $targetFilePath)) {
            $docPath = $targetFilePath;
            $stmt->execute();
        } else {
            echo "Sorry, there was an error uploading your " . $fileName . ".<br>";
        }
    }
    
    conEnd($conn);
    conEnd($stmt);
}
goToView();
?>