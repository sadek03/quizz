<?php
require('../layout/conn.php');
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['category_id'])) {
    $q = mysqli_query($conn, "SELECT * FROM tests WHERE category_id = '$data[category_id]'");

    $options = ''; 

    while ($row = mysqli_fetch_array($q)) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
    }
    echo json_encode(["message"=>"success", "data"=>$options]);
}
