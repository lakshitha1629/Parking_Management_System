<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<?php include 'common/top.php'; ?>


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Parking Spaces Design</h6>
  </div>
  <div class="card-body">
    <!-- Color System -->
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
      <div class="col-lg-2 mb-4">
        <div class="card bg-light text-black shadow">
          <div class="card-body text-center">
            5
          </div>
        </div>
      </div>
      <div class="col-lg-2 mb-4">
        <div class="card bg-light text-black shadow">
          <div class="card-body text-center">
            6
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- form --->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Single Parking Spaces Details Form</h6>
  </div>
  <div class="card-body">
    <form method="post" action="">
      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Vehicle No :</label>
          <input type="text" name="VehicleNo" id="VehicleNo" class="form-control" placeholder="Enter Vehicle No" maxlength="11" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Vehicle Categorie :</label>
          <select name="VehicleCategories" id="VehicleCategories" class="form-control" required>
            <option value="Customer_Vehicle">Customer Vehicle</option>
            <option value="Office_Vehicle">Office Vehicle</option>
            <option value="Executive_Vehicle">Executive Vehicle</option>
          </select>
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

      date_default_timezone_set('Asia/Colombo');
      $date = date('Y-m-d H:i:s');

      $VehicleNo = $_POST['VehicleNo'];
      $VehicleCategories = $_POST['VehicleCategories'];
      $Remark = $_POST['Remark'];
      $vehicle_in = $date;
      $vehicle_out = $date;

      $check = mysqli_query($con, "SELECT * FROM `parking_details` WHERE `vehicle_no`='$VehicleNo' AND `vehicle_out` IS NULL");
      $checkrows = mysqli_num_rows($check);

      if ($checkrows > 0) {
        echo "<div style='color: red;'>*Your record already Added.</div>";
      } else {
        $qry1 = "INSERT INTO `parking_details`(`vehicle_no`, `vehicle_categorie`, `remark`, `vehicle_in`) VALUES ('$VehicleNo','$VehicleCategories ','$Remark','$vehicle_in')";
        if (!mysqli_query($con, $qry1)) {
          die('Error: ' . mysqli_error());
        }
        echo "Your record Added Successfully";
      }
    }

    ?>

  </div>
</div>


<!-- DataTables  -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Parking Details Table</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <?php

      require_once('connect.php');
      $user = $_SESSION['user_name'];
      $qry3 = "SELECT * FROM parking_details WHERE `vehicle_out` IS NULL";

      echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
              <th>Vehicle No</th>
              <th>Vehicle Categorie</th>
              <th>Remark</th>
              <th>Vehicle IN Time</th>
              <th>Vehicle EXIT</th>
            </tr>

            </thead>
            <tfoot>
            <tr>
              <th>Vehicle No</th>
              <th>Vehicle Categorie</th>
              <th>Remark</th>
              <th>Vehicle IN Time</th>
              <th>Vehicle EXIT</th>
            </tr>
            </tfoot>';

      if ($res = $con->query($qry3)) {
        while ($row = $res->fetch_assoc()) {
          $id = $row["p_no"];
          $field1name = $row["vehicle_no"];
          $field2name = $row["vehicle_categorie"];
          $field3name = $row["remark"];
          $field4name = $row["vehicle_in"];

          echo "<tr> 
                  <td>" . $field1name . "</td> 
                  <td>" . $field2name . "</td> 
                  <td>" . $field3name . "</td> 
                  <td>" . $field4name . "</td> 
                  <td><a onClick=\"return confirm('Are you sure " . $row['vehicle_no'] . " Vehicle Exit?')\" href=\"vehicle_out.php?id=" . $row['p_no'] . "\"><button type='button' class='btn btn-secondary btn-xs'>Vehicle Exit</button></a>
                  </td>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>