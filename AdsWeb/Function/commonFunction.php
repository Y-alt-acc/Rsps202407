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
?>