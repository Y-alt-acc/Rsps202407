<?php
$servername = "localhost";
$username = "rspsuper";
$password = "rspSehat10@85";
$dbname = "rsps_database_tv";
$tbmedia = "table_list_media";
$tbdoctor = "table_list_doctor";
$tbschedule = "table_list_schedule";
$tbuser = "table_list_user";
$userweb = "admin";
$passweb = "root";

$conn = mysqli_connect($servername, $username, $password);
if (!$conn) 
{
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!mysqli_query($conn, $sql)) 
{
  echo "Error creating database: " . mysqli_error($conn);
}
if (!$conn->select_db($dbname))
{
  echo "Error choosing database ". mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS $tbuser
(
  usr_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usr_uuid CHAR(36) NOT NULL DEFAULT UUID(),
  usr_name VARCHAR(100) NOT NULL,
  usr_pass VARCHAR(255) NOT NULL,
  usr_add_date DATE DEFAULT NOW(),
  usr_reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

if (!mysqli_query($conn, $sql)) 
{
   echo "Error creating user table: " . mysqli_error($conn);
}
$sql = "CREATE TABLE IF NOT EXISTS $tbmedia
(
  med_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  med_uuid CHAR(36) NOT NULL DEFAULT UUID(),
  med_user VARCHAR(100),
  med_path VARCHAR(255) NOT NULL,
  med_tag VARCHAR(255) NOT NULL,
  med_txt VARCHAR(255),
  med_add_date DATE DEFAULT NOW(),
  med_exp_date DATETIME DEFAULT NOW(),
  med_reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

if (!mysqli_query($conn, $sql)) 
{
   echo "Error creating ads table: " . mysqli_error($conn);
}
$sql = "CREATE TABLE IF NOT EXISTS $tbdoctor
(
  doc_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  doc_uuid CHAR(36) NOT NULL DEFAULT UUID(),
  doc_user VARCHAR(100),
  doc_path VARCHAR(255) NOT NULL,
  doc_name VARCHAR(255) NOT NULL,
  doc_spe VARCHAR(255) NOT NULL,
  doc_txt VARCHAR(255),
  doc_add_date DATE DEFAULT NOW(),
  doc_reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  if (!mysqli_query($conn, $sql)) 
  {
     echo "Error creating money table: " . mysqli_error($conn);
  }
$sql = "CREATE TABLE IF NOT EXISTS $tbschedule
(
  sch_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  doc_uuid CHAR(36) NOT NULL DEFAULT UUID(),
  sch_uuid CHAR(36) NOT NULL DEFAULT UUID(),
  sch_user VARCHAR(100),
  sch_day VARCHAR(255) NOT NULL,
  sch_start VARCHAR(10) NOT NULL,
  sch_end VARCHAR(10) NOT NULL,
  sch_add_date DATE DEFAULT NOW(),
  sch_reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
if (!mysqli_query($conn, $sql)) 
{
   echo "Error creating schedule table: " . mysqli_error($conn);
}
$sql = "SELECT * FROM table_list_user WHERE usr_name ='$userweb'"; 

if(mysqli_query($conn, $sql)->num_rows == 0 ){
  $hash = password_hash($passweb, PASSWORD_DEFAULT);
  $sql = "INSERT INTO table_list_user (usr_name, usr_pass) VALUE('$userweb','$hash')";

  if (!mysqli_query($conn, $sql)) 
  {
    echo "Error creating admin: " . mysqli_error($conn);
  }
  $sql = "INSERT INTO table_list_user (usr_name, usr_pass) VALUE('test','$hash')";

  if (!mysqli_query($conn, $sql)) 
  {
    echo "Error creating user: " . mysqli_error($conn);
  }
}
mysqli_close($conn);

if(!is_dir("./slide"))
{
  mkdir("./slide");
}
if(!is_dir("./wajah"))
{
  mkdir("./wajah-");
}
header('Location: ./home.html');
die();
?>