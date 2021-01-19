<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mypark-Bot</title>
    <script src="https://kit.fontawesome.com/f55ff8b89d.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="Email" placeholder="Email Address" required>
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" name="fro_btn" type="submit" value="Reset Password" />

                                    </form><br>

                                    <?php
                                    require_once('connect.php');

                                    use PHPMailer\PHPMailer\PHPMailer;
                                    use PHPMailer\PHPMailer\SMTP;
                                    use PHPMailer\PHPMailer\Exception;

                                    require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
                                    require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
                                    require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

                                    if (isset($_POST['fro_btn'])) {

                                        $RandomNumber = rand(100, 100000);
                                        $Email = $_POST['Email'];


                                        $query = "SELECT * FROM `user_account` WHERE `email`='$Email'";
                                        $res = $con->query($query);

                                        if (mysqli_num_rows($res) == 1) {
                                            $password = md5($RandomNumber);

                                            $qry = "UPDATE `user_account` SET `password`='$password' WHERE `email`='$Email'";

                                            $result = mysqli_query($con, $qry)
                                                or die('Error: ' . mysqli_error($con));

                                            echo "<br><div class='form'>
                                            Your password has been reset successfully. Please Check your email and Click here to <a href='index.php'>Login</a>
                                            </div>";


                                            //============================ Mail Fun ========================
                                            $mail = new PHPMailer(true);

                                            try {
                                                $mail->isSMTP();
                                                $mail->Host = 'smtp.gmail.com';
                                                $mail->SMTPAuth = true;
                                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                                $mail->Port = 587;

                                                $mail->Username = 'myparkbotpms@gmail.com'; // YOUR gmail email
                                                $mail->Password = 'botbotbot35'; // YOUR gmail password

                                                // Sender and recipient settings
                                                $mail->setFrom('myparkbotpms@gmail.com', 'MyPark-Bot');
                                                $mail->addAddress($Email, '');
                                                $mail->addReplyTo('myparkbotpms@gmail.com', 'MyPark-Bot'); // to set the reply to

                                                // Setting the email content
                                                $mail->IsHTML(true);
                                                $mail->Subject = "MyPark-Bot - Password Reset";
                                                $mail->Body = '<b>' . $RandomNumber . '</b> Your New Password!!';
                                                $mail->AltBody = 'MyPark-Bot';

                                                $mail->send();
                                                // echo "Email message sent.";

                                            } catch (Exception $e) {
                                                // echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
                                            }
                                        } else {
                                            echo "<br><div class='form'>
                                            The email address provided is not registered. Please Click here to <a href='customer_register.php'>Create an Account!</a>
                                            </div>";
                                        }
                                    }
                                    ?>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="customer_register.php">Create an Account!</a>
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

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>