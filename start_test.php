<?php
include('./layout/header.php');
$incompleted_test = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM test_records WHERE user_id = '$user[id]' AND test_id = '$_GET[test_id]' AND status = 'incomplete'"));
?>
<div class="container bg-white p-4 my-5 rounded">
    <div class="d-flex justify-content-between align-items-center">
        <div class="left">
            <h4>HTML</h4>
            <p class="mb-0"><i class="fa fa-clock me-2"></i>5 Minutes | <i class="fa fa-question-circle"></i> 99 Questions</p>
        </div>
        <div class="right">
            <?php
            if ($incompleted_test) {
            ?>
                <a href="test_ongoing.php?record_id=<?= $incompleted_test['record_id']?>" class="btn btn-warning">Resume Test</a>
            <?php
            } else {
            ?>
                <button class="btn btn-info" onclick="createTestRecord()">Start Test</button>
            <?php
            }
            ?>
        </div>
    </div>
    <hr>
    <h5>Instructions</h5>
    <ul class="list-disc pl-3 text-sm">
        <li class="mb-1">Click on the “Start Test“ button to begin the test.</li>
        <li class="mb-1">You will see the first question on the screen along with the options.</li>
        <li class="mb-1">On the top of the screen, you will see a timer displaying the remaining time for the test.</li>
        <li class="mb-1">Read the question carefully and select your answer from the options provided.</li>
        <li class="mb-1">Click on the “Next“ button to move to the next question.</li>
        <li class="mb-1">If you want to skip a question, you can click on the “Skip“ button.</li>
        <li>You can also mark a question for review by clicking on the “Mark for Review“ button.</li>
        <li class="mb-1">If you want to go back to a previously answered question, you can use the “Previous“ button.</li>
        <li class="mb-1">You can also see a list of all the questions on the test by clicking on the “Question Palette“ button. This will allow you to jump to any question you want to review or answer.</li>
        <li class="mb-1">Keep an eye on the timer to ensure you complete the test within the allotted time.</li>
        <li class="mb-1">Once you have answered all the questions, click on the “Submit“ button to end the test.</li>
        <li>After submitting the test, you will see your score and the correct answers to the questions you answered.</li>
        <li class="mb-1">You can review your answers and compare them with the correct answers to evaluate your performance.</li>
    </ul>
</div>
<?php
include('./layout/footer.php');
?>

<script>
    async function createTestRecord() {
        const data = {
            user_id: '<?= $user['id'] ?>',
            test_id: '<?= $_GET['test_id'] ?>'
        }
        const request = await fetch('backend/create-test-record.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        const response = await request.json();

        if (response.message == "success") {
            Swal.fire(
                'Success!',
                'Record created successfully',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    location.replace("test_ongoing.php?record_id=" + response.record_id);
                }
            })

        }
    }
</script>