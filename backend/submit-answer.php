<?php
require('../layout/conn.php');
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if(isset($data['record_id']) && isset($data['question_id'])){
    $record = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM test_records WHERE record_id = '$data[record_id]'"));
    $question = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM questions WHERE id = '$data[question_id]'"));
    $updatedQuestionIds = ($record['attmp_question_ids'] != '') ? $record['attmp_question_ids'] . ', ' . $data['question_id'] : $data['question_id'];

    //

    if($data['selected_option'] != ""){
        //Selected option ahise, iyate answer check kora aru data update kora
        if($question['answer'] == $data['selected_option']){
            //Answer is correct 
            $query = "UPDATE test_records SET attempted_questions = attempted_questions + 1, correct_answers = correct_answers + 1, marks_obtained = marks_obtained + 2, attmp_question_ids = '$updatedQuestionIds' WHERE record_id = '$data[record_id]'";
            $response = json_encode(['message' => 'Good! Answer is correct', 'code' => 'success']);
        }else{
            //Answer is not correct
            $query = "UPDATE test_records SET attempted_questions = attempted_questions + 1, wrong_answers = wrong_answers + 1, attmp_question_ids = '$updatedQuestionIds' WHERE record_id = '$data[record_id]'";
            $response = json_encode(['message' => 'Oops! Answer is not correct', 'code' => 'error', 'correct_answer' => $question['answer']]);
        }
    }else{
        //For skip  
        $query = "UPDATE test_records SET attempted_questions = attempted_questions + 1, skipped_questions = skipped_questions + 1, attmp_question_ids = '$updatedQuestionIds' WHERE record_id = '$data[record_id]'";
        $response = json_encode(['message' => 'skipped', 'code' => 'skipped']);
    }

    $run = mysqli_query($conn, $query);


    //For Finalize the test
    $attempted_ques = $record['attempted_questions'] + 1; 
    $questions_available = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM questions WHERE test_id = '$record[test_id]'")); 

    if($attempted_ques == $questions_available){
        mysqli_query($conn, "UPDATE test_records SET status = 'completed' WHERE record_id = '$data[record_id]'");
        $response = json_encode(['message' => 'Test Completed', 'code' => 'completed']);
    }

    echo $response;
}
