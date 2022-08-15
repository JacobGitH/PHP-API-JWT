<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers/Content-Type/Access-Control-Allow-Methods/Authorization/X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';
include_once '../../models/User.php';

    //instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    //instantiate post object
    $user = new User($db);

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    $password = password_hash($data->password, PASSWORD_BCRYPT);

    $user->name = $data->name;
    $user->password = $password;
    $user->email = $data->email;


    if($user->create()){
        echo json_encode(['message' => 'created']);
    }else{
        echo json_encode(['message' => 'not created']);
    }