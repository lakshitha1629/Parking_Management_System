<!DOCTYPE html>
<html lang="en">

<head>
    <title>Parking Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="" method="post" id="login">
                    <h3 style="text-align: center;font-size: 25px;">
                        Welcome to <br> Parking Management System
                    </h3><br>
                    <span class="login100-form-title p-b-43">
                        <hr>
                        Login
                    </span>


                    <div class="wrap-input100 validate-input" data-validate="Valid username is required">
                        <input class="input100" type="text" id="txt_uname" name="Username">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Enter Username</span>
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
                            global $con, $username;
                            // grap form valuese($_POST['username']);
                            $username = e($_POST['Username']);
                            $password = e($_POST['password']);

                            // attempt login if no errors on form

                            $password = md5($password);

                            //$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
                            $query = "SELECT * FROM `user_account` WHERE `user_name`='$username' AND `password`='$password' AND `activated`='1' LIMIT 1";
                            $results = mysqli_query($con, $query);


                            if (mysqli_num_rows($results) == 1) { // user found
                                // check if user is admin or user
                                $logged_in_user = mysqli_fetch_assoc($results);

                                if ($logged_in_user['user_type'] == '1') {
                                    //$_SESSION['user'] = $logged_in_userid['user_id'];
                                    $_SESSION['user_name'] = $logged_in_user['user_name'];
                                    $_SESSION['user'] = $logged_in_user;
                                    $_SESSION['user_type'] = "Admin";
                                    $_SESSION['success']  = "You are now logged in";
                                    header('location: dashboard.php');
                                } else if ($logged_in_user['user_type'] == '2') {
                                    $_SESSION['user_name'] = $logged_in_user['user_name'];
                                    $_SESSION['user'] = $logged_in_user;
                                    $_SESSION['user_type'] = "Vendor";
                                    $_SESSION['success']  = "You are now logged in";
                                    header('location: dashboard_Vendor.php');
                                } else if ($logged_in_user['user_type'] == '3') {
                                    $_SESSION['user_name'] = $logged_in_user['user_name'];
                                    $_SESSION['user'] = $logged_in_user;
                                    $_SESSION['user_type'] = "Executive Officer";
                                    $_SESSION['success']  = "You are now logged in";
                                    header('location: dashboard.php');
                                } else {
                                    echo "Undefined User";
                                }
                            } else {

                                echo "Wrong username/password combination";
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
                </form>



                <div class="login100-more" style="background-image: url('images/bg-01.jpg');background-size: cover;">


                </div>
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Mobitel 2019</span>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>