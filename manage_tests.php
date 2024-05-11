<?php
include('./layout/header.php');


if (isset($_GET['edit'])) {
    $edit = true;
    $test = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tests WHERE id = '$_GET[edit]'"));
} else {
    $edit = false;
}

?>

<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <h5><?= $edit ? "Update" : "Add New" ?> Test</h5>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" placeholder="Title" name="title" value="<?= $test['title'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="descirption">Description</label>
                        <input type="text" class="form-control" placeholder="Descirption" name="descirption" value="<?= $test['description'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php
                            $categories = mysqli_query($conn, "SELECT * FROM categories WHERE status = 'active'");
                            while ($data = mysqli_fetch_array($categories)) {
                            ?>
                                <option value="<?= $data['id'] ?>" <?= $edit && $test['category_id'] == $data['id'] ? 'selected' : '' ?>><?= $data['title'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" <?= $edit && $test['status'] == "active" ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $edit && $test['status'] == "inactive" ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" name="<?= $edit ? "update" : "submit" ?>" class="btn btn-dark ms-auto float-end"><?= $edit ? "Update" : "Add" ?> Test</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <h5>Tests List</h5>
        <hr>
        <table class="table hover-table" id="ppTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM tests ORDER BY id DESC");
                $serial = 1;
                while ($data = mysqli_fetch_array($q)) {
                    $category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM categories WHERE id = '$data[category_id]'"));
                ?>
                    <tr valign="middle">
                        <td><?= $serial++ ?></td>
                        <td><?= $data['title'] ?></td>
                        <td><?= $category['title'] ?></td>
                        <td><?= $data['description'] ?></td>
                        <td>
                            <span class="badge form-control rounded bg-<?= $data['status'] == 'active' ? 'primary' : 'warning text-dark' ?>"><?= ucfirst($data['status']) ?></span>
                        </td>
                        <td><?= $data['created_at'] ?></td>
                        <td>
                            <a href="?edit=<?= $data['id'] ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                            <button onclick="deletetest(<?= $data['id'] ?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $descirption = $_POST['descirption'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];

    $q = "UPDATE tests SET title = '$title', description = '$descirption', status = '$status', category_id = '$category_id' WHERE id = '$_GET[edit]'";
    $run = mysqli_query($conn, $q);

    if ($run) {
?>
        <script>
            Swal.fire(
                'Success!',
                'Test Updated Succesfully',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    location.replace("manage_tests.php");
                }
            })
        </script>
        <?php
    }
}

//Creating a test
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $descirption = $_POST['descirption'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];

    $check = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tests WHERE title = '$title' AND category_id = '$category_id'"));

    if ($check == 0) {
        $q = "INSERT INTO tests SET title = '$title', description = '$descirption', status = '$status', category_id = '$category_id'";
        $run = mysqli_query($conn, $q);

        if ($run) {
        ?>
            <script>
                Swal.fire(
                    'Success!',
                    'Test Added Succesfully',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.replace("manage_tests.php");
                    }
                })
            </script>
<?php
        }
    }
}
?>


<script>
    function deletetest(id) {
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
                const request = await fetch('backend/delete_test.php', {
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
                        location.replace("manage_tests.php");
                    }
                })
            }
        })

    }
</script>