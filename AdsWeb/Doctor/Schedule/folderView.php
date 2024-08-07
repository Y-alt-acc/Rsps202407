<?php
require_once '../../Function/serverfunction.php';
require_once '../../Function/commonfunction.php';
$data = viewFolder();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>Ads View</title>

</head>

<body>
<?php
echo '<table class="data-table">
<tr class="data-heading">';
while ($property = mysqli_fetch_field($data)) 
{
    echo '<td>' . htmlspecialchars($property->name) . '</td>';
}
echo '<td> change </td><td> delete </td>';
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
echo "</table>";
?>
<br>
<form action="../../homeUser.html" method="post" 
        enctype="button">
        <input type="submit" name="submit" value="Back">
    </form>
</body>

</html>