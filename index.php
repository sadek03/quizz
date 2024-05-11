<?php
session_start();
require('./layout/conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/style.css">
    <title>Login</title>
</head>

<body style="background-image: url('https://images.unsplash.com/photo-1532012197267-da84d127e765');">

    <div class="main">
        <div class="form p-4 shadow bg-white rounded-3">
            <div class="d-flex align-items-center flex-column justify-content-center">
                <img src="https://www.penprogrammer.com/logo/logo-dark.png" alt="" class="img-fluid w-50">
                <!-- <h3 class="text-center fw-10">College project</h3> -->
                <h5 class="text-center text-secondary">Login your account</h5>
            </div>
            <form method="POST" class="mt-5">
                <div class="form-group mb-2">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" placeholder="Email" name="email" required>
                </div>
                <div class="form-group mb-2">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100 mt-2">Submit</button>

                <div class="form-group mb-2 text-center">
                    <label class="mt-3">Don't have account? <a href="sign-up.php" class="fw-bold text-decoration-none">Create an account</a></label>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        //Check the email and password
        $check = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$password'"));

        if ($check != 0) {
            $_SESSION['email'] = $email;
    ?>
            <script>
                Swal.fire(
                    'Success!',
                    'Login Successfull',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.replace("dashboard.php");
                    }
                })
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire(
                    'Oops!',
                    'Email or password is incorrect',
                    'error'
                )
            </script>
    <?php
        }
    }
    ?>
</body>

</html>