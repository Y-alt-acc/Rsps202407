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
.mySlides {display: none;}
img {
  
    display: block; 
    margin-left: auto; 
    margin-right: auto; 
    max-width: 100%; 
    height:100vh; 
    object-fit: cover; 
    background: cover;
}

.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

.container {
  position: relative;
  
}
.text-block {
  position: absolute;
  bottom: 20px;
  right: 20px;
  background-color: #66A94940;
  color: white;
  text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
  padding-left: 20px;
  padding-right: 20px;
}
.tester{

}
</style>

<head>
<title>Slide Show</title>
</head>
<body style="background-color:black;">
  <div class="container">
    
    <div id="display-image">
      <?php
        $result = serverGetImg();
        if($result->num_rows == 0)
        {
          redirect("./home.html");
        }
        while ($data = mysqli_fetch_assoc($result)) 
        {
          echo '<div class="mySlides fade" ><img src="'. $data['img_path'].'"></div>';
        }
        ?>
    </div>
    <div class="text-block">
        <?php
        $result = serverGetTxt();
        if($result->num_rows == 0)
        {
          redirect("./home.html");
        }
        while ($data = mysqli_fetch_assoc($result)) 
        {
          echo '<div class="tester"><h1>' . $data['img_txt'] . '</h1></div>';
          
        }
        ?>
    </div>
  </div>
    
</body>

<script>
let slideIndex = 0;
showSlides();
function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let tester = document.getElementsByClassName("tester");
  
  for (i = 0; i < slides.length; i++) 
  {
    slides[i].style.display = "none";  
    tester[i].style.display = "none";
  }
  slideIndex++; 
  if (slideIndex > slides.length) 
  {
    slideIndex = 1; 
    location.reload();
  }
  slides[slideIndex-1].style.display = "block";
  tester[slideIndex-1].style.display = "block";  
  setTimeout(showSlides, 4000); // Change image every 4 seconds 
}
</script>

</body>
</html>