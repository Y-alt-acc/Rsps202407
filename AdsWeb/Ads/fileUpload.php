<?php
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
if (isset($_POST["submit"]) && $_SESSION['user']!=NULL) 
{
    $conn = conStart();
    $stmt = $conn->prepare("INSERT INTO table_list_media (med_user, med_path, med_tag, med_txt, med_exp_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss",$user,$mediaPath, $mediaTag, $mediaTxt, $expiredDate);
    
    $user = $_SESSION['user'];
    
    $uploadedFiles = $_FILES['media'];
    $mediaTag = $_POST['media_tag'];
    $mediaTxt = $_POST['media_txt'];
    $expiredDate = $_POST['exp_date'];
    $targetDir = "../slide/".date("Y-m-d-h-i-s",time())."/";
    mkdir($targetDir);
    $i = 1;
    foreach ($uploadedFiles['name'] as $key => $value) {
        $fileName = basename($uploadedFiles['name'][$key]);
        $targetFilePath = $targetDir. $fileName;
        $i++;
        if (file_exists($targetFilePath)) 
        {
            echo "Sorry, file already exists.<br>";
        } else {
            if (move_uploaded_file($uploadedFiles["tmp_name"][$key], $targetFilePath)) {
                $mediaPath = $targetFilePath;
                $stmt->execute();
            } else {
                echo "Sorry, there was an error uploading your " . $fileName . ".<br>";
            }
        }
    }
    conEnd($conn);
    conEnd($stmt);
}
goToView();
?>