<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parking Spaces Requests</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Parking Spaces Requests Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <tbody>
                    <?php
                    require_once('connect.php');
                    $user = $_SESSION['email'];
                    $qry = "SELECT * FROM `booking_parking` WHERE `email`='$user'";

                    echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>   
                            <tr>
                                <th>Space Number</th>
                                <th>Vehicle Entering Time</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Space Number</th>
                                <th>Vehicle Entering Time</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Email</th>
                            </tr>
                        </tfoot>';

                    if ($res = $con->query($qry)) {
                        while ($row = $res->fetch_assoc()) {
                            $field1name = $row["space_no"];
                            $field2name = $row["vehicle_entering"];
                            $field3name = $row["status"];
                            $field4name = $row["remark"];
                            $field5name = $row["email"];

                            echo "<tr> 
                                    <td>" . $field1name . "</td> 
                                    <td>" . $field2name . "</td> 
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