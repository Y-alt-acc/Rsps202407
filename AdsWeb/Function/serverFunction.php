<?php
$servername = "localhost";
$username = "zaViewer";
$password = "I(XWzqFegEa8kn[3";
$dbname = "rsps_database_tv";
function  conStart(){
    return mysqli_connect("localhost", "zaViewer", "I(XWzqFegEa8kn[3", "rsps_database_tv");    
}
function conEnd($conn){
    $conn->close();
}
function conquery($query)
{
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function aaaaa()
{
    $conn = conStart();
    $stmt = $conn->prepare("");
    $stmt->bind_param("s",$conn);
    $stmt->execute();
    $result = $stmt->get_result();
    conEnd($conn);
    conEnd($stmt);
    return $result;
}
function userAdd($user, $pass)
{
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    return "INSERT INTO table_list_user (usr_name, usr_pass) 
    VALUE($user,PASSWORD($hash))";
}
function loginadsweb($user, $pass)
{
    $conn = conStart();
    $stmt = $conn->prepare("SELECT usr_pass FROM table_list_user WHERE usr_name = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $hash = $stmt->get_result()->fetch_assoc();
    conEnd($conn);
    conEnd($stmt);
    return  password_verify($pass, $hash["usr_pass"]);
}
function find($switch,$id)
{
    switch ($switch) {
        case 1:
            return "SELECT * FROM table_list_media WHERE med_id = '$id'";
        case 2:
            return "SELECT * FROM table_list_doctor WHERE doc_id = '$id'";
        case 3:
            return "SELECT * FROM table_list_schedule WHERE sch_id = '$id'";
        default:
          break;
      }
}
function removeSingle($switch,$id)
{
    switch ($switch) {
        case 1:
            return "DELETE FROM table_list_media WHERE med_id = '$id'";
        case 2:
            return "DELETE FROM table_list_doctor WHERE doc_id = '$id'";
        case 3:
            return "DELETE FROM table_list_schedule WHERE sch_id = '$id'";
        default:
          break;
      }
    
}
function removeFolder($switch, $regDate, $user)
{
    switch ($switch) {
        case 1:
            return "DELETE FROM table_list_media WHERE med_reg_date = '$regDate' AND med_user = '$user'";
        case 2:
            return "DELETE FROM table_list_doctor WHERE doc_reg_date = '$regDate' AND doc_user = '$user'";
        case 3:
            return "DELETE FROM table_list_schedule WHERE sch_reg_date = '$regDate' AND sch_user = '$user'";
        default:
          break;
      }

}
function update($switch, $id, $inputTag, $inputTxt = NULL , $expDate = NULL)
{
    $conn = conStart();
    switch ($switch) {
        case 1:
            $stmt = $conn->prepare("UPDATE table_list_media SET med_tag = ?, med_txt = ?, med_exp_date = ? WHERE med_id = ?");
            $stmt->bind_param("sssi",$inputTag, $inputTxt, $expDate, $id);
            break;
        case 2:
            $stmt = $conn->prepare("UPDATE table_list_doctor SET doc_name = ?, doc_txt = ? WHERE doc_id = ?");
            $stmt->bind_param("ssi",$inputTag, $inputTxt, $id);
            break;
        case 3:
            $stmt = $conn->prepare("UPDATE table_list_schedule SET sch_day = ?, sch_schedule = ? WHERE sch_id = ?");
            $stmt->bind_param("ssi",$inputTag, $inputTxt, $id);
            break;
        default:
            break;
      }
    $stmt->execute();
    conEnd($conn);
    conEnd($stmt);
    
}
function swapId($switch,$id, $trgt)
{
    switch ($switch) {
        case 1:
            return "UPDATE table_list_media SET med_id = '$trgt' WHERE table_list_media.med_id =  '$id'";
        case 2:
            return "UPDATE table_list_doctor SET doc_id = '$trgt' WHERE table_list_doctor.doc_id =  '$id'";
        case 3:
            return "UPDATE table_list_schedule SET sch_id = '$trgt' WHERE table_list_schedule.sch_id =  '$id'";
        default:
          break;
      }
    
}
function swapPos($switch, $id, $trgt)
{
    $conn = conStart();
    mysqli_query($conn, swapId($switch, $id,0));
    mysqli_query($conn, swapId($switch, $trgt,$id));
    mysqli_query($conn, swapId($switch, 0,$trgt));
    $conn->close();
}
function viewFolder()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT Distinct med_tag, SUBSTRING_INDEX(med_path, '/', 2) as File_name , med_add_date FROM table_list_media";    
    }else{
         $query = "SELECT  med_id, SUBSTRING_INDEX(med_path, '/', 2) as File_name ,media_txt, add_date ,exp_date FROM table_list_media WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewAds($switch,$uuid=0)
{
    switch ($switch) {
        case 1:
            if($_SESSION["user"] == "admin")
            {
                $query = "SELECT  * FROM table_list_media";    
            }else{
                $query = "SELECT  med_id, SUBSTRING_INDEX(med_path, '/', -1) as File_name ,med_txt,med_exp_date FROM table_list_media WHERE med_user='$_SESSION[user]'";
            }
            break;
        case 2:
            if($_SESSION["user"] == "admin")
            {
                $query = "SELECT  * FROM table_list_doctor";    
            }else{
                    $query = "SELECT  doc_id, SUBSTRING_INDEX(doc_path, '/', -1) as File_name ,doc_txt FROM table_list_doctor WHERE doc_user='$_SESSION[user]'";
            }
            break;
        case 3:
            if($_SESSION["user"] == "admin")
            {
                $query = "SELECT  * FROM table_list_schedule";    
            }else{
                    $query = "SELECT  sch_id, SUBSTRING_INDEX(sch_path, '/', -1) as File_name , sch_schedule FROM table_list_schedule WHERE sch_user='$_SESSION[user] AND sch_uuid = '$uuid''";
            }
            break;
        default:
          break;
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
} 
function viewActiveImg($switch)
{
    $conn = conStart();
    switch ($switch) {
        case 1:
            $query = "SELECT  med_path FROM table_list_media WHERE med_exp_date >= NOW() ORDER BY med_exp_date ASC, med_path ASC" ;
            break;
        case 2:
            $query = "SELECT  doc_path FROM table_list_doctor ORDER BY doc_path ASC" ;
            break;
        case 3:
        default:
          break;
    }
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewDeactiveImg($switch)
{
    $conn = conStart();
    $query = "SELECT  med_path FROM table_list_media WHERE med_exp_date < NOW() ORDER BY med_exp_date DESC , med_path ASC  " ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveTxt($switch)
{
    $conn = conStart();
    switch ($switch) {
        case 1:
            $query = "SELECT  med_txt FROM table_list_media WHERE med_exp_date >= NOW() ORDER BY med_exp_date ASC, med_path ASC" ;
            break;
        case 2:
            $query = "SELECT  doc_txt FROM table_list_doctor" ;
            break;
        case 3:
            $query = "SELECT table_list_doctor.doc_name, table_list_schedule.sch_day , table_list_schedule.sch_start, table_list_schedule.sch_end from table_list_doctor INNER JOIN table_list_schedule ON table_list_doctor.doc_uuid = table_list_schedule.doc_uuid";
            break;
        default:
          break;
    }
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
?>