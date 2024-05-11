<?php
include('./layout/header.php');

$categories = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories WHERE status = 'active'"));
$tests = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tests"));
$questions = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM questions"));
$users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE status = 'active'"));
?>

<div class="container my-4">
    <div class="bg-white p-3 rounded shadow py-4">
        <div class="d-flex align-items-center gap-3">
            <i class="fa fa-user fs-1"></i>
            <div class="texts">
                <h3 class="h6 mb-0">Hi, <?= $user['name'] ?></h3>
                <h1 class="mb-0 h3 fw-bold">Find the best test for you!</h1>
            </div>
        </div>
    </div>
    <?php
    if ($user['status'] == 'admin') {
    ?>
        <div class="row">
            <div class="col-md-3 p-3">
                <div class="bg-white p-3 rounded shadow">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-table-cells-large fs-1"></i>
                        <div class="texts">
                            <h3 class="h6 mb-0">Total Categories</h3>
                            <h1 class="mb-0 h3 fw-bold"><?= $categories ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 p-3">
                <div class="bg-white p-3 rounded shadow">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa fa-file fs-1"></i>
                        <div class="texts">
                            <h3 class="h6 mb-0">Total Tests</h3>
                            <h1 class="mb-0 h3 fw-bold"><?= $tests ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 p-3">
                <div class="bg-white p-3 rounded shadow">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa fa-circle-question fs-1"></i>
                        <div class="texts">
                            <h3 class="h6 mb-0">Total Questions</h3>
                            <h1 class="mb-0 h3 fw-bold"><?= $questions ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 p-3">
                <div class="bg-white p-3 rounded shadow">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa fa-users fs-1"></i>
                        <div class="texts">
                            <h3 class="h6 mb-0">Total Users</h3>
                            <h1 class="mb-0 h3 fw-bold"><?= $users ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="row">
        <div class="col-md-6 p-3 bg-white">
            <p class="mb-0">
                Available Categories
            </p>

            <?php
            $q = mysqli_query($conn, "SELECT * FROM categories WHERE status = 'active'");

            while ($data = mysqli_fetch_array($q)) {
                $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tests WHERE category_id = '$data[id]'"));
            ?>
                <a href="view_test.php?category_id=<?= $data['id'] ?>" class="text-decoration-none text-dark">
                    <div class="shadow p-3 rounded border border-2 my-2">
                        <div class="d-flex gap-3 align-items-center">
                            <img src="<?= $data['image'] ?>" alt="" class="img-fluid rounded" width="70">
                            <div class="texts">
                                <p class="mb-0 fw-bold h5"><?= $data['title'] ?></p>
                                <p class="mb-0">Available Test: <?= $count ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>

        <div class="bg-white rounded p-3 col-md-6">
            <table class="table table-hover" id="ppTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Test</th>
                        <th>Mark Obtained</th>
                        <th>Status</th>
                        <th>Attempted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $serial = 1;
                    $q = mysqli_query($conn, "SELECT * FROM test_records WHERE user_id = '$user[id]' AND status = 'completed' ORDER BY id DESC");
                    while ($res = mysqli_fetch_array($q)) {
                        $test = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tests WHERE id = '$res[test_id]'"));
                    ?>
                        <tr>
                            <td><?= $serial++ ?></td>
                            <td><?= $test['title'] ?></td>
                            <td><?= $res['marks_obtained'] ?></td>
                            <td><?= ucfirst($res['status']) ?></td>
                            <td><?= $res['created_at'] ?></td>
                            <td><a href="test_result.php?record_id=<?=$res['record_id']?>" class="btn btn-primary">View</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('./layout/footer.php');
?>