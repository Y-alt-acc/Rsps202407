<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>

<body>
<form action="./fileUpload.php" method="post" 
    enctype="multipart/form-data">
    <input type="hidden" id="" name="doc_uuid" value ="<?php echo $_POST['data']?>">
    <label>Day</label><br>
    <input type="radio" id="Monday" name="sch_day" value="Monday" checked>
    <label for="Monday">Monday</label><br>
    <input type="radio" id="Tuesday" name="sch_day" value="Tuesday">
    <label for="Tuesday">Tuesday</label><br>
    <input type="radio" id="Wednesday" name="sch_day" value="Wednesday">
    <label for="Wednesday">Wednesday</label><br>
    <input type="radio" id="Thursday" name="sch_day" value="Thursday">
    <label for="Thursday">Thursday</label><br>
    <input type="radio" id="Friday" name="sch_day" value="Friday">
    <label for="Friday">Friday</label><br>
    <input type="radio" id="Saturday" name="sch_day" value="Saturday">
    <label for="Saturday">Saturday</label><br>
    <input type="radio" id="Sunday" name="sch_day" value="Sunday">
    <label for="Sunday">Sunday</label><br><br>
    <label for="start">Start :</label><input type="time" id="start" name="sch_start" value = "00:00"  required>
    <label for="end">End :</label><input type="time" id="end" name="sch_end" value = "00:00" required>
    <br><br>
    <input type="submit" name="submit" value="Upload">
</form>
<form action="../../homeUser.html" method="post" 
    enctype="button">
    <input type="submit" name="submit" value="cancel">
</form>
</body>

</html>