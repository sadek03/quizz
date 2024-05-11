<?php
session_start();
require('./layout/conn.php');

if (!$_SESSION['email']) {
?>
    <script>
        location.replace('index.php');
    </script>
<?php
} else {
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE `email` = '$_SESSION[email]'"));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <title>Dashboard</title>
</head>

<body style="background-image: url('https://images.unsplash.com/photo-1532012197267-da84d127e765');">
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-3">
        <div class="container">
            <a class="navbar-brand" href="#">PP Quiz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./dashboard.php">Home</a>
                    </li>

                    <?php
                    if ($user['status'] == 'admin') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./manage_categories.php">Manage Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./manage_tests.php">Manage Test</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./manage_tests.php">Manage Tests</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./manage_questions.php">Manage Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./manage_users.php">Manage Users</a>
                        </li>
                    <?php
                    } 
                    ?>

                </ul>
                <div class="d-flex align-items-center gap-3">
                    <h4 class="mb-0 h6"><?= $user['name'] ?></h4>
                    <a class="btn btn-outline-primary" href="./layout/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>