<?php
include('./layout/header.php');

if (isset($_GET['edit'])) {
    $edit = true;
    $category = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM categories WHERE id = '$_GET[edit]'"));
} else {
    $edit = false;
}

?>

<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <h5><?= $edit ? "Update" : "Add New" ?> Category</h5>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" placeholder="Title" name="title" value="<?= $category['title'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="descirption">Description</label>
                        <input type="text" class="form-control" placeholder="Descirption" name="descirption" value="<?= $category['description'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" <?= $edit ? '' : 'required' ?>>
                        <?= $edit ? "<a class='text-decoration-none' href=" . $category['image'] . "><small>Click to view the Image</small></a>" : "" ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" <?= $edit && $category['status'] == "active" ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $edit && $category['status'] == "inactive" ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" name="<?= $edit ? "update" : "submit" ?>" class="btn btn-dark ms-auto float-end"><?= $edit ? "Update" : "Add" ?> Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container my-4">
    <div class="bg-white p-3 rounded">
        <h5>Categories List</h5>
        <hr>
        <table class="table hover-table" id="ppTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
                $serial = 1;
                while ($data = mysqli_fetch_array($q)) {
                ?>
                    <tr valign="middle">
                        <td><?= $serial++ ?></td>
                        <td>
                            <img src="<?= $data['image'] ?>" alt="" class="img-fluid rounded" width="70">
                        </td>
                        <td><?= $data['title'] ?></td>
                        <td><?= $data['description'] ?></td>
                        <td>
                            <span class="badge form-control rounded bg-<?= $data['status'] == 'active' ? 'primary' : 'warning text-dark' ?>"><?= ucfirst($data['status']) ?></span>
                        </td>
                        <td><?= $data['created_at'] ?></td>
                        <td>
                            <a href="?edit=<?= $data['id'] ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
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

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $descirption = $_POST['descirption'];
    $status = $_POST['status'];

    if ($_FILES['image'] && $_FILES['image']['tmp_name']) {
        $image = $_FILES['image'];
        $filename = $image['name'];
        $fileerror = $image['error'];
        $filetmp = $image['tmp_name'];
        $fileext = explode('.', $filename);
        $filecheck = strtolower(end($fileext));
        $fileextstored = array('png', 'jpg', 'jpeg');

        if (in_array($filecheck, $fileextstored)) {
            $destination = 'icons/' . $filename;
            move_uploaded_file($filetmp, $destination);
        }
    } else {
        $destination = $category['image'];
    }

    $q = "UPDATE categories SET title = '$title', description = '$descirption', status = '$status', image = '$destination' WHERE id = '$_GET[edit]'";
    $run = mysqli_query($conn, $q);

    if ($run) {
?>
        <script>
            Swal.fire(
                'Success!',
                'Category Updated Succesfully',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    location.replace("manage_categories.php");
                }
            })
        </script>
        <?php
    }
}

//Creating a category
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $descirption = $_POST['descirption'];
    $status = $_POST['status'];

    $image = $_FILES['image'];
    $filename = $image['name'];
    $fileerror = $image['error'];
    $filetmp = $image['tmp_name'];
    $fileext = explode('.', $filename);
    $filecheck = strtolower(end($fileext));
    $fileextstored = array('png', 'jpg', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {
        $destination = 'icons/' . $filename;
        move_uploaded_file($filetmp, $destination);
    }

    $check = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories WHERE title = '$title'"));

    if ($check == 0) {
        $q = "INSERT INTO categories SET title = '$title', description = '$descirption', status = '$status', image = '$destination'";
        $run = mysqli_query($conn, $q);

        if ($run) {
        ?>
            <script>
                Swal.fire(
                    'Success!',
                    'Category Added Succesfully',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.replace("manage_categories.php");
                    }
                })
            </script>
<?php
        }
    }
}
?>


<script>
     function deleteCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(async(result) => {
            if (result.isConfirmed) {
                const request = await fetch('backend/delete_category.php', {
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
                ).then((res)=>{
                    if(res.isConfirmed){
                        location.replace("manage_categories.php");
                    }
                })
            }
        })

    }
</script>