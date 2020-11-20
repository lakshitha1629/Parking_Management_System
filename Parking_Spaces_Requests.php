<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parking Spaces Requests</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- DataTables  -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Parking Spaces Requests Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php

                    require_once('connect.php');
                    $user = $_SESSION['user_name'];
                    $qry = "SELECT * FROM total_geny_records WHERE `request`='Pending..'";

                    echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>   
                        <tr>
                        <th>Vendor</th>
                        <th>Site ID</th>
                        <th>Site Name</th>
                        <th>Supply Date</th>
                        <th>Starting Balance/ Lit.</th>
                        <th>No.of Litres Pumped</th>
                        <th>Current Meter Reading</th>
                        <th>Previous Supply Date</th>
                        <th></th>
                        </tr>
                        </thead>';

                    if ($res = $con->query($qry)) {
                        while ($row = $res->fetch_assoc()) {
                            $id = $row["id"];
                            $field1name = $row["siteID"];
                            $field2name = $row["siteName"];
                            $field3name = $row["supplyDate"];
                            $field4name = $row["startingBalance"];
                            $field5name = $row["noLitresPumped"];
                            $field6name = $row["currentMeter"];
                            $field7name = $row["previousSupplyDate"];
                            $field8name = $row["previousMeter"];

                            echo "<tr> 
                  <td>" . $field1name . "</td> 
                  <td>" . $field2name . "</td> 
                  <td>" . $field3name . "</td> 
                  <td>" . $field4name . "</td> 
                  <td>" . $field5name . "</td>
                  <td>" . $field6name . "</td>
                  <td>" . $field7name . "</td>
                  <td>" . $field8name . "</td>
                  <td><a onClick=\"return confirm('Are you sure you want to Approve Requestor?')\" href=\"approve_Requestor.php?id=" . $row['id'] . "\" class='btn'><i class='fas fa-mail-bulk' style='font-size:20px;color:blue'></i></a>
                  <a onClick=\"return confirm('Are you sure you want to delete?')\" href=\"delete_Requestor.php?id=" . $row['id'] . "\" class='btn'><i class='fa fa-window-close' style='font-size:20px;color:red'></i></a>
                  </td>
              </tr>";
                        }

                        $res->free();
                    }
                    ?></table>
                    <br>
                    <p style='margin-bottom: 2px;text-align: right;'>Request Approval Use &nbsp;&nbsp; <i class='fas fa-mail-bulk' style='font-size:18px;color:blue'></i>
                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;Delete Request Use &nbsp;&nbsp;<i class='fa fa-window-close' style='font-size:18px;color:red'></i></p>

                </div>
            </div>
        </div>




    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>