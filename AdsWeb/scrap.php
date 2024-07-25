<?php
  require_once("./commonFunction.php");
?>
<!DOCTYPE html>
<html>
    
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
/* * {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent;
    font-family: Arial, sans-serif;
} */

.container {
  display: grid;
  grid-template-columns: 2% 78% 18% 2%;
  grid-template-rows: 2% 96% 2%;
  grid-template-areas: 
    "header header header header"
    "sidebar main txt sidebar"
    "footer footer footer footer";

  font-size: 2em;
  width: 100vw;
  background-color: #66A949FF;
  align-items: center;
}
.item1 {
  grid-area: header;
}
.item2 {
  grid-area: sidebar;
}
.item3 {
  grid-area: main;
}
.item4 {
  grid-area: txt;
}
.item5 {
  grid-area: footer;
}
/* .mySlides {display: none;   }
img {
    display: block; 
    margin-left: auto; 
    margin-right: auto; 
    max-width: 100% !important; 
    min-height:100vh !important; 
    object-fit: contain; 
    background: cover;
    
}
video {
  display: block; 
  margin-left: auto; 
  margin-right: auto; 
  max-width: 100% !important; 
  min-height:100vh !important; 
  object-fit: contain; 
}
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}
@keyframes fade {
  from {opacity: 1} 
  to {opacity: 1}
}
.borderbase {
  background-color: #FFFFFF;
}
.text-block {
  overflow-wrap: break-word;
  display: block; 
  color: white;
  text-align: center;
  margin: auto;

  text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
} 
.quotes{

} */
</style>

<head>
<title>Slide Show</title>
</head>
<body style="background-color:black;">
  <div class="container">
    <div id="item-a" class="item1 "></div>
    <div id="item-b" class="item2 "></div>
    <div id="item-c" class ="item3">
      <?php
        $result = serverGetImg();
        if($result->num_rows == 0)
        {
          redirect("./home.html");  
        }
        while ($data = mysqli_fetch_assoc($result)) 
        {
          $mime = mime_content_type($data['media_path']);
          if(strstr($mime, "video/")){
            echo '<div class="mySlides" name ="vid" >
            <video preload="metadata"><source src="'. $data['media_path'].'" type="'. $mime .'"> src=">Your browser does not support the video tag.</video>
            </div>';
          }else if(strstr($mime, "image/")){
            echo '<div class="mySlides fade" name ="img" >
            <img src="'. $data['media_path'].'">
            </div>';
          }
        }
        ?>
    </div>
    <div id="item-d" class ="item4">
        <?php
        $result = serverGetTxt();
        if($result->num_rows == 0)
        {
          redirect("./home.html");
        }
        while ($data = mysqli_fetch_assoc($result)) 
        {
          echo '<div class="text-block"><h1>' . $data['media_txt'] . '</h1></div>';
          
        }
        ?>
    </div>
    <div id="item-e" class="item5">aaaaaa </div>
  </div>
</body>

<script>
let slideIndex = 0;
let clicked = false;
let theDuration = [];

document.addEventListener('click', e => {
  clicked = true;
  if(document.getElementsByClassName("mySlides")[slideIndex].getAttribute('name') == "vid")
  {
      video.muted = false; 
  }
});
setDuration();
showSlides(); 
function setDuration()
{
  console.log("AAAAAAAAAAAAAAAAAAA");
  let slides = document.getElementsByClassName("mySlides");
  for (let i = 0; i < slides.length; i++) 
  {
    slides[i].style.display = "block";
    if(slides[i].getAttribute('name') == "vid")
    {
      video = slides[i].querySelector("video");
      video.load();
      
      console.log(video.duration);
      //theDuration.push(1);
    }else{
      theDuration.push(4);
    }
    
  }
}
function loadVideo(video)
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
    video.play();
  }
}

function showSlides() 
{
  console.log("aaaaaaaaaaaaaaaaaaaa");
  let i;
  let slides = document.getElementsByClassName("mySlides");
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
      loadVideo(video);
    }catch{
    }finally{
      setTimeout(showSlides, 5 * 1000);
    }
     
    
  }else{
    setTimeout(showSlides, theDuration[slideIndex] * 1000); 
  }
}
</script>

</body>
</html>