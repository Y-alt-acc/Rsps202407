<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';
    $data = $_POST['data'];
    $data = mysqli_fetch_assoc(conquery(find($data)));
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
<form action="fileUpdate.php" method="post" 
        enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value =<?php echo $data['id']?>> 
        <input type="hidden" id="img_path" name="img_path" value =<?php echo $data['img_path']?>>
        <label for="img">Image</label>
        <input type="file" id="img" name="images">
        <br><br>
        <label for="img_txt">Tag:</label>
        <input type="text" id="img_txt" name="img_txt" value=<?php echo $data['img_txt'] ?>>
        <br><br>
        <label for="exp_date">Expired Date:</label>
        <input type="datetime-local" id="exp_date" name="exp_date" value="<?php echo $data['exp_date'] ?>">
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