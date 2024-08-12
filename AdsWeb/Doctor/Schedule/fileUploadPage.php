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
    <input type="radio" id="Senin" name="sch_day" value="Senin" checked>
    <label for="Senin">Senin</label><br>
    <input type="radio" id="Selasa" name="sch_day" value="Selasa">
    <label for="Selasa">Selasa</label><br>
    <input type="radio" id="Rabu" name="sch_day" value="Rabu">
    <label for="Rabu">Rabu</label><br>
    <input type="radio" id="Kamis" name="sch_day" value="Kamis">
    <label for="Kamis">Kamis</label><br>
    <input type="radio" id="Jumat" name="sch_day" value="Jumat">
    <label for="Jumat">Jumat</label><br>
    <input type="radio" id="Sabtu" name="sch_day" value="Sabtu">
    <label for="Sabtu">Sabtu</label><br>
    <input type="radio" id="Minggu" name="sch_day" value="Minggu">
    <label for="Minggu">Minggu</label><br><br>
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