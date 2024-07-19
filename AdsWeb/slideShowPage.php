<?php
  require_once("./commonFunction.php");
?>
<!DOCTYPE html>
<html>
    
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent;
}
.container {
  display: grid;
  grid-template-columns: 80% 1% 19%;
  /* clear: both; */
  font-size: 2em;
  width: 100vw;
  background-color: #66A94980;
  /* background-color: #66b8EE80; */
}
.mySlides {display: none;   }
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
  from {opacity: .4} 
  to {opacity: 1}
}
.borderbase {
  background-color: #66b8EE80;
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

}
</style>

<head>
<title>Slide Show</title>
</head>
<body style="background-color:black;">
  <div class="container">
    
    <div id="display-media">
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
            echo '<div class="mySlides fade" name ="vid" >
            <video src="'. $data['media_path'].'" type='. $mime .'>
            </div>';
          }else if(strstr($mime, "image/")){
            echo '<div class="mySlides fade" name ="img" >
            <img src="'. $data['media_path'].'">
            </div>';
          }
        }
        ?>
    </div>
    <div id="display-border" class=" borderbase"></div>
    <div id="display-text" >
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
  </div>
</body>

<script>
let slideIndex = 0;
let clicked = false;
document.addEventListener('click', e => {
  clicked = true;
  if(document.getElementsByClassName("mySlides")[slideIndex-1].getAttribute('name') == "vid")
  {
      video.muted = false; 
  }
})
showSlides();
function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let quotes = document.getElementsByClassName("text-block");

  for (i = 0; i < slides.length; i++) 
  {
    slides[i].style.display = "none";  
    quotes[i].style.display = "none";
  }
  slideIndex++; 
  if (slideIndex > slides.length) 
  {
    slideIndex = 1; 
    //location.reload();
  }

  slides[slideIndex-1].style.display = "block";
  quotes[slideIndex-1].style.display = "block";

  if(slides[slideIndex-1].getAttribute('name') == "vid")
  {
    video = slides[slideIndex-1].querySelector("video")
    video.load();
    if(clicked)
    {
      video.muted = false; 
    }else{
      video.muted = true; 
    }
    video.play();
    video.onloadedmetadata = (event) => {
      setTimeout(showSlides, video.duration * 1000);
    }
  }else{
    setTimeout(showSlides,  15000); 
  }
  }
</script>

</body>
</html>