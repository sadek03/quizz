<?php
include('./layout/header.php');

$record = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM test_records WHERE record_id = '$_GET[record_id]'"));
$total_questions = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM questions WHERE test_id = '$record[test_id]'"));
?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-3 p-3">
            <div class="bg-white p-3 rounded shadow">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-circle-question fs-1"></i>
                    <div class="texts">
                        <h3 class="h6 mb-0">Total Attempted</h3>
                        <h1 class="mb-0 h3 fw-bold"><?= $record['attempted_questions'] ?> / <?= $total_questions ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-3">
            <div class="bg-white p-3 rounded shadow">
                <div class="d-flex align-question gap-3">
                    <i class="fa fa-circle-question fs-1"></i>
                    <div class="texts">
                        <h3 class="h6 mb-0">Total Skipped</h3>
                        <h1 class="mb-0 h3 fw-bold"><?= $record['skipped_questions'] ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-3">
            <div class="bg-white p-3 rounded shadow">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa fa-circle-question fs-1"></i>
                    <div class="texts">
                        <h3 class="h6 mb-0">Total Correct</h3>
                        <h1 class="mb-0 h3 fw-bold"><?= $record['correct_answers'] ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-3">
            <div class="bg-white p-3 rounded shadow">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa fa-circle-question fs-1"></i>
                    <div class="texts">
                        <h3 class="h6 mb-0">Total Wrong</h3>
                        <h1 class="mb-0 h3 fw-bold"><?= $record['wrong_answers'] ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 p-3">
            <div class="bg-white p-3 rounded shadow">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-circle-question fs-1"></i>
                    <div class="texts">
                        <h3 class="h6 mb-0">Record Id: #<?= $_GET['record_id'] ?></h3>
                        <h1 class="mb-0 h5 mt-2 fw-bold">Marks Obtained: <?= $record['marks_obtained'] ?> out of <?= $total_questions * 2 ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-white rounded p-3">
        <table class="table table-hover" id="ppTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Option A</th>
                    <th>Option B</th>
                    <th>Option C</th>
                    <th>Option D</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial = 1;
                $questions_ids = $record['attmp_question_ids'];
                $q = mysqli_query($conn, "SELECT * FROM questions WHERE id IN ($questions_ids)");
                while ($res = mysqli_fetch_array($q)) {
                ?>
                    <tr>
                        <td><?= $serial++?></td>
                        <td><?= $res['question']?></td>
                        <td class="<?= $res['answer'] == 'option_a' ? 'bg-success text-white' : ''?>"><?= htmlspecialchars($res['option_a'])?></td>
                        <td class="<?= $res['answer'] == 'option_b' ? 'bg-success text-white' : ''?>"><?= htmlspecialchars($res['option_b'])?></td>
                        <td class="<?= $res['answer'] == 'option_c' ? 'bg-success text-white' : ''?>"><?= htmlspecialchars($res['option_c'])?></td>
                        <td class="<?= $res['answer'] == 'option_d' ? 'bg-success text-white' : ''?>"><?= htmlspecialchars($res['option_d'])?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include('./layout/footer.php');
?>