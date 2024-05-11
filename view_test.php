<?php
include('./layout/header.php');

$category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM categories WHERE id = '$_GET[category_id]'"));
?>

<div class="container my-4">
    <div class="bg-white p-3 rounded shadow py-4">
        <div class="d-flex align-items-center gap-3">
            <img src="<?= $category['image'] ?>" alt="" class="img-fluid" width="100">
            <div class="texts">
                <h1 class="mb-0 h3 fw-bold"><?= $category['title'] ?></h1>
                <h3 class="h6 mb-0"><?= $category['description'] ?></h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-3 rounded shadow py-4 mt-4">
        <p>Tests available in this category</p>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM tests WHERE category_id = '$_GET[category_id]' AND status = 'active'");
        while ($data = mysqli_fetch_array($q)) {
            $question_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM questions WHERE test_id = '$data[id]'"));
        ?>
            <div class="d-flex align-items-center justify-content-between gap-3 p-3 border border-2 rounded my-3">
                <div class="left d-flex gap-3 align-items-center">
                    <i class="fa fa-file fs-1"></i>
                    <div class="texts">
                        <h1 class="mb-2 h5 fw-bold"><?= $data['title'] ?></h1>
                        <h6 class="mb-0"><i class="fa fa-question-circle fs-6"></i> <?= $question_count?> Questions | <i class="fa fa-clock fs-6"></i> 25 Minutes</h6> 
                    </div>
                </div>
                <div class="right">
                    <a href="start_test.php?test_id=<?= $data['id']?>" class="btn btn-dark">Attempt Test<i class="fa fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        <?php
        }

        if(mysqli_num_rows($q) == 0){
            ?>
            <p class="p-3 text-center rounded border">There is no test available in this category</p>
            <?php
        }
        ?>
    </div>
</div>

<?php
include('./layout/footer.php');
?>