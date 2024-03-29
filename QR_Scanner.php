<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">QR Scanner</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-2 col-md-6 mb-4">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Entrance / Exit</h6>
                </div>
                <div class="card-body">
                    <!-- <video id="preview"></video> -->
                    <button type="button" class="btn btn-light" onclick="myFunction()"><i class="fa fa-qrcode" aria-hidden="true" style="font-size:145px;color: indigo;"></i></button>

                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Parking Space </h6>
                </div>
                <div class="card-body">
                    <!-- <video id="preview"></video> -->
                    <button type="button" class="btn btn-light" onclick="myFunction2()"><i class="fa fa-qrcode" aria-hidden="true" style="font-size:145px;color: darkorange;"></i></button>

                </div>
            </div>
        </div>
        <div class="col-xl-10 col-md-6 mb-4">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Scan log</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <?php

                            require_once('connect.php');
                            $user = $_SESSION['email'];
                            $qry3 = "SELECT * FROM parking_details JOIN user_account ON parking_details.vehicle_no = user_account.number_plate  WHERE parking_details.vehicle_out IS NULL";

                            echo '<thead>
                                            <tr>
                                                <th>Vehicle No</th>
                                                <th>Vehicle Categorie</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Vehicle Type</th>
                                                <th>Phone Number</th>
                                                <th>Vehicle IN Time</th>
                                                <th>Vehicle Out Time</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Vehicle No</th>
                                                <th>Vehicle Categorie</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Vehicle Type</th>
                                                <th>Phone Number</th>
                                                <th>Vehicle IN Time</th>
                                                <th>Vehicle Out Time</th>
                                            </tr>
                                        </tfoot>';

                            if ($res = $con->query($qry3)) {
                                while ($row = $res->fetch_assoc()) {
                                    $field1name = $row["vehicle_no"];
                                    $field2name = $row["vehicle_categorie"];
                                    $field3name = $row["name"];
                                    $field4name = $row["email"];
                                    $field5name = $row["vehicle_type"];

                                    $field6name = $row["phone"];
                                    $field7name = $row["vehicle_in"];
                                    $field8name = $row["vehicle_out"];

                                    echo "<tr> 
                                            <td>" . $field1name . "</td> 
                                            <td>" . $field2name . "</td> 
                                            <td>" . $field3name . "</td> 
                                            <td>" . $field4name . "</td> 
                                            <td>" . $field5name . "</td> 
                                            <td>" . $field6name . "</td> 
                                            <td>" . $field7name . "</td> 
                                            <td>" . $field8name . "</td> 
                                        </tr>";
                                }

                                $res->free();
                            }
                            ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>


<!--jQuary-->
<script>
    window.setTimeout(function() {
        location.reload();
    }, 4000);
</script>

<script>
    function myFunction() {
        var myWindow = window.open("QR.php", "", "width=450,height=550");
    }

    function myFunction2() {
        var myWindow = window.open("QR_sp.php", "", "width=450,height=550");
    }
</script>