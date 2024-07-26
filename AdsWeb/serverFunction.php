<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rsps_database_ads";
$tbname = "table_list_ads";
function  conStart(){
    return mysqli_connect("localhost", "root", "", "rsps_database_ads");    
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
?>