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
    "sidebarleft txt txt  sidebarright"
    "sidebarleft media schedule sidebarright"
    "footer footer footer  footer";
    width: 100vw;
    height: 100vh;
    align-items: center;
    background-color: #222222;
}
.top
{
  width: 100%;
  height:100%;
  grid-area: header;
  background-color: #BBBBBB;
}
.bottom
{
  width: 100%;
  height:100%;
  grid-area: footer;
  background-color: #BBBBBB;
}
.sideleft
{
  width: 100%;
  height:100%;
  grid-area: sidebarleft;
  background-color: #BBBBBB;
}
.sideright
{
  width: 100%;
  height:100%;
  grid-area: sidebarright;
  background-color: #BBBBBB;
}
.media
{
  width: 100%;
  height:100%;
  grid-area: media;
  background-color: #999999;
}
.quote
{
  width: 100%;
  grid-area: txt;
  background-color: #444444;
}
.schdl
{
  width: 100%;
  height:100%;
  grid-area:schedule;
  background-color: #DDDDDD;
}
.myslides
{
  display: none;
}
.mytext
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
  font-size : 2em;
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

#Adverts tr:nth-child(even){background-color: #f2f2f2;}

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
      <div class="quote">
        <div>
        </div>
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
  </body>
</head>

<script>
let slideIndex = -1;
let scheduleIndex = -1;
let clicked = false;
let theDuration = [];
document.addEventListener('click', e => {
  clicked = true;
  if(document.getElementsByClassName("myslides")[slideIndex].getAttribute('name') == "vid")
  {
      video.muted = false; 
  }
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
function showScedule()
{
  let i;
  let schedule = document.getElementsByClassName("myschedule");
  let daySlide = document.getElementsByClassName("mydayslides");
  let dayText = document.getElementsByClassName("mydaytext");
  scheduleIndex++;
  if(scheduleIndex >= schedule.length)
  {
    scheduleIndex = 0;
  }
  schedule[scheduleIndex].style.display = "block";
  daySlide[scheduleIndex].style.display = "block";
  dayText[scheduleIndex].style.display = "block";
  for (i = 0; i < schedule.length; i++) 
  {
    if(i!=scheduleIndex)
    { 
      schedule[i].style.display = "none";
      daySlide[i].style.display = "none";
      dayText[i].style.display = "none";
    }
  }
  showSlides();
}
function showSlides() 
{
  let i;
  let slides = document.getElementsByClassName("myslides");
  let quotes = document.getElementsByClassName("text-block");
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

  
  for (i = 0; i < slides.length; i++) 
  {
    if(i!=slideIndex)
    { 
      slides[i].style.display = "none";  
      quotes[i].style.display = "none";
    }
  }
  if(slides[slideIndex].getAttribute('name') == "vid")
  {
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