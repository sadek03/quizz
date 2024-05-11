<?php
include('./layout/header.php');

if (isset($_GET['edit'])) {
    $edit = true;
    $category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM questions WHERE id = '$_GET[edit]'"));
} else {
    $edit = false;
}

?>

<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <h5>Add Questions</h5>
        <hr>
        <form method="GET">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category_id" id="category" class="form-control" onchange="fetchTest()" required>
                            <option value="">Select Category</option>
                            <?php
                            $categories = mysqli_query($conn, "SELECT * FROM categories WHERE status = 'active'");
                            while ($data = mysqli_fetch_array($categories)) {
                            ?>
                                <option value="<?= $data['id'] ?>" ><?= $data['title'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="test">Test</label>
                        <select name="test_id" class="form-control" id="tests" required></select>
                        <option value="">Select Category First</option>
                    </div>
                </div>

                
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-dark ms-auto float-end">Upload Question</button>
                </div>
            </div>
        </form>
    </div>
</div>



<?php
if (isset($_GET['category_id']) && isset($_GET['test_id'])) {
?>
    <div class="container my-4">
        <div class="bg-white p-3 rounded">
            <h5>Add Questions</h5>
            <hr>
            <form method="POST">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" class="form-control" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="question">Option A</label>
                            <input type="text" class="form-control" placeholder="Option A" name="option_a" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="question">Option B</label>
                            <input type="text" class="form-control" placeholder="Option B" name="option_b" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="question">Option C</label>
                            <input type="text" class="form-control" placeholder="Option C" name="option_c" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="question">Option D</label>
                            <input type="text" class="form-control" placeholder="Option D" name="option_d" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <select name="answer" class="form-control">
                                <option value="option_a">Option A</option>
                                <option value="option_b">Option B</option>
                                <option value="option_c">Option C</option>
                                <option value="option_d">Option D</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" name="submit" class="btn btn-dark ms-auto float-end">Add Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
}
?>

<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <h5>Questions List</h5>
        <hr>
        <table class="table hover-table" id="ppTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Options</th>
                    <th>Answer</th>
                    <th>Category & Test</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM questions ORDER BY id DESC");
                $serial = 1;
                while ($data = mysqli_fetch_array($q)) {
                    $test = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tests WHERE id = '$data[test_id]'"));
                    $category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM categories WHERE id = '$test[category_id]'"));
                ?>
                    <tr valign="middle">
                        <td><?= $serial++ ?></td>
                        <td><?= $data['question'] ?></td>
                        <td>
                        <p class="mb-0">Option A: <?= htmlspecialchars($data['option_a']) ?></p>
                        <p class="mb-0">Option B: <?= htmlspecialchars($data['option_b']) ?></p>
                        <p class="mb-0">Option C: <?= htmlspecialchars($data['option_c']) ?></p>
                        <p class="mb-0">Option D: <?= htmlspecialchars($data['option_d']) ?></p>
                        </td>
                        <td><?= $data['answer'] ?></td>
                        <td>
                            <p class="mb-0">Test: <?= $test['title']?></p>
                            <p class="mb-0">Category: <?= $category['title']?></p>
                        </td>
                        <td><?= $data['created_at'] ?></td>
                        <td>
                            <button onclick="deleteCategory(<?= $data['id'] ?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
include('./layout/footer.php');

//Creating a category
if (isset($_POST['submit'])) {
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $answer = $_POST['answer'];
    
    $check = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM questions WHERE question = '$question'"));

    if ($check == 0) {
        $q = "INSERT INTO questions SET question = '$question', option_a = '$option_a', option_b = '$option_b', option_c = '$option_c', option_d = '$option_d', answer = '$answer', test_id = '$_GET[test_id]'";
        $run = mysqli_query($conn, $q);

        if ($run) {
        ?>
            <script>
                Swal.fire(
                    'Success!',
                    'Question Added Succesfully',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        
                        location.replace(location.href);
                    }
                })
            </script>
<?php
        }
    }
}
?>


<script>
    $(()=>{
        fetchTest() 
    })

    function selectDefaultTest(){
        var testId = '<?= $_GET['test_id'] ?? ''?>';
        var testSelect = $("#tests");

        testSelect.find('option').each(function () {
        if ($(this).val() === testId) {
            $(this).prop('selected', true);
        }
    });
    }

    async function fetchTest() {
        var category_id = $("#category").find('option:selected').val();
        if(category_id != ""){
            var testSelect = $("#tests");

        const request = await fetch('backend/fetch_tests.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                category_id
            })
        })

        const response = await request.json();
        testSelect.html(response.data)
        selectDefaultTest()
        }
    }

    function deleteCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const request = await fetch('backend/delete_question.php', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id
                    })
                })

                const response = await request.json();
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                ).then((res) => {
                    if (res.isConfirmed) {
                        location.replace("manage_questions.php");
                    }
                })
            }
        })

    }
</script>