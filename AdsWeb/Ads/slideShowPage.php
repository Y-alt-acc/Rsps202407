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
  grid-template-columns: 2% 60% 36% 2%;
  
  grid-template-rows: 3% 91% 6%;
  grid-template-areas: 
    "header header header header"
    "sidebarleft media txt sidebarright"
    "footer footer footer footer";
    width: 100vw;
    height: 100vh;
    align-items: center;
    background-color:#454B1B;
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
  background-color: #355E3B
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
.quote
{
  width: 100%;
  grid-area: txt;
  background-color: 	#2E8B57;
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
  /* object-fit: contain; */
  object-fit: fill;
}
video
{
  max-width: 60vw;
  min-height: 91vh;
  display:block;
  margin-left: auto; 
  margin-right: auto; 
  /* object-fit: contain;   */
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
  animation-duration: 30s;
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
}
@keyframes text-mov-bot
{
  from {left: 87%;}
  to {left: -87%;}
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
            $result = serverGetImg();
            if($result->num_rows == 0)
            {
              redirect("../home.html");
            }
            while($data = mysqli_fetch_assoc($result))
            {
              $mime = mime_content_type($data["med_path"]);
              if(strstr($mime,"video/"))
              {
                echo 
                '<div class="myslides" name="vid">
                <video preload="metadata">
                    <source src="'. $data["med_path"]. '#t=0.1" type="'.$mime.'">
                  Your browser does not support the video tag.
                </video>
                </div>';
              }else if(strstr($mime, "image/")) {
                echo
                '<div class ="myslides" name = "img" >
                  <img src="'.$data["med_path"].'">
                </div>
                ';
              }
            }
          ?>
      </div>
      <div class="quote">
        <?php
        $result = serverGetTxt();
        while($data = mysqli_fetch_assoc($result))
        echo '
        <div class="text-block">
          <p>'. $data["med_txt"].'</p>
        </div>
        '
        ?>
      </div>
      <div class="sideright"></div><h1></h1>
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
  clicked = true;
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
    if(audioPaused){
      audio[musicIndex].muted = true;  
    }else{
      audio[musicIndex].muted = false;  
    }
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
      setTimeout(audioUnpause(), 2000);
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