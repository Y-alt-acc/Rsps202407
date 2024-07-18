<?php
echo "itr**" . $itr . "**<br>";
 
echo "<table border=1>";
 
$basedir = getcwd() . "/" . $from . "_" . $to;
 
if (!is_dir($basedir))
{
    mkdir($basedir);
}
 
$tempTilesdir = "$basedir/$itr";
 
if (!is_dir($tempTilesdir))
{
    mkdir($tempTilesdir);
}
 
$z = "3";
for ($ii=0; $ii<=2; $ii++)
{
    echo "<tr>";
    for ($i=0; $i<=6; $i++)
    {   
        $handle = null;
        $imgSrc = "http://cbk0.google.com/cbk?output=tile&panoid=" . $panoId . "&zoom=" . $z . "&x=" . $i . "&y=" . $ii;
        echo "imgSrc: $imgSrc<br>";
        $tempImagePath = $tempTilesdir . "/" . $z . "-". $ii . "-" . $i . ".jpg";
        //$handle = fopen( $tempImagePath, "w+b");
        $handle = fopen( $tempImagePath, "x+bt");
        
        fwrite ($handle, file_get_contents($imgSrc));
        fclose ($handle);
        echo "<td><img src='" . $imgSrc . "'></td>";
        //echo "fileperms: fileperms($tempImagePath)\n";
        $convert = "convert -bordercolor red -border 1x1 $tempImagePath $tempImagePath 2>&1";
        //echo "\n$convert\n";
        //echo system($convert);
    }
    echo "</tr>";
}
echo "</table>";
 
sleep(1); //Sleep while images finish downloading.
 
$montage = "montage $tempTilesdir/* -tile 7x3 -geometry 512x512 $basedir/$itr.jpg 2>&1";
 
echo exec($montage,$ret,$err);
 
/*
$d = dir($tempTilesdir); 
while($entry = $d->read()) { 
 if ($entry!= "." && $entry!= "..") { 
    //echo "$tempTilesdir/$entry<br>";
 unlink("$tempTilesdir/$entry"); 
 } 
} 
$d->close(); 
rmdir($tempTilesdir);
 
echo "atEnd: $atEnd<br>";
//sleep(5);
if ($atEnd == "1" && !is_dir($d))
{
    $makeMovieFfmpeg = "ffmpeg -r 4 -f image2 -i " . $basedir . "/%d.jpg -s 896x384 -r 15 -s 896x384 -b 1500kbs " . $basedir . "/" . $to . "_" . $from . "_4-16-1500.avi 2>&1";
    
    //$makeMovieConvert = "convert -delay 5 " . $basedir . "/*.jpg " . $basedir . "/" . $to . "_" . $from . "_.mpg 2>&1";
    echo "<br>";
    echo $makeMovieFfmpeg;
    echo "<br>";
    print_r (exec($makeMovieFfmpeg,$ret,$err));
    echo "<br>";
    print_r (system($makeMovieFfmpeg));
}
*/
?>