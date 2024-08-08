<?php
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
$data = viewAds(2);

?>

<!DOCTYPE html>
<html lang="en">
<style>

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
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>Ads View</title>

</head>

<body>
    
<?php
echo '<div ><table id="Adverts" class="data-table">
<tr class="data-heading">';
while ($property = mysqli_fetch_field($data)) 
{
    echo '<th>' . htmlspecialchars($property->name) . '</th>';  //get field name for header
}
echo '<th> Up </th><th> Down </th><th> Schedule </th><th> Change </th><th> Delete </th>';
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
        <form action='./fileUp.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['0'];?>>
        <input type="submit" name="submit" value="up">
    </form>
    </td>
    <td>
        <form action='./fileDown.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['0'];?>>
        <input type="submit" name="submit" value="down">
    </form>
    </td>
    <td>
        <form action='./Schedule/fileView.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['1'];?>>
        <input type="submit" name="submit" value="Schedule">
    </form>
    </td>
    <td>
        <form action='./fileManage.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['0'];?>>
        <input type="submit" name="submit" value="change">
    </form>
    </td>
    <td>
        <form action='./fileDelete.php' method="post">
        <input type="hidden" name="data" value=<?php echo $row['0'];?>>
        <input type="submit" name="submit" value="Delete">
    </form>
    </td>
    <?php
    echo '</tr>';
}
echo "</table> </div>";
?>
<br>
<form action="../homeUser.html" method="post" 
        enctype="button">
        <input type="submit" name="submit" value="Back">
    </form>
</body>

</html>