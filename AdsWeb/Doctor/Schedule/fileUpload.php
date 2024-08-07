<?php
require_once '../../Function/serverfunction.php';
require_once '../../Function/commonfunction.php';
if (isset($_POST["submit"])) 
{
    $conn = conStart();
    $stmt = $conn->prepare("INSERT INTO table_list_schedule (sch_user, sch_day, sch_schedule) VALUES ( ?, ?, ?)");
    $stmt->bind_param("sss",$user, $schDay, $schSchedule,);
    
    $user = $_SESSION['user'];
    $schDay = $_POST['sch_tag'];
    $schSchedule = $_POST['sch_txt'];
    $stmt->execute();
    conEnd($conn);
    conEnd($stmt);
}
goToView();
?>