<?php
require_once 'serverfunction.php';
require_once 'commonfunction.php';
if (isset($_POST["submit"])) 
{
    $conn = conStart();
    $stmt = $conn->prepare("INSERT INTO table_list_ads (user, img_path, img_txt, exp_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",$user, $imagePath, $folderName, $expiredDate);
    
    $user = $_SESSION['user'];
    
    $uploadedImages = $_FILES['images'];
    $folderName = $_POST['folder_name'];
    $expiredDate = $_POST['exp_date'];
    $targetDir = "slide/".date("Y-m-d-h-i-s",time())."/";
    mkdir($targetDir);
    $i = 1;
    foreach ($uploadedImages['name'] as $key => $value) {
        $fileName = basename($uploadedImages['name'][$key]);
        $targetFilePath = $targetDir.$i."-". $fileName;
        $i++;
        if (file_exists($targetFilePath)) 
        {
            echo "Sorry, file already exists.<br>";
        } else {
            if (move_uploaded_file($uploadedImages["tmp_name"][$key], $targetFilePath)) {
                $imagePath = $targetFilePath;
                $stmt->execute();
            } else {
                echo "Sorry, there was an error uploading your " . $fileName . ".<br>";
            }
        }
    }
    conEnd($conn);
    conEnd($stmt);
}
redirect("./fileView.php");
?>