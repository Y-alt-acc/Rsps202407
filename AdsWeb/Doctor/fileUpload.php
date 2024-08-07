<?php
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if (isset($_POST["submit"])) 
{
    $conn = conStart();
    $stmt = $conn->prepare("INSERT INTO table_list_doctor(user, doctor_path, doctor_tag, doctor_txt, exp_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss",$user,$docPath, $docTag, $docTxt, $expiredDate);
    
    $user = $_SESSION['user'];
    
    $uploadedFile = $_FILES['wajah'];
    $docTag = $_POST['doc_tag'];
    $docTxt = $_POST['doc_txt'];
    $expiredDate = $_POST['exp_date'];
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
// goToView();
?>