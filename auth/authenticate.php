<?php


function authenticate($theKey){
    $secret_key = $theKey;
    $jwt = null;

    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

    $arr = explode(" ", $authHeader);

    $jwt = $arr[1];

    if($jwt){
        return true;
    }else{
        return false;
    }

}