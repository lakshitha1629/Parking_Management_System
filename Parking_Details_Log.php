<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parking Details Log (Registered Users)</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Parking Details Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <tbody>
                    <?php

                    require_once('connect.php');
                    $user = $_SESSION['email'];
                    $qry3 = "SELECT * FROM parking_details JOIN user_account ON parking_details.vehicle_no = user_account.number_plate";

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
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>