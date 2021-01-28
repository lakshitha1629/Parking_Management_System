<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parking Spaces Details</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Parking Spaces Details Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <tbody>
                    <?php
                    require_once('connect.php');
                    $user = $_SESSION['email'];
                    $qry = "SELECT * FROM `parking_slots` INNER JOIN `user_account` ON `parking_slots`.`email`=`user_account`.`email`";

                    echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>   
                            <tr>
                                <th>Space Number</th>
                                <th>Status</th>
                                <th>Vehicle Number</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>NIC</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Space Number</th>
                                <th>Status</th>
                                <th>Vehicle Number</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>NIC</th>
                            </tr>
                        </tfoot>';

                    if ($res = $con->query($qry)) {
                        while ($row = $res->fetch_assoc()) {
                            $field0name = $row["parking_slot"];
                            $field1name = $row["status"];
                            $field2name = $row["number_plate"];
                            $field3name = $row["email"];
                            $field4name = $row["phone"];
                            $field5name = $row["NIC"];

                            echo "<tr> 
                                    <td>" . $field0name . "</td> 
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