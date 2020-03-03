<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: http://localhost/sainprohost/public_html/index.php");
}else{
    if((time() - $_SESSION["last_activity"]) > 1000){
        header("location: http://localhost/sainprohost/public_html/operations/set-unset-session.php?action=logOut");
    }else{
        $_SESSION["last_activity"] = time();
    }
}