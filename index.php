<!DOCTYPE html>
<html lang="en">

<head>
    <title>Parking Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f55ff8b89d.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="" method="post" id="login">
                    <h3 style="text-align: center;font-size: 25px;font-family: 'Poppins-Regular';">
                        Welcome to <br> Parking Management System
                    </h3><br>
                    <span class="login100-form-title p-b-43">
                        <hr>
                        Login
                    </span>


                    <div class="wrap-input100 validate-input" data-validate="Valid Email is required">
                        <input class="input100" type="email" id="txt_uname" name="Email">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Enter Email Address</span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" id="txt_pwd" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Enter Password</span>
                    </div>

                    <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>

                        </div>
                    </div>
                    <i>
                        <div style="text-align: center;padding-bottom: 10px;color: darkblue;">

                        </div>
                    </i>

                    <div class="container-login100-form-btn">
                        <input class="login100-form-btn" id="but_submit" name="login_btn" type="submit" value="Login" />

                        <?php
                        session_start();

                        require_once('connect.php');

                        // call the login() function if register_btn is clicked
                        if (isset($_POST['login_btn'])) {
                            login();
                        }

                        if (isset($_GET['logout'])) {
                            session_destroy();
                            unset($_SESSION['user']);
                            header("login.php");
                        }

                        function login()
                        {
                            //  require_once ('connect.php');
                            global $con, $email;
                            // grap form valuese($_POST['Email']);
                            $email = e($_POST['Email']);
                            $password = e($_POST['password']);

                            // attempt login if no errors on form

                            $password = md5($password);

                            //$query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
                            $query = "SELECT * FROM `user_account` WHERE `email`='$email' AND `password`='$password' AND `activated`='1' LIMIT 1";
                            $results = mysqli_query($con, $query);


                            if (mysqli_num_rows($results) == 1) { // user found
                                // check if user is admin or user
                                $logged_in_user = mysqli_fetch_assoc($results);

                                if ($logged_in_user['user_type'] == '1') {
                                    //$_SESSION['user'] = $logged_in_userid['user_id'];
                                    $_SESSION['email'] = $logged_in_user['email'];
                                    $_SESSION['user'] = $logged_in_user;
                                    $_SESSION['user_type'] = "Admin";
                                    $_SESSION['success']  = "You are now logged in";
                                    header('location: dashboard.php');
                                } else if ($logged_in_user['user_type'] == '2') {
                                    $_SESSION['email'] = $logged_in_user['email'];
                                    $_SESSION['user'] = $logged_in_user;
                                    $_SESSION['user_type'] = "Customer";
                                    $_SESSION['success']  = "You are now logged in";
                                    header('location: dashboard_Customer.php');
                                } else if ($logged_in_user['user_type'] == '3') {
                                    $_SESSION['email'] = $logged_in_user['email'];
                                    $_SESSION['user'] = $logged_in_user;
                                    $_SESSION['user_type'] = "Executive_Officer";
                                    $_SESSION['success']  = "You are now logged in";
                                    header('location: dashboard.php');
                                } else {
                                    echo "Undefined User";
                                }
                            } else {

                                echo "Wrong email/password combination";
                            }
                        }

                        function getUserById($id)
                        {
                            global $con;
                            //$query = "SELECT * FROM users WHERE id=" . $id;
                            $query = "SELECT * FROM `user_account` WHERE `user_id`" . $id;
                            //SELECT * FROM `cbm_user_account` WHERE `user_id`
                            $result = mysqli_query($con, $query);

                            $user = mysqli_fetch_assoc($result);
                            return $user;
                        }

                        function isLoggedIn()
                        {
                            if (isset($_SESSION['user'])) {
                                return true;
                            } else {
                                return false;
                            }
                        }

                        // function isAdmin()
                        // {
                        //     if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == '1') {
                        //         return true;
                        //     } else {
                        //         return false;
                        //     }
                        // }

                        // escape string
                        function e($val)
                        {
                            global $con;
                            return mysqli_real_escape_string($con, trim($val));
                        }

                        function display_error()
                        {
                            global $errors;

                            if (count($errors) > 0) {
                                echo '<div class="error">';
                                foreach ($errors as $error) {
                                    echo $error . '<br>';
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="customer_register.php">Create an Account!</a>
                    </div>
                </form>



                <div class="login100-more" style="background-image: url('images/bg-01.jpg');background-size: cover;">


                </div>
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © PMS 2020</span>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="js/main.js"></script>

</body>

</html>