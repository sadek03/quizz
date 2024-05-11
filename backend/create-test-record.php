<?php

require('../layout/conn.php');
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if(isset($data['user_id']) && isset($data['test_id'])){

    $record_id = "PP_".rand(111111111, 9999999999);
    $q = "INSERT INTO test_records SET user_id = '$data[user_id]', test_id = '$data[test_id]', record_id = '$record_id'";
    $run = mysqli_query($conn, $q);

    if($run){
        echo json_encode(['message' => 'success', 'record_id' => $record_id]);
    }else{
        echo json_encode(['message' => 'error']);
    }
}
