<?php
include('layout/header.php');
$user_details = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id = '$_GET[user_id]'"));
?>
<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <div class="d-flex align-items-center justify-content-between">
            <h5>Test List</h5>
            <p class="fs-4 mb-0">Test records of <b><?= $user_details['name']?></b></p>
        </div>
        <hr>
        <table class="table hover-table" id="ppTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Test Name</th>
                    <th>Record Id</th>
                    <th>Status</th>
                    <th>Attempted Questions</th>
                    <th>Skipped Questions</th>
                    <th>Correct Answers</th>
                    <th>Wrong Answers</th>
                    <th>Mark Obtained</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM test_records WHERE user_id = '$_GET[user_id]' ORDER BY id DESC");
                $serial = 1;
                while ($res = mysqli_fetch_array($q)) {
                    $test_name = mysqli_fetch_array(mysqli_query($conn, "SELECT title FROM tests WHERE id = '$res[test_id]'"));
                ?>
                    <tr>
                        <td><?= $serial++ ?></td>
                        <td><?= $test_name['title'] ?></td>
                        <td><?= $res['record_id'] ?></td>
                        <td>
                            <button class="btn btn-<?= $res['status'] == 'completed' ? 'primary' : 'warning' ?> btn-sm"><?= ucfirst($res['status']) ?></button>
                        </td>
                        <td><?= $res['attempted_questions'] ?></td>
                        <td><?= $res['skipped_questions'] ?></td>
                        <td><?= $res['correct_answers'] ?></td>
                        <td><?= $res['wrong_answers'] ?></td>
                        <td><?= $res['marks_obtained'] ?></td>
                        <td><?= $res['created_at'] ?></td>
                        <td>
                            <a href="test_result.php?record_id=<?= $res['record_id']?>" class="btn btn-primary btn-sm">View Result</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include('layout/footer.php');
?>