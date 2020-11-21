<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Parking Management System</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control" name="FirstName" placeholder="First Name" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="LastName" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control" name="VehicleNumberPlate" placeholder="Vehicle Number Plate" maxlength="10" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="VehicleTypes" id="VehicleTypes" class="form-control" required>
                                            <option value="Car">Car</option>
                                            <option value="Van">Van</option>
                                            <option value="Jeep">Jeep</option>
                                            <option value="Truck">Truck</option>
                                            <option value="Motorbike">Motorbike</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="PhoneNumber" placeholder="Phone Number" maxlength="10" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="Email" placeholder="Email Address" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control" name="Password" placeholder="Password" maxlength="30" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" name="RepeatPassword" placeholder="Repeat Password" maxlength="30" required>
                                    </div>
                                </div>
                                <input class="btn btn-primary btn-user btn-block" id="reg_submit" name="reg_btn" type="submit" value="Register Account" />

                            </form>
                            <?php

                            if (isset($_POST['reg_btn'])) {
                                require_once('connect.php');
                                //$date = $_POST['date'];
                                $name = $_POST['FirstName'] .' '. $_POST['LastName'];
                                $VehicleNumberPlate = $_POST['VehicleNumberPlate'];
                                $VehicleTypes = $_POST['VehicleTypes'];
                                $PhoneNumber = $_POST['PhoneNumber'];
                                $Email = $_POST['Email'];
                                $password1 = $_POST['Password'];
                                $password2 = $_POST['RepeatPassword'];
                                $type = '2';
                                $active = '1';

                                if ($password1 != $password2) {
                                    echo "The two passwords do not match";
                                } else {
                                    $password = md5($password1);
                                    $qry = "INSERT INTO `user_account`(`name`, `email`, `user_type`, `password`, `activated`, `number_plate`, `vehicle_type`, `phone`) VALUES ('$name','$Email','$type','$password','$active','$VehicleNumberPlate','$VehicleTypes','$PhoneNumber')";
                                    // echo $qry;

                                    if (!mysqli_query($con, $qry)) {
                                        die('Error: ' . mysqli_error());
                                    }
                                    echo "Registration Successfull";
                                    echo "<script>location.href='index.php';</script>";
                                }
                            }
                            ?>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.php">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="index.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>