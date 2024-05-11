<?php
include('./layout/header.php');
$record = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM test_records WHERE record_id = '$_GET[record_id]'"));
$test = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tests WHERE id = '$record[test_id]' "));

//Getting attempted question ids
$question_ids = $record['attmp_question_ids'] ?? 0;


$questions = mysqli_query($conn, "SELECT * FROM questions WHERE test_id = '$test[id]' AND id NOT IN ($question_ids) ORDER BY RAND() LIMIT 1");
$total_question = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM questions WHERE test_id = '$test[id]'"));
$current_question = mysqli_fetch_assoc($questions);
?>

<div class="container bg-white p-4 my-5 mb-3 rounded">
    <div class="d-flex justify-content-between align-items-center">
        <div class="left">
            <h4><?= $test['title'] ?></h4>
            <p class="mb-0">Attempted Questions: <?= $record['attempted_questions'] + 1 ?> / <?= $total_question ?></p>
        </div>
        <div class="right d-flex align-items-center">
            <i class="fa fa-clock me-2"></i>
            <h5 class="mb-0"><span id="timer">30</span> Sec</h5>
        </div>
    </div>
</div>


<?php
if (mysqli_num_rows($questions) == 0) {
?>
    <div class="container rounded" style="background: #ffffff47;">
        <div class="texts p-3">
            <h1 class="mb-0 h6 fw-bold">Your test is completed</h1>
        </div>
    </div>
<?php
} else {
?>
    <div class="container rounded" style="background: #ffffff47;">
        <div class="row">
            <div class="col-md-12 p-3">
                <div class="bg-white p-3 rounded shadow">
                    <div class="d-flex align-items-center gap-3">
                        <h1 class="mb-0 bg-warning rounded-circle d-flex justify-content-center align-items-center" style="height: 60px; width: 60px"><i class="fa fa-question-circle"></i></h1>
                        <div class="texts">
                            <h1 class="mb-0 h6 fw-bold"><?= $current_question['question'] ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3">
                <div class="bg-white p-3 rounded shadow" id="option_a" onclick="selectOption('option_a')">
                    <div class="d-flex align-items-center gap-3">
                        <h1 class="mb-0 bg-info rounded-circle d-flex justify-content-center align-items-center" style="height: 60px; width: 60px">A</h1>
                        <div class="texts">
                            <h1 class="mb-0 h6 fw-bold"><?= htmlspecialchars($current_question['option_a']) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3">
                <div class="bg-white p-3 rounded shadow" id="option_b" onclick="selectOption('option_b')">
                    <div class="d-flex align-items-center gap-3">
                        <h1 class="mb-0 bg-info rounded-circle d-flex justify-content-center align-items-center" style="height: 60px; width: 60px">B</h1>
                        <div class="texts">
                            <h1 class="mb-0 h6 fw-bold"><?= htmlspecialchars($current_question['option_b']) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3">
                <div class="bg-white p-3 rounded shadow" id="option_c" onclick="selectOption('option_c')">
                    <div class="d-flex align-items-center gap-3">
                        <h1 class="mb-0 bg-info rounded-circle d-flex justify-content-center align-items-center" style="height: 60px; width: 60px">C</h1>
                        <div class="texts">
                            <h1 class="mb-0 h6 fw-bold"><?= htmlspecialchars($current_question['option_c']) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3">
                <div class="bg-white p-3 rounded shadow" id="option_d" onclick="selectOption('option_d')">
                    <div class="d-flex align-items-center gap-3">
                        <h1 class="mb-0 bg-info rounded-circle d-flex justify-content-center align-items-center" style="height: 60px; width: 60px">D</h1>
                        <div class="texts">
                            <h1 class="mb-0 h6 fw-bold"><?= htmlspecialchars($current_question['option_d']) ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full d-flex justify-content-center mb-3 gap-4">
                <button class="btn btn-lg btn-dark" id="skipButton" onclick="submitAnswer()">Skip</button>
                <button class="btn btn-lg btn-primary" id="nextButton" disabled onclick="submitAnswer()">Next</button>
            </div>
        </div>
    </div>
<?php
}

?>



<?php
include('./layout/footer.php');
?>


<script>
    var selectedOption = '';
    var time = 30;

    function selectOption(selectedId) {
        removeSelection()
        selectedOption = selectedId;
        var elem = $("#" + selectedId);
        elem.removeClass("bg-white");
        elem.addClass("bg-warning");

        //Handle the disabled button
        $("#nextButton").removeAttr("disabled");
        $("#skipButton").attr("disabled", true);
    }

    function removeSelection() {
        $("#option_a").removeClass("bg-warning").addClass("bg-white");
        $("#option_b").removeClass("bg-warning").addClass("bg-white");
        $("#option_c").removeClass("bg-warning").addClass("bg-white");
        $("#option_d").removeClass("bg-warning").addClass("bg-white");
    }

    async function submitAnswer() {
        const request = await fetch('backend/submit-answer.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                record_id: '<?= $_GET['record_id'] ?>',
                question_id: '<?= $current_question['id'] ?>',
                selected_option: selectedOption
            })
        });

        const response = await request.json();

        if (response.code == "skipped") {
            location.replace(location.href);
        } else if (response.code == "completed") {
            Swal.fire(
                "Success",
                response.message,
                "success"
            ).then((result) => {
                if (result.isConfirmed) {
                    location.replace('./test_result.php?record_id=<?= $_GET['record_id'] ?>');
                }
            })
        } else {
            Swal.fire({
                    icon: response.code,
                    title: response.code.toUpperCase(),
                    text: response.message,
                    footer: response.code == "success" ? "Great" : "Correct Answer is " + response.correct_answer
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        location.replace(location.href);
                    }
                })
        }
    }

    function tikTok() {
        var timer = $("#timer");

        setInterval(() => {

            if (time == 0) {
                submitAnswer()
            } else {
                time--
                timer.html(time)
            }

        }, 1000)

    }

    tikTok()
</script>