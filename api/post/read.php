<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    //instantiate post object
    $post = new Post($db);

    //blog post query
    $result = $post->read();

    //get row count
    $num = $result->rowCount();

    if($num > 0){

        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $post_item = [
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name,
            ];

            //push to "data"
            array_push($posts_arr['data'], $post_item);
        }
        //turn to json and output
        echo json_encode($posts_arr);

    }else{
        echo json_encode(['message' => 'no posts']);
    }