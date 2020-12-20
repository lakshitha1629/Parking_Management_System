<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Payment Details Log</h1>
    </div>
    <hr>
    <!-- Content Row -->
    <div class="row">

        <!-- 1 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Available Balance</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                                // date_default_timezone_set('Asia/Colombo');
                                                                                // $time = date('Y-m-d');
                                                                                // echo $time;
                                                                                ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2 -->

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Last Payment</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                                // require_once('connect.php');
                                                                                // $date3 = date('Y-m-d');
                                                                                // $qry = "SELECT COUNT(`request`) as d FROM `total_geny_records` WHERE `request`='Pending..'";

                                                                                // $res = $con->query($qry);
                                                                                // while ($data1 = $res->fetch_assoc()) {
                                                                                //   echo $data1['d'];
                                                                                // }
                                                                                ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-battery-quarter fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Payment Details Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <tbody>
                    <?php

                    require_once('connect.php');
                    $user = $_SESSION['email'];
                    $qry3 = "SELECT * FROM `smart_wallet`";

                    echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Email</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>User ID</th>
                                <th>Email</th>
                                <th>Price</th>
                            </tr>
                        </tfoot>';

                    if ($res = $con->query($qry3)) {
                        while ($row = $res->fetch_assoc()) {
                            $field1name = $row["user_id"];
                            $field2name = $row["email"];
                            $field3name = $row["price"];

                            echo "<tr> 
                                            <td>" . $field1name . "</td> 
                                            <td>" . $field2name . "</td>
                                            <td>" . $field3name . "</td> 
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