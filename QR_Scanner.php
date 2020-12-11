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
                    <h6 class="m-0 font-weight-bold text-primary">QR Code Reader</h6>
                </div>
                <div class="card-body">
                    <!-- <video id="preview"></video> -->
                    <button type="button" class="btn btn-light" onclick="myFunction()"><i class="fa fa-qrcode" aria-hidden="true" style="font-size:145px;color: indigo;"></i></button>

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

                        <tbody>
                            <?php

                            require_once('connect.php');
                            $user = $_SESSION['email'];
                            $qry3 = "SELECT * FROM parking_details JOIN user_account ON parking_details.vehicle_no = user_account.number_plate  WHERE parking_details.vehicle_out IS NULL";

                            echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Vehicle No</th>
                                <th>Vehicle Categorie</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Vehicle Type</th>
                                <th>Phone Number</th>
                                <th>Remark</th>
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
                                <th>Remark</th>
                                <th>Vehicle IN Time</th>
                                <th>Vehicle Out Time</th>
                            </tr>
                        </tfoot>';

                            if ($res = $con->query($qry3)) {
                                while ($row = $res->fetch_assoc()) {
                                    $field1name = $row["vehicle_no"];
                                    $field2name = $row["vehicle_categorie"];
                                    $field3name = $row["remark"];
                                    $field4name = $row["vehicle_in"];
                                    $field5name = $row["vehicle_out"];

                                    $field6name = $row["name"];
                                    $field7name = $row["email"];
                                    $field8name = $row["vehicle_type"];
                                    $field9name = $row["phone"];

                                    echo "<tr> 
                                            <td>" . $field1name . "</td> 
                                            <td>" . $field2name . "</td> 
                                            <td>" . $field6name . "</td> 
                                            <td>" . $field7name . "</td> 
                                            <td>" . $field8name . "</td> 
                                            <td>" . $field9name . "</td> 
                                            <td>" . $field3name . "</td> 
                                            <td>" . $field4name . "</td> 
                                            <td>" . $field5name . "</td>
                                        </tr>";
                                }

                                $res->free();
                            }
                            ?>
                        </tbody>
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

<script>
    function myFunction() {
        var myWindow = window.open("QR.php", "", "width=400,height=600");
    }
</script>