<?php
    session_start();
    $errors = array();
    if (!empty($_POST)) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
        if (count($errors) == 0) {
            $password = md5($password);
            require('includes/connexion.php');
            $db = connect_bd();
            $stmt = $db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
            $stmt->execute([$username, $password]);
            // Fetch the records so we can display them in our template.
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($results) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('location: dashboard.php');
                die();
            }else {
                array_push($errors, "Wrong username or password ");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Authentification</title>
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
    </head>
    <body class="bg-dark">
    <div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
        <form method="post" action="login.php">
            <?php include('errors.php'); ?>
            <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input class="form-control"  type="text" name="username">
            </div>
            <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control"  type="password" name="password">
            </div>
            <div class="form-group">
            <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="login_user">Login</button>
        </form>
        <div class="text-center">
            <a class="d-block small mt-3" href="register.php">Register an Account</a>
        <!-- <a class="d-block small" href="forgot-password.php">Forgot Password?</a>-->
        </div>
        </div>
    </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    </body>
</html>