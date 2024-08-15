<?php 
require_once '../Function/serverfunction.php';
require_once '../Function/commonfunction.php';
    $data = $_POST['data'];
    $data = mysqli_fetch_assoc(conquery(find(2,$data)));
?>

<!DOCTYPE html>
<html lang="en">
<style>
    * {
        box-sizing: border-box;
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

        input[type=text], select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
        }
        
        label {
        padding: 12px 12px 12px 0;
        display: inline-block;
        }
        
        input[type=submit] {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
        }
        
        input[type=submit]:hover {
        background-color: #45a049;
        }
        
        .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        }
        
        .col-25 {
        float: left;
        width: 25%;
        margin-top: 6px;
        }
        
        .col-75 {
        float: left;
        width: 75%;
        margin-top: 6px;
        }
        
        /* Clear floats after the columns */
        .row:after {
        content: "";
        display: table;
        clear: both;
        }
img
{
  max-width: 18vw;
  min-height: 39vh;
  max-height: 39vh;
  display:block;
  margin-left: auto; 
  margin-right: auto;
  object-fit: fill;
}
video
{
  max-width: 18vw;
  min-height: 39vh;
  max-height: 39vh;
  display:block;
  margin-left: auto; 
  margin-right: auto; 
  object-fit: fill;
}
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>Doctor Manage</title>
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
                <a href="../Ads/ViewAll.php">View All</a>
            </div>
            </li>
        <li class="dropdown">
            <a href="../Doctor/fileView.php" class="dropbtn">Doctor</a>
            <div class="dropdown-content">
            <a href="../Doctor/fileUploadpage.html">Upload</a>
            <a href="../Doctor/ViewAll.php">View All</a>
            </div>
        </li>
        <li class="dropdown">
              <a href="../Doctor/Schedule/fileView.php" class="dropbtn">Schedule</a>
              <div class="dropdown-content">
                <a href="../Doctor/Schedule/ViewAll.php">View All</a>
              </div>
            </li>
        <li style="float: right;"><a href="../Login/logout.php">Log Out</a></li>
    </ul>
</div>
<div class="container">
    <h1>Doctor Manage</h1>
    <form action="fileUpdate.php" method="post"  enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value =<?php echo $data['doc_id']?>> 
        <input type="hidden" id="doc_path" name="doc_path" value =<?php echo $data['doc_path']; ?>>         
    <div class="row">
        <div class="col-25">
            <label for="doc">Doc:</label>
        </div>
        <div class="col-75">
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
            <input type="file" id="doc" name="doc">
        </div>
        </div>
        <div class="row">
        <div class="col-25">
            <label for="doc_name">Name:</label>
        </div>
        <div class="col-75">
            <input type="text" name="doc_name" value=<?php echo $data['doc_name'] ?>>
        </div>
        </div>
        <div class="row">
        <div class="col-25">
            <label for="doc_spe">Spesialis </label>
        </div>
        <div class="col-75">
            <input type="text" name="doc_spe" value=<?php echo $data['doc_spe'] ?>>
        </div>
        <div class="row">
        <div class="col-25">
        <label for="doc_txt">Deskripsi:</label>
        </div>
        <div class="col-75">
            <textarea id="doc_txt" name="doc_txt" rows="13"  maxlength="254" ><?php echo $data['doc_txt'] ?></textarea>
        </div>
        </div>
        </div>
        <div class="row">
        <input type="submit" name="submit" value="Change">
        </form>
        <form action="../homeUser.html" method="post" enctype="button">
            <input type="submit" name="submit" value="cancel" style="background-color: crimson;float:left">
        </form>
    </div>
</body>

</html>