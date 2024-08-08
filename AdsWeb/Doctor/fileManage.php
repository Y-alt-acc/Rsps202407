<?php 
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
    $data = $_POST['data'];
    $data = mysqli_fetch_assoc(conquery(find(2,$data)));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>Doctor Manage</title>
</head>
<body>
<h1>Doctor Manage</h1>
<form action="fileUpdate.php" method="post" 
        enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value =<?php echo $data['doc_id']?>> 
        <input type="hidden" id="doc_path" name="doc_path" value =<?php echo $data['doc_path']; ?>>
        <label for="doc">Doc:</label>
        <br>
        <?php 
            $mime = mime_content_type($data["doc_path"]);
            if(strstr($mime,"video/"))
            {
                echo 
                '<div>
                <video preload="metadata" controls>
                    <source src="'. $data["doc_path"]. '#t=0.1" type="'.$mime.'">
                Your browser does not support the video tag.
                </video>
                </div>';
            }else if(strstr($mime, "image/")) {
                echo
                '<div>
                <img src="'.$data["doc_path"].'">
                </div>
                ';
            }
        ?>
        <br><br>
        <input type="file" id="doc" name="doc">
        <br><br>
        <label for="doc_name">Tag:</label>
        <input type="text" name="doc_name" value=<?php echo $data['doc_name'] ?>>
        <br><br>
        <label for="doc_txt">Deskripsi:</label>
        <textarea id="doc_txt" name="doc_txt" rows="13"  maxlength="254" ><?php echo $data['doc_txt'] ?></textarea>
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