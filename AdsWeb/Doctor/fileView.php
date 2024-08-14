<?php
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
$data = viewDoc(0,10);

?>

<!DOCTYPE html>
<html lang="en">
<style>
*{
    font-family: 'Times New Roman', Times, serif;
}
.navbar
{
  margin: 0;
  padding: 0;
  border: 0;
}
.navbar ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: green;
}

.navbar  li {
  float: left;
}

.navbar li a, .dropbtn {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.navbar li a:hover, .dropdown:hover .dropbtn {
  background-color:turquoise;
}

.navbar li.dropdown {
  display: inline-block;
}

.navbar .dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.navbar .dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.navbar .dropdown-content a:hover {background-color: #f1f1f1;}

.navbar .dropdown:hover .dropdown-content {
  display: block;
}
#Adverts {
  font-family: 'Times New Roman', Times, serif;
  border-collapse: collapse;
  
  width: 100%;
}
#Adverts table
{
    max-width: 100vw;
    
}

#Adverts td, #Adverts th {
  border: 1px solid #ddd;
  padding: 8px;
  
}

#Adverts tr:nth-child(even){background-color: #f2f2f2;}

#Adverts tr:hover {background-color: #ddd;}

#Adverts th {
  
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
#Adverts td {
  word-break: break-word;
}
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>Ads View</title>

</head>

<body>
<div class = "navbar">
    <ul>
        <li><a href="../homeUser.html">Home</a></li>
        <li class="dropdown">
            <a href="../Ads/fileView.php" class="dropbtn">Media</a>
            <div class="dropdown-content">
                <a href="../Ads/fileUploadpage.html">Upload</a>
                <a href="../Ads/folderView.php">View Folder</a>
            </div>
            </li>
        <li class="dropdown">
            <a href="../Doctor/fileView.php" class="dropbtn">Doctor</a>
            <div class="dropdown-content">
            <a href="../Doctor/fileUploadpage.html">Upload</a>
            </div>
        </li>
        <li ><a href="../Doctor/Schedule/fileView.php">Schedule</a></li>
        <li style="float: right;"><a href="../Login/logout.php">Log Out</a></li>
        </ul>
</div>
<?php
echo '<div ><table id="Adverts" class="data-table">
<tr class="data-heading">';
while ($property = mysqli_fetch_field($data)) 
{
    echo '<th>' . htmlspecialchars($property->name) . '</th>';  //get field name for header
}
echo '<th> Schedule </th><th> Add Schedule </th><th> Change </th><th> Delete </th>';
echo '</tr>'; 

while ($row = mysqli_fetch_row($data)) 
{
    echo "<tr>";
    foreach ($row as $item) 
    {
    echo '<td>' . htmlspecialchars($item) . '</td>';
    }
    ?>
    <td>
        <form action='./Schedule/fileView.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['1'];?>>
        <button>&#128065</button>
    </form>
    </td>
    <td>
        <form action='./Schedule/fileUploadPage.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['1'];?>>
        <button>&#43</button>
    </form>
    </td>
    <td>
        <form action='./fileManage.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['0'];?>>
        <button>&#8634</button>
    </form>
    </td>
    <td>
        <form action='./fileDelete.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['0'];?>>
        <button>&#215</button>
    </form>
    </td>
    <?php
    echo '</tr>';
}
echo "</table> </div>";
?>

</html>