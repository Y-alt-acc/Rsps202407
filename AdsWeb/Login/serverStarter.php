<?php
$servername = "localhost";
$username = "rspsuper";
$password = "rspSehat10@85";
$dbname = "rsps_database_ads";
$tbads = "table_list_ads";
$tbmoney = "table_list_doctor";
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
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid CHAR(36) NOT NULL DEFAULT UUID(),
  user VARCHAR(100) NOT NULL,
  pass VARCHAR(255) NOT NULL,
  add_date DATE DEFAULT NOW(),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

if (!mysqli_query($conn, $sql)) 
{
   echo "Error creating user table: " . mysqli_error($conn);
}
$sql = "CREATE TABLE IF NOT EXISTS $tbads
(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid CHAR(36) NOT NULL DEFAULT UUID(),
  user VARCHAR(100),
  media_path VARCHAR(255) NOT NULL,
  media_tag VARCHAR(255) NOT NULL,
  media_txt VARCHAR(255) NOT NULL,
  add_date DATE DEFAULT NOW(),
  exp_date DATETIME DEFAULT NOW(),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

if (!mysqli_query($conn, $sql)) 
{
   echo "Error creating ads table: " . mysqli_error($conn);
}
$sql = "CREATE TABLE IF NOT EXISTS $tbmoney
(
  table_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid CHAR(36) NOT NULL DEFAULT UUID(),
  user VARCHAR(100),
  doctor_path VARCHAR(255) NOT NULL,
  doctor_tag VARCHAR(255) NOT NULL,
  doctor_txt VARCHAR(255) NOT NULL,
  add_date DATE DEFAULT NOW(),
  exp_date DATETIME DEFAULT NOW(),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  if (!mysqli_query($conn, $sql)) 
  {
     echo "Error creating money table: " . mysqli_error($conn);
  }
$sql = "CREATE TABLE IF NOT EXISTS $tbschedule
(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid CHAR(36) NOT NULL DEFAULT UUID(),
  user VARCHAR(100),
  doc_name VARCHAR(255) NOT NULL,
  doc_schedule VARCHAR(255) NOT NULL,
  add_date DATE DEFAULT NOW(),
  exp_date DATETIME DEFAULT NOW(),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
if (!mysqli_query($conn, $sql)) 
{
   echo "Error creating schedule table: " . mysqli_error($conn);
}
$sql = "SELECT * FROM table_list_user WHERE user ='$userweb'"; 

if(mysqli_query($conn, $sql)->num_rows == 0 ){
  $hash = password_hash($passweb, PASSWORD_DEFAULT);
  $sql = "INSERT INTO table_list_user (user, pass) VALUE('$userweb','$hash')";

  if (!mysqli_query($conn, $sql)) 
  {
    echo "Error creating admin: " . mysqli_error($conn);
  }
  $sql = "INSERT INTO table_list_user (user, pass) VALUE('test','$hash')";

  if (!mysqli_query($conn, $sql)) 
  {
    echo "Error creating user: " . mysqli_error($conn);
  }
}
mysqli_close($conn);

if(!is_dir("../slide"))
{
  mkdir("../slide");
}
header('Location: ../Login/home.html');
die();
?>