<?php
include_once('../../paths.php');
use Firebase\JWT\JWT;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$database = new Database();
$db = $database->connect();

//instantiate post object
$user = new User($db);

//get raw posted data
$data = json_decode(file_get_contents('php://input'));

//get user info
$user->name = $data->name;
$user->email = $data->email;
$user->password = $data->password;

//use login method in User class to know if user is authenticated 
$validCred = $user->login();

if($validCred){
    //bind jwt payload
    $secretKey = $theKey;
    $issuedAt   = new DateTimeImmutable();
    $expire     = $issuedAt->modify('+6 minutes')->getTimestamp();      
    $serverName = "http://localhost/phptest/phpapi/api";
    $username   = $data->name;   

    //creating jwt token
    $token = [
        'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
        'iss'  => $serverName,                       // Issuer
        'nbf'  => $issuedAt->getTimestamp(),         // Not before
        'exp'  => $expire,                           // Expire
        'userName' => [
            'name' => $data->name,
            'email' => $data->email,
        ],                    
    ];

    http_response_code(200);
    //storing jwt hash in jwt variable
    $jwt = JWT::encode($token, $secretKey, 'HS512');
        echo json_encode(
            array(
                "message" => "Successful login.",
                //jwt hash needed for user to access auth locked methods
                "jwt" => $jwt,
            ));
}else{
    http_response_code(401);
    echo json_encode(["message" => "Login failed."]);
}