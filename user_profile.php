<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Profile</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Profile Details</h6>
        </div>
        <div class="card-body">

            <?php
            require_once('connect.php');
            $user = $_SESSION['email'];
            $usertype = $_SESSION['user_type'];

            $qry = "SELECT * FROM `user_account` WHERE `email`='$user'";

            if ($res = $con->query($qry)) {
                while ($row = $res->fetch_assoc()) {
                    $name = $row["name"];
                    $email = $row["email"];
                    $number_plate = $row["number_plate"];
                    $vehicle_type = $row["vehicle_type"];
                    $phone = $row["phone"];
                    $NIC = $row["NIC"];
                }

                echo '<div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="images/pro.png" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4>' . $usertype . '</h4>
                                <p class="text-secondary mb-1">Mypark-Bot System User</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            ' . $name . '
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            ' . $email . '
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mobile</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            ' . $phone . '
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">NIC</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            ' . $NIC . '
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Number Plate</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            ' . $number_plate . '
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Vehicle Type</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            ' . $vehicle_type . '
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>';
                $res->free();
            }
            ?>




        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>