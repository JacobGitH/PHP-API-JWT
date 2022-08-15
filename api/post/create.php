<?php
include_once('../../paths.php');
use Firebase\JWT\JWT;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(authenticate($theKey)){
    //instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    //instantiate post object
    $post = new Post($db);

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    //set data to object
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;    
    
    //create post
    if($post->create()){
        echo json_encode(['message' => 'created']);
    }else{
        echo json_encode(['message' => 'not created']);
    }

}else{
    echo json_encode(['message' => 'wrong token']);
}