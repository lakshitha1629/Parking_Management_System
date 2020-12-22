<!DOCTYPE html>
<html lang="en">

<head>
    <title>Parking Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="apple-touch-icon" href="/images/icons/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#4285f4">
    <script src="https://kit.fontawesome.com/f55ff8b89d.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
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
                            <form class="user" method="post" action="">
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

                                date_default_timezone_set('Asia/Colombo');
                                $date = date('Y-m-d H:i:s');

                                //$date = $_POST['date'];
                                $user_id = uniqid();
                                $name = $_POST['FirstName'] . ' ' . $_POST['LastName'];
                                $VehicleNumberPlate = $_POST['VehicleNumberPlate'];
                                $VehicleTypes = $_POST['VehicleTypes'];
                                $PhoneNumber = $_POST['PhoneNumber'];
                                $Email = $_POST['Email'];
                                $password1 = $_POST['Password'];
                                $password2 = $_POST['RepeatPassword'];
                                $type = '2';
                                $active = '1';

                                // QR Code
                                include './phpqrcode/qrlib.php';
                                $path = 'images/QR/';
                                $QR_Code = $path . $user_id . ".png";
                                $ecc = 'L';
                                $pixel_Size = 10;
                                $frame_Size = 10;

                                // Generates QR Code and Stores it in directory given 
                                QRcode::png($user_id, $QR_Code, $ecc, $pixel_Size);

                                if ($password1 != $password2) {
                                    echo "The two passwords do not match";
                                } else {
                                    $password = md5($password1);
                                    $qry = "INSERT INTO `user_account`(`user_id`,`name`, `email`, `user_type`, `password`, `activated`, `number_plate`, `vehicle_type`, `phone`) VALUES ('$user_id','$name','$Email','$type','$password','$active','$VehicleNumberPlate','$VehicleTypes','$PhoneNumber')";
                                    $qry1 = "INSERT INTO `smart_wallet`(`date`, `email`, `price`) VALUES ('$date', '$Email', '1000')";

                                    mysqli_query($con, $qry1);
                                    $result = mysqli_query($con, $qry)
                                        or die('Error: ' . mysqli_error($con));

                                    // echo "Registration Successfull";
                                    echo "<script type='text/javascript'>";
                                    echo "alert('Registration Successfull');";
                                    echo 'window.location.href = "index.php";';
                                    echo "</script>";
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script src="AutoComplete/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="AutoComplete/jquery-ui.css">

    <!-- QR -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</body>

</html>