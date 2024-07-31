<?php
$servername = "localhost";
$username = "zaViewer";
$password = "I(XWzqFegEa8kn[3";
$dbname = "rsps_database_ads";
$tbname = "table_list_ads";
function  conStart(){
    return mysqli_connect("localhost", "zaViewer", "I(XWzqFegEa8kn[3", "rsps_database_ads");    
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
    return "INSERT INTO table_list_user (user, pass) 
    VALUE($user,PASSWORD($hash))";
}
function loginadsweb($user, $pass)
{
    $conn = conStart();
    $stmt = $conn->prepare("SELECT pass FROM table_list_user WHERE user = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $hash = $stmt->get_result()->fetch_assoc();
    conEnd($conn);
    conEnd($stmt);
    return  password_verify($pass, $hash["pass"]);
}
function find($id)
{
    return "SELECT * FROM table_list_ads WHERE id = '$id'";
}
function removeSingle($id)
{
    return "DELETE FROM table_list_ads WHERE id = '$id'";
}
function removeFolder($regDate, $user)
{
    return "DELETE FROM table_list_ads WHERE reg_date = '$regDate' AND user = '$user'";
}
function update($id, $mediaTag, $mediaTxt, $expDate)
{
    $conn = conStart();
    $stmt = $conn->prepare("UPDATE table_list_ads SET media_tag = ?, media_txt = ?, exp_date = ? WHERE id = ?");
    $stmt->bind_param("sssi",$mediaTag, $mediaTxt, $expDate, $id);
    $stmt->execute();
    conEnd($conn);
    conEnd($stmt);
    
}
function swapId($id, $trgt)
{
    return "UPDATE table_list_ads SET id = '$trgt' WHERE table_list_ads.id =  '$id'";
}
function swapPos($id, $trgt)
{
    $conn = conStart();
    mysqli_query($conn, swapId($id,0));
    mysqli_query($conn, swapId($trgt,$id));
    mysqli_query($conn, swapId(0,$trgt));
    $conn->close();
}
function viewFolder()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT Distinct media_tag, SUBSTRING_INDEX(media_path, '/', 2) as File_name , add_date FROM table_list_ads";    
    }else{
         $query = "SELECT  id, SUBSTRING_INDEX(media_path, '/', 2) as File_name ,media_txt, add_date ,exp_date FROM table_list_ads WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewAds()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT  * FROM table_list_ads";    
    }else{
         $query = "SELECT  id, SUBSTRING_INDEX(media_path, '/', -1) as File_name ,media_txt,exp_date FROM table_list_ads WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveImg()
{
    $conn = conStart();
    $query = "SELECT  media_path FROM table_list_ads WHERE exp_date >= NOW() ORDER BY exp_date ASC, media_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewDeactiveImg()
{
    $conn = conStart();
    $query = "SELECT  media_path FROM table_list_ads WHERE exp_date < NOW() ORDER BY exp_date DESC , media_path  " ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveTxt()
{
    $conn = conStart();
    $query = "SELECT  media_txt FROM table_list_ads WHERE exp_date >= NOW() ORDER BY exp_date ASC, media_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
function findMon($id)
{
    return "SELECT * FROM table_list_money WHERE table_id = '$id'";
}
function removeSingleMon($id)
{
    return "DELETE FROM table_list_money WHERE table_id = '$id'";
}
function removeFolderMon($regDate, $user)
{
    return "DELETE FROM table_list_money WHERE reg_date = '$regDate' AND user = '$user'";
}
function updateMon($id, $mediaTag, $mediaTxt, $expDate)
{
    $conn = conStart();
    $stmt = $conn->prepare("UPDATE table_list_money SET money_tag = ?, money_txt = ?, exp_date = ? WHERE table_id = ?");
    $stmt->bind_param("sssi",$mediaTag, $mediaTxt, $expDate, $id);
    $stmt->execute();
    conEnd($conn);
    conEnd($stmt);
    
}
function swapIdMon($id, $trgt)
{
    return "UPDATE table_list_money SET table_id = '$trgt' WHERE table_list_money.id =  '$id'";
}
function swapPosMon($id, $trgt)
{
    $conn = conStart();
    mysqli_query($conn, swapId($id,0));
    mysqli_query($conn, swapId($trgt,$id));
    mysqli_query($conn, swapId(0,$trgt));
    $conn->close();
}
function viewFolderMon()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT Distinct money_tag, SUBSTRING_INDEX(money_path, '/', 2) as File_name , add_date FROM table_list_money";    
    }else{
         $query = "SELECT  table_id, SUBSTRING_INDEX(money_path, '/', 2) as File_name ,money_txt, add_date ,exp_date FROM table_list_money WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewMon()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT  * FROM table_list_money";    
    }else{
         $query = "SELECT  table_id, SUBSTRING_INDEX(money_path, '/', -1) as File_name ,money_txt,exp_date FROM table_list_money WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveMon()
{
    $conn = conStart();
    $query = "SELECT  money_path FROM table_list_money WHERE exp_date >= NOW() ORDER BY exp_date ASC, money_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewDeactiveMon()
{
    $conn = conStart();
    $query = "SELECT  money_path FROM table_list_money WHERE exp_date < NOW() ORDER BY exp_date DESC , money_path  " ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveTxtMon()
{
    $conn = conStart();
    $query = "SELECT  money_txt FROM table_list_money WHERE exp_date >= NOW() ORDER BY exp_date ASC, money_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

function findSche($id)
{
    return "SELECT * FROM table_list_schedule WHERE id = '$id'";
}
function removeSingleSche($id)
{
    return "DELETE FROM table_list_schedule WHERE id = '$id'";
}
function removeFolderSche($regDate, $user)
{
    return "DELETE FROM table_list_schedule WHERE reg_date = '$regDate' AND user = '$user'";
}
function updateSche($id, $mediaTag, $mediaTxt, $expDate)
{
    $conn = conStart();
    $stmt = $conn->prepare("UPDATE table_list_schedule SET doc_name = ?, doc_schedule = ?, exp_date = ? WHERE id = ?");
    $stmt->bind_param("sssi",$mediaTag, $mediaTxt, $expDate, $id);
    $stmt->execute();
    conEnd($conn);
    conEnd($stmt);
    
}
function swapIdSche($id, $trgt)
{
    return "UPDATE table_list_schedule SET id = '$trgt' WHERE table_list_schedule.id =  '$id'";
}
function swapPosSche($id, $trgt)
{
    $conn = conStart();
    mysqli_query($conn, swapId($id,0));
    mysqli_query($conn, swapId($trgt,$id));
    mysqli_query($conn, swapId(0,$trgt));
    $conn->close();
}
function viewFolderSche()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT Distinct doc_name, SUBSTRING_INDEX(money_path, '/', 2) as File_name , add_date FROM table_list_schedule";    
    }else{
         $query = "SELECT  id, SUBSTRING_INDEX(money_path, '/', 2) as File_name ,doc_schedule, add_date ,exp_date FROM table_list_schedule WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewSche()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT  * FROM table_list_schedule";    
    }else{
         $query = "SELECT  id, SUBSTRING_INDEX(money_path, '/', -1) as File_name ,doc_schedule,exp_date FROM table_list_schedule WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveSche()
{
    $conn = conStart();
    $query = "SELECT  money_path FROM table_list_schedule WHERE exp_date >= NOW() ORDER BY exp_date ASC, money_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewDeactiveSche()
{
    $conn = conStart();
    $query = "SELECT  money_path FROM table_list_schedule WHERE exp_date < NOW() ORDER BY exp_date DESC , money_path  " ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveTxtSche()
{
    $conn = conStart();
    $query = "SELECT  doc_schedule FROM table_list_schedule WHERE exp_date >= NOW() ORDER BY exp_date ASC, money_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
?>