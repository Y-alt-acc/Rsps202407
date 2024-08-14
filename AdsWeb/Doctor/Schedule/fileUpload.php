<?php
require_once '../../Function/serverfunction.php';
require_once '../../Function/commonfunction.php';
if (isset($_POST["submit"]) && $_SESSION['user']!=NULL) 
{
    $conn = conStart();
    $stmt = $conn->prepare("INSERT INTO table_list_schedule (doc_uuid, sch_user, sch_day, sch_start,sch_end) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss",$uuid, $user, $schDay, $schStart, $schEnd);
    $uuid = $_POST['doc_uuid'];
    $user = $_SESSION['user'];
    $schDay = $_POST['sch_day'];
    $schStart = $_POST['sch_start'];
    $schEnd= $_POST['sch_end'];
    $stmt->execute();
    conEnd($conn);
    conEnd($stmt);
}
goToView();
?>