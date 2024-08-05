<?php 
session_start();
function redirect($url) {
    header('Location: '.$url);
    die();
}
function serverGetImg(){
    require_once('./serverFunction.php');
    return viewActiveImg(1);
}
function serverGetTxt(){
    require_once('./serverFunction.php');
    return viewActiveTxt(1);
}
?>