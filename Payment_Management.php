<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Payment Details Log</h1>
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
                                <th>Date and Time</th>
                                <th>Email</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date and Time</th>
                                <th>Email</th>
                                <th>Price</th>
                            </tr>
                        </tfoot>';

                    if ($res = $con->query($qry3)) {
                        while ($row = $res->fetch_assoc()) {
                            $field1name = $row["date"];
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