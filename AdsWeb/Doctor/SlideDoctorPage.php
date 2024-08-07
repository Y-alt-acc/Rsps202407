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
  grid-template-columns: 2% 60% 18% 18% 2%;
  
  grid-template-rows: 3% 25% 66% 6%;
  grid-template-areas: 
    "header header header header header"
    "sidebarleft media txt txt sidebarright"
    "sidebarleft media doctor schedule sidebarright"
    "footer footer footer footer footer";
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
.dctr
{
  width: 100%;
  height:100%;
  grid-area:doctor;
  background-color: #FF0000;
}
.schdl
{
  width: 100%;
  height:100%;
  grid-area:schedule;
  background-color: #0000FF;
}
.myslides
{
  display: none;
}
.mytext
{
  display:none;
}
body
{
  overflow: hidden;
}
img
{
  max-width: 60vw;
  min-height: 91vh;
  display:block;
  margin-left: auto; 
  margin-right: auto;
  object-fit: fill;
}
video
{
  max-width: 60vw;
  min-height: 91vh;
  display:block;
  margin-left: auto; 
  margin-right: auto; 
  object-fit: fill;
}
.text-block
{
  
  display: block;
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
            $result = serverGetImgDoc();
            if($result->num_rows == 0)
            {
              redirect("./home.html");
            }
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
          ?>
      </div>
      <div class="quote">
        <?php
        $result = serverGetTxtDoc();
        while($data = mysqli_fetch_assoc($result))
        echo '
        <div class="text-block">
          <p>'. $data["doc_txt"].'</p>
        </div>
        '
        ?>
      </div>
      <div class="dctr"></div>
      <div class="schdl"></div>
      <div class="sideright"></div>
      <div class="bottom"><h1 class = "text-mov">SELAMAT DATANG DI RUMAH SAKIT PREMIER SURABAYA</h1></div>
    </div>
  </body>
</head>
<script>
let slideIndex = 0;
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
showSlides(); 
function setDuration()
{
  let slides = document.getElementsByClassName("myslides");
  for (let i = 0; i < slides.length; i++) 
  {
    if(slides[i].getAttribute('name') == "vid")
    {
      theDuration.push(10);
    }else{
      theDuration.push(1);
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
function showSlides() 
{
  let i;
  let slides = document.getElementsByClassName("myslides");
  let quotes = document.getElementsByClassName("text-block");
  slideIndex++; 
  if (slideIndex >= slides.length) 
  {
    slideIndex = 0; 
    //location.reload();
  }
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