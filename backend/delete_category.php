<?php

require('../layout/conn.php');
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if(isset($data['id'])){
    $q = "DELETE FROM categories WHERE id = '$data[id]'";
    $run = mysqli_query($conn, $q);

    if($run){
        echo json_encode(["message" => "Data deleted"]);
    } 
}