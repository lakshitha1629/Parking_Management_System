<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>
  <hr>
  <div class="row">
    <div class="col-lg-4 mb-4">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">QR Code Reader</h6>
        </div>
        <div class="card-body">
          <?php
          require_once('connect.php');
          $user = $_SESSION['email'];
          $qry0 = "SELECT * FROM `user_account` WHERE `email`='$user'";

          if ($res = $con->query($qry0)) {
            while ($row = $res->fetch_assoc()) {
              $user_id = $row["user_id"];
              $path = 'images/QR/';
              $file = $path . $user_id . ".png";
            }

            echo "<div class='text-center'><img src='" . $file . "' class='rounded' style='width: 200px;'></div>";
            $res->free();
          }
          ?>
        </div>
      </div>
    </div>

    <div class="col-lg-8 mb-4">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Parking Spaces Design</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-2 mb-4">
              <div class="card bg-light text-black shadow">
                <div class="card-body text-center">
                  1
                </div>
              </div>
            </div>
            <div class="col-lg-2 mb-4">
              <div class="card bg-light text-black shadow">
                <div class="card-body text-center">
                  2
                </div>
              </div>
            </div>
            <div class="col-lg-2 mb-4">
              <div class="card bg-success text-white shadow">
                <div class="card-body text-center">
                  3
                </div>
              </div>
            </div>
            <div class="col-lg-2 mb-4">
              <div class="card bg-danger text-white shadow">
                <div class="card-body text-center">
                  4
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- form --->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Booking Parking Space Form</h6>
    </div>
    <div class="card-body">
      <form method="post" action="">
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label>Space No :</label>
            <input type="text" name="SpaceNo" id="SpaceNo" class="form-control" placeholder="Enter Space No" maxlength="11" required>
          </div>
          <div class="col-md-4 mb-3">
            <label>Vehicle Entering Time (Expected) :</label>
            <input type="time" name="datetime" id="datetime" class="form-control">
          </div>
          <div class="col-md-4 mb-3">
            <label>Conditions - </label><br>
            <label style="color: red;">*Please booking before 1 hours</label>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12 mb-3">
            <label>Remark :</label>
            <input type="text" name="Remark" id="Remark" class="form-control" placeholder="Enter Remark">
          </div>
        </div>
        <input class="btn btn-success" type=submit value="ADD" name="submit1">
      </form>
      <?php

      if (isset($_POST['submit1'])) {
        require_once('connect.php');

        $user = $_SESSION['email'];
        $SpaceNo = $_POST['SpaceNo'];
        $datetime = $_POST['datetime'];
        $Remark = $_POST['Remark'];
        $status = 'active';

        // time range
        date_default_timezone_set('Asia/Colombo');
        $time = date('H:i:s');

        $nowtime = strtotime($time);

        $end = strtotime($_POST['datetime'] . ':00');
        $start = $end - (2 * 60 * 60);

        if ($nowtime >= $start && $nowtime <= $end) {
          $qry1 = "INSERT INTO `booking_parking`(`space_no`, `vehicle_entering`, `status`, `remark`, `email`) VALUES ('$SpaceNo','$datetime','$status','$Remark','$user')";
          if (!mysqli_query($con, $qry1)) {
            die('Error: ' . mysqli_error($con));
          }
          echo "Your record Added Successfully";
        } else {
          echo "Please go through the conditions";
        }
      }
      ?>

    </div>
  </div>

  <!-- DataTables  -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Parking Spaces Requests Table</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
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
              </thead>';              

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
        ?></table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>