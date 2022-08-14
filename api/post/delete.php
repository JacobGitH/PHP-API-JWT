<?php
declare(strict_types=1);
use Firebase\JWT\JWT;
require_once('../../vendor/autoload.php');
require_once('../../auth/auth_dat.php');
require_once('../../auth/authenticate.php');
include_once '../../config/Database.php';
include_once '../../models/Post.php';
include_once '../../models/User.php';

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

$post->id = $data->id;

if($post->delete()){
    echo "nice";
}else{
    echo "badge";
}
}else{
    echo json_encode(['message' => 'wrong token']);
}