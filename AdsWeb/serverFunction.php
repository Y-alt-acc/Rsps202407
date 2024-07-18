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
    $conn->close();
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
    $hash = conquery("SELECT pass FROM table_list_user WHERE user = '$user'")->fetch_assoc();
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
function update($id, $img_txt, $exp_date)
{
    return "UPDATE table_list_ads SET img_txt = '$img_txt', exp_date = '$exp_date' WHERE id = '$id'";
}
function viewAds()
{
    if($_SESSION["user"] == "admin")
    {
        $query = "SELECT  * FROM table_list_ads";    
    }else{
         $query = "SELECT  id, SUBSTRING_INDEX(img_path, '/', -1) as File_name ,img_txt,exp_date FROM table_list_ads WHERE user='$_SESSION[user]'";
    }
    $conn = conStart();
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveImg()
{
    $conn = conStart();
    $query = "SELECT  img_path FROM table_list_ads WHERE exp_date >= NOW() ORDER BY exp_date ASC, img_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewDeactiveImg()
{
    $conn = conStart();
    $query = "SELECT  img_path FROM table_list_ads WHERE exp_date < NOW() ORDER BY exp_date DESC , img_path  " ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
function viewActiveTxt()
{
    $conn = conStart();
    $query = "SELECT  img_txt FROM table_list_ads WHERE exp_date >= NOW() ORDER BY exp_date ASC, img_path ASC" ;
    $result = mysqli_query($conn, $query);
    conEnd($conn);
    return $result;
}
?>