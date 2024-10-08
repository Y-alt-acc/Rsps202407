<?php
  require_once("../Function/commonFunction.php");
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  *{
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    
  }
.grid-continer
{
  display: grid;
  grid-template-columns: 2% 36% 60% 2%;
  grid-template-rows: 3% 12% 79% 6%;
  grid-template-areas: 
    "header header header  header"
    "sidebarleft names txt  sidebarright"
    "sidebarleft media schedule sidebarright"
    "footer footer footer  footer";
    width: 100vw;
    height: 100vh;
    align-items: center;
    background-color: #454B1B;
}
.top
{
  width: 100%;
  height:100%;
  grid-area: header;
  background-color: #355E3B;
}
.bottom
{
  width: 100%;
  height:100%;
  grid-area: footer;
  background-color: #355E3B;
}
.sideleft
{
  width: 100%;
  height:100%;
  grid-area: sidebarleft;
  background-color: #355E3B;
}
.sideright
{
  width: 100%;
  height:100%;
  grid-area: sidebarright;
  background-color: #355E3B;
}
.media
{
  width: 100%;
  height:100%;
  grid-area: media;
  background-color: #4F7942;
}
.name
{
  width: 100%;
  grid-area: names;
  background-color: 		#008080;
}
.quote
{
  width: 100%;
  grid-area: txt;
  background-color: #2E8B57;
}
.schdl
{
  width: 100%;
  height:100%;
  grid-area:schedule;
  background-color: #00A36C;
}
.myslides
{
  display: none;
}
.mytext
{
  display:none;
}
.myaudio
{
  display:block;
}
.myname
{
  display:none;
  
}
.mydayslides
{
  display: none;
}
.mydaytext
{
  display: none;
}
.myschedule
{
  display:none;
}
body
{
  overflow: hidden;
}
img
{
  max-width: 36vw;
  min-height: 79vh;
  display:block;
  margin-left: auto; 
  margin-right: auto;
  object-fit: fill;
}
video
{
  max-width: 36vw;
  min-height: 79vh;
  display:block;
  margin-left: auto; 
  margin-right: auto; 
  object-fit: fill;
}
.text-block
{
  display: none;
  overflow-wrap: break-word;
  color: white;
  
  text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
  text-align: center;
  font-size : 3em;
  font-family: 'Times New Roman', Times, serif;
}
.text-name
{
  display: none;
  overflow-wrap: break-word;
  color: white;
  text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
  text-align: center;
  font-size : 2.5em;
  font-family: 'Times New Roman', Times, serif;
}
.text-mov
{
  
  display: block;
  overflow-wrap: break-word;
  color: white;
  text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
  text-align: center;
  font-size : 3em;
  font-family: 'Times New Roman', Times, serif;
  position: relative;
  animation-name: text-mov-bot;
  animation-duration: 40s;
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
}
.data-heading
{
  font-family: 'Times New Roman', Times, serif;
  font-size : 1.7em;
  text-align: center;
}
.data-text
{
  font-family: 'Times New Roman', Times, serif;
  font-size : 1.7em;
  text-align: center;
}

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

#Adverts tr:nth-child(odd){background-color: 	#93C572;}
#Adverts tr:nth-child(even){background-color: #5F9EA0;}

#Adverts tr:hover {background-color: #ddd;}

#Adverts th {
padding-top: 12px;
padding-bottom: 12px;

background-color: #04AA6D;
color: white;
}
@keyframes text-mov-bot
{
  from {left: 100%;}
  to {left: -100%;}
}
</style>
<head>
  <title> Slide Show</title>
  <body>
    <div class=" grid-continer">
      <div class="top"></div>
      <div class="sideleft"></div>
      <div class="media">
        <?php
          for($i = 1; $i <= 7; $i++){

            $result = serverGetImgDoc($i);
            
            echo '<div class="mydayslides">';
          while($data = mysqli_fetch_assoc($result))
          {
            $mime = mime_content_type($data["doc_path"]);
            if(strstr($mime,"video/"))
            {
              echo 
              '<div class="myslides" name="vid">
              <video preload="metadata">
                  <source src="'. $data["doc_path"]. '#t=0.1" type="'.$mime.'">
                  Your browser does not support the video tag.
                  </video>
              </div>';
            }else if(strstr($mime, "image/")) {
              echo
              '<div class ="myslides" name = "img" >
                <img src="'.$data["doc_path"].'">
                </div>
                ';
              }
            } 
            echo '</div>';
          }
          ?>
      </div>
      <div class="name">
        <?php
          for($i = 1; $i <= 7; $i++){
            $result = serverGetNameDoc($i);
            echo '<div class="myname">';
            while($data = mysqli_fetch_assoc($result))
            {

              echo '
              <div class="text-name">
              <p>'. $data["doc_name"].'</p>
              </div>
              ';
            }
            echo '</div>';
          }
        ?>
      </div>
      <div class="quote">
        <?php
        for($i = 1; $i <= 7; $i++){
          $result = serverGetTxtDoc($i);
          echo '<div class="mydaytext">';
          while($data = mysqli_fetch_assoc($result))
          {

            echo '
            <div class="text-block">
            <p>'. $data["doc_txt"].'</p>
            </div>
            ';
          }
          echo '</div>';
        }
        ?>
      </div>
      <div class="schdl">
        <?php 
          for($i = 1; $i <= 7; $i++){
            
            $data = serverGetTxtSch($i);
            echo '<div class="myschedule" name="'.GetDay($i).'" ><table id="Adverts" class="data-table">
            <tr class="data-heading" >';
          echo "<th colspan = 3> ".GetDay($i)."</th>"; 
          echo'</tr>
          <tr class="data-heading" >';
          while ($property = mysqli_fetch_field($data)) 
            {
              echo '<th>' . htmlspecialchars($property->name) . '</th>';  //get field name for header
            }
            echo '</tr>'; 

            while ($row = mysqli_fetch_row($data)) 
            {
              echo '<tr class="data-text">';
                foreach ($row as $item) 
                {
                echo '<td>' . htmlspecialchars($item) . '</td>';
              }
                echo '</tr>';
            }
            echo "</table> </div>";
          }
        ?>
      </div>
      <div class="sideright"></div>
      <div class="bottom"><h1 class = "text-mov">SELAMAT DATANG DI RUMAH SAKIT PREMIER SURABAYA</h1></div>
    </div>
    <div>
      <?php
      $dir = "../Music/";
      // Open a directory, and read its contents
      if (is_dir($dir)){
        if ($dh = opendir($dir)){
          while (($file = readdir($dh)) !== false ){
            if($file != "." && $file!= "..")
            {
              echo $file;
              $mime = mime_content_type("../Music/".$file);

              echo '
              <audio  class="myaudio" name="aud" onended="audioEnded()">
              <source src="../Music/'. $file. '#t=0.1" type="'.$mime.'">
              Your browser does not support the Audio tag.
              </audio>';
              }
          }
          closedir($dh);
        }
      }
      ?>
      </div>
  </body>
</head>

<script>
let audioPaused =  false;
let slideIndex = -1;
let scheduleIndex = -1;
let clicked = false;
let theDuration = [];
let musicIndex = 0;
let videoPlayed = false;
document.addEventListener('click', e => {
  if(document.getElementsByClassName("myslides")[slideIndex].getAttribute('name') == "vid")
  {
    video.muted = false; 
  }
  if(clicked == false){

    if(document.getElementsByClassName("myaudio")[musicIndex])
    {
      
      audio=document.getElementsByClassName("myaudio");
      audioBruteForce(audio);
    }
  }
  clicked = true;
});
setDuration();
showScedule(); 

function setDuration()
{
  let slides = document.getElementsByClassName("myslides");
  for (let i = 0; i < slides.length; i++) 
  {
    if(slides[i].getAttribute('name') == "vid")
    {
      theDuration.push(10);
    }else{
      theDuration.push(8);
    }
  }
}
function loadVideo(video, i)
{
  video.load();
  if(clicked)
  {
    video.muted = false; 
  }else{
    video.muted = true; 
  }
  video.ondurationchange  =function()
  {
    theDuration[i] = video.duration;
  }
  video.oncanplay = function(e)
  {
    video.play();
  }
}
function bruteForceVideo(video, time)
{

  if(time > theDuration[slideIndex] && video.paused)
  {
    showSlides();
  }else{
    if(video.paused)
    {
      try
      {
        loadVideo(video, slideIndex);
      }catch{
      }finally{
        setTimeout(bruteForceVideo, 2000, video, time + 2);
      }
    }else{
      setTimeout(showSlides, theDuration[slideIndex] * 1000);
    }
  }
}

function audioEnded() {
  musicIndex++;
  audio = document.getElementsByClassName("myaudio");  
    if(musicIndex>=audio.length){
      musicIndex = 0;
    }
    
    audioBruteForce(audio);
}
function audioLoad()
{
  let audio = document.getElementsByClassName("myaudio");
  if(!audioPaused)
  {
    audio[musicIndex].load();

    audio[musicIndex].oncanplay = function(e)
    {
      audio[musicIndex].play();
      
    }
  }
  
}
function audioPause()
{
  let audio = document.getElementsByClassName("myaudio");
  audioPaused = true;
  if(audio[musicIndex]!=null)
  {
    audio[musicIndex].pause() ;
  }
}
function audioUnpause()
{ 
  let audio = document.getElementsByClassName("myaudio");
  if(audio[musicIndex]!=null&&clicked && audio[musicIndex].paused == true && videoPlayed == false)
  {
    try{
      audio[musicIndex].play() ;
      audioPaused = false;
    }catch{

    }finally{
      if(videoPlayed == false){
        setTimeout(audioUnpause(), 2000);
      }
    }
  }
}
function audioBruteForce(audio)
{
  if(audio[musicIndex].paused)
  {
    try
    {
      audioLoad();
    }catch{
    }finally{
      setTimeout(audioBruteForce, 2000, audio);
    }
    }
}

function showScedule()
{
  let i;
  let schedule = document.getElementsByClassName("myschedule");
  let daySlide = document.getElementsByClassName("mydayslides");
  let dayText = document.getElementsByClassName("mydaytext");
  let dayName = document.getElementsByClassName("myname");
  scheduleIndex++;
  if(scheduleIndex >= schedule.length)
  {
    scheduleIndex = 0;
  }
  schedule[scheduleIndex].style.display = "block";
  daySlide[scheduleIndex].style.display = "block";
  dayText[scheduleIndex].style.display = "block";
  dayName[scheduleIndex].style.display = "block";
  for (i = 0; i < schedule.length; i++) 
  {
    if(i!=scheduleIndex)
    { 
      schedule[i].style.display = "none";
      daySlide[i].style.display = "none";
      dayText[i].style.display = "none";
      dayName[i].style.display = "none";
    }
  }
  showSlides();
}
function showSlides() 
{
  let i;
  let slides = document.getElementsByClassName("myslides");
  let quotes = document.getElementsByClassName("text-block");
  let name = document.getElementsByClassName("text-name");
  slideIndex++; 
  if (slideIndex >= slides.length) 
  {
    slideIndex = -1; 
    showScedule();
    return;
    //location.reload();
  }
  if(slides[slideIndex].parentNode.style.display == "none"){
    slideIndex--;
    showScedule();
    return;
  };
  slides[slideIndex].style.display = "block"; 
  quotes[slideIndex].style.display = "block";
  name[slideIndex].style.display = "block";

  
  for (i = 0; i < slides.length; i++) 
  {
    if(i!=slideIndex)
    { 
      slides[i].style.display = "none";  
      quotes[i].style.display = "none";
      name[i].style.display = "none";
    }
  }
  videoPlayed = false;
  audioUnpause();
  if(slides[slideIndex].getAttribute('name') == "vid")
  {
    videoPlayed = true;
    audioPause();
    video = slides[slideIndex].querySelector("video");
    try
    {
      loadVideo(video, slideIndex);
    }catch{
    }finally{
      //setTimeout(showSlides, theDuration[slideIndex] * 1000 + 1000)
      setTimeout(bruteForceVideo, 2000, video, 2);
    }
  }else{
    setTimeout(showSlides, theDuration[slideIndex] * 1000); 
  }
}
</script>
</html>