<?php 
require_once 'serverfunction.php';
require_once 'commonfunction.php';
    $data = $_POST['data'];
    $data = mysqli_fetch_assoc(conquery(find(2,$data)));
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
        <input type="hidden" id="media_path" name="media_path" value =<?php echo $data['media_path']; ?>>
        <label for="media">Media:</label>
        <br>
        
        <?php 
            $mime = mime_content_type($data["media_path"]);
            if(strstr($mime,"video/"))
            {
                echo 
                '<div>
                <video preload="metadata" controls>
                    <source src="'. $data["media_path"]. '#t=0.1" type="'.$mime.'">
                Your browser does not support the video tag.
                </video>
                </div>';
            }else if(strstr($mime, "image/")) {
                echo
                '<div>
                <img src="'.$data["media_path"].'">
                </div>
                ';
            }
        ?>
        <br><br>
        <input type="file" id="media" name="media">
        <br><br>
        <label for="media_tag">Tag:</label>
        <input type="text" name="media_tag" value=<?php echo $data['media_tag'] ?>>
        <br><br>
        <label for="media_txt">Deskripsi:</label>
        <textarea id="media_txt" name="media_txt" rows="13"  maxlength="254" ><?php echo $data['media_txt'] ?></textarea>
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