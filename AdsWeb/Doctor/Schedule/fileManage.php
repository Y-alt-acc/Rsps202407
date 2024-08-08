<?php 
require_once '../../Function/serverfunction.php';
require_once '../../Function/commonfunction.php';
    $data = $_POST['data'];
    $data = mysqli_fetch_assoc(conquery(find(3,$data)));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>Ads Manage</title>

</head>

<body>
<h1>Ads Manage</h1>
<form action="./fileUpdate.php" method="post" 
        enctype="multipart/form-data">
        <input type="hidden" id="sch_id" name="sch_id" value =<?php echo $_POST['data']?>>
        <input type="hidden" id="sch_id" name="sch_id" value =<?php echo $data['sch_id']?>>
        <br><br>
        <label for="sch_day">Tag:</label>
        <input type="text" name="sch_day" value=<?php echo $data['sch_day'] ?>>
        <br><br>
        <label for="sch_schedule">Deskripsi:</label>
        <textarea id="sch_schedule" name="sch_schedule" rows="13"  maxlength="254" ><?php echo $data['sch_schedule'] ?></textarea>
        <br><br>
        <input type="submit" name="submit" value="Change">
</form>
<br>
<form action="./fileView.php" method="post" 
        enctype="button">
        <input type="submit" name="submit" value="cancel">
    </form>
</body>

</html>