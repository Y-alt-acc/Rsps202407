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
function serverGetImgDoc(){
    require_once('serverFunction.php');
    return viewActiveImg(2);
}
function serverGetTxtDoc(){
    require_once('serverFunction.php');
    return viewActiveTxt(2);
}
function serverGetTxtSch(){
    require_once('serverFunction.php');
    return viewActiveTxt(3);
}
?>