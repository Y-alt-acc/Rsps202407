<?php 
session_start();
function redirect($url) {
    header('Location: '.$url);
    die();
}
function goToHome()
{
    redirect(('/adsweb/home.html'));
}
function goToHomeuser()
{
    redirect(('/adsweb/homeuser.html'));
}
function goToView()
{
    redirect('./fileView.php');
}
function serverGetImg(){
    require_once('serverFunction.php');
    return viewActiveImg(1);
}

function serverGetTxt(){
    require_once('serverFunction.php');
    return viewActiveTxt(1);
}
function serverGetImgDoc($switch){
    require_once('serverFunction.php');
    return viewActiveDocImg(GetDay($switch));
    //return viewActiveImg(2);
}
function serverGetTxtDoc($switch){
    require_once('serverFunction.php');
    return viewActiveDocTxt(GetDay($switch));
    //return viewActiveTxt(2);
}
function serverGetTxtSch($switch){
    require_once('serverFunction.php');
    return viewActiveSch(GetDay($switch));
}

function GetDay($switch)
{
    switch ($switch) {
        case 1:
            $day = "Monday";
            break;
        case 2:
            $day = "Tuesday";
            break;
        case 3:
            $day = "Wednesday";
            break;
        case 4:
            $day = "Thursday";
            break;
        case 5:
            $day = "Friday";
            break;
        case 6:
            $day = "Saturday";
            break;
        case 7:
            $day = "Sunday";
            break;
        default:
          break;
    }
    return $day;
}
?>