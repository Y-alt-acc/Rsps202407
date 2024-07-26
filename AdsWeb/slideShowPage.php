<?php
  require_once("./commonFunction.php");
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
  grid-template-columns: 2% 78% 18% 2%;
  grid-template-rows: 3% 94% 3%;
  grid-template-areas: 
    "header header header header"
    "sidebarleft media txt sidebarright"
    "footer footer footer footer";
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
.myslides
{
  display: none;
}
.mytext
{
  display:none;
}
img
{
  max-width: 78vw;
  min-height: 94vh;
  display:block;
  margin-left: auto; 
  margin-right: auto; 
  object-fit: contain;
}
video
{
  max-width: 78vw;
  min-height: 94vh;
  display:block;
  margin-left: auto; 
  margin-right: auto; 
  object-fit: contain;  
}
.text-block
{
  
  display: block;
  overflow-wrap: break-word;
  color: white;
  text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
  text-align: center;
  font-size : 2em;
  font-family: Arial, Helvetica, sans-serif;
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
              redirect("./home.html");
            }
            while($data = mysqli_fetch_assoc($result))
            {
              $mime = mime_content_type($data["media_path"]);
              if(strstr($mime,"video/"))
              {
                echo 
                '<div class="myslides" name="vid">
                <video preload="metadata">
                    <source src="'. $data["media_path"]. '"type="'.$mime.'">
                  Your browser does not support the video tag.
                </video>
                </div>';
              }else if(strstr($mime, "image/")) {
                echo
                '<div class ="myslides" name = "img" >
                  <img src="'.$data["media_path"].'">
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
          <p>'. $data["media_txt"].'</p>
        </div>
        '
        ?>
      </div>
      <div class="sideright"></div>
      <div class="bottom"></div>
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
      theDuration.push(-1);
    }else{
      theDuration.push(5);
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
  video.oncanplay = function(e)
  {
    theDuration[i] = video.duration;
    video.play();
  }
}
function bruteForceVideo(video, time)
{
  if(time > theDuration[slideIndex])
  {
    showSlides();
  }else{
    if(video.error.code > 0)
    {
      try
      {
        loadVideo(video, slideIndex);
      }catch{
      }finally{
        setTimeout(bruteForceVideo, 1000, video, time + 1);
      }
    }else{
      setTimeout(showSlides, theDuration[slideIndex] * 1000 + 1000);
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
      if(theDuration[slideIndex]>0)
      {
        setTimeout(showSlides, theDuration[slideIndex] * 1000 + 1000)
        // setTimeout(bruteForceVideo, 1000, video, 1);
      }else{
        setTimeout(showSlides, 2 * 1000);
      }
    }
  }else{
    setTimeout(showSlides, theDuration[slideIndex] * 1000); 
  }
}
</script>
</html>