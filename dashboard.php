<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<?php include 'common/top.php'; ?>


<?php
require_once('connect.php');

function fill_product($con)
{
  $output = '';
  $sql = "SELECT * FROM `parking_slots`";
  $result = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($result)) {
    $field01name = $row["parking_slot"];
    $field02name = $row["status"];

    if ($field02name == "Active") {
      $field03name = "bg-danger";
    } elseif ($field02name == "Reserved") {
      $field03name = "bg-warning";
    } else {
      $field03name = "bg-success";
      // $field03name = "bg-light";
    }

    $output .= '
        <div class="col-lg-2 mb-4">
          <div class="card ' . $field03name . ' text-white shadow">
            <div class="card-body text-center">
            ' . $field01name . '
            </div>
          </div>
        </div>';
  }
  return $output;
}
?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Parking Spaces Design</h6>
  </div>
  <div class="card-body">
    <!-- Color System -->
    <div class="row">
      <?php echo fill_product($con); ?>
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
        <div class="col-md-3 mb-3">
          <a href="QR_Scanner.php"> <i class="fa fa-qrcode" aria-hidden="true" style="font-size:48px;padding-top: 20px;padding-bottom: 0px;padding-left: 50px;color: indigo;"></i>
            <label>Use QR</label> </a>
        </div>
        <div class="col-md-2 mb-3">
          <label>Parking Slot :</label>
          <select name="ParkingSlot" id="ParkingSlot" class="form-control" required>
            <?php
            require_once('connect.php');

            $sql_slot = "SELECT * FROM `parking_slots` WHERE `status`!='Active' AND `status`!='Reserved'";
            $result_slot = mysqli_query($con, $sql_slot);
            while ($row_slot = mysqli_fetch_array($result_slot)) {
              $parking_slot = $row_slot["parking_slot"];

              echo "<option value='" . $parking_slot . "'>" . $parking_slot . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label>Vehicle No :</label>
          <input type="text" name="VehicleNo" id="VehicleNo" class="form-control" placeholder="Enter Vehicle No" maxlength="11" required>
        </div>
        <div class="col-md-3 mb-3">
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

      $user = $_SESSION['email'];
      date_default_timezone_set('Asia/Colombo');
      $date = date('Y-m-d H:i:s');

      $VehicleNo = $_POST['VehicleNo'];
      $VehicleCategories = $_POST['VehicleCategories'];
      $ParkingSlot = $_POST['ParkingSlot'];
      $Remark = $_POST['Remark'] . "Add Value " . $user;
      $vehicle_in = $date;
      $vehicle_out = $date;


      $status = 'Active';

      $check = mysqli_query($con, "SELECT * FROM `parking_details` WHERE `vehicle_no`='$VehicleNo' AND `vehicle_out` IS NULL");
      $checkrows = mysqli_num_rows($check);

      if ($checkrows > 0) {
        echo "<div style='color: red;'>*Your record already Added.</div>";
      } else {

        $qry1 = "INSERT INTO `parking_details`(`vehicle_no`, `vehicle_categorie`, `remark`, `parking_slot`, `vehicle_in`) VALUES ('$VehicleNo','$VehicleCategories','$Remark','$ParkingSlot','$vehicle_in')";
        $qry2 = "UPDATE `parking_slots` SET `status`='$status',`email`='$user' WHERE `parking_slot`='$ParkingSlot'";


        mysqli_query($con, $qry1);


        $result = mysqli_query($con, $qry2)
          or die('Error: ' . mysqli_error($con));
        echo "Your record Added Successfully";
        echo "<script>location.href='dashboard.php';</script>";
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
      $user = $_SESSION['email'];
      $qry3 = "SELECT * FROM parking_details WHERE `vehicle_out` IS NULL AND `remark`!='Automate QR BOT'";

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
          $ParkingSlot = $row["parking_slot"];
          $field1name = $row["vehicle_no"];
          $field2name = $row["vehicle_categorie"];
          $field3name = $row["remark"];
          $field4name = $row["vehicle_in"];
          $intime = strtotime($field4name);

          echo "<tr> 
                  <td>" . $field1name . "</td> 
                  <td>" . $field2name . "</td> 
                  <td>" . $field3name . "</td> 
                  <td>" . $field4name . "</td> 
                  <td><button onclick='exitfunction(" .  $id . " ," .  $ParkingSlot . "," .  $intime . ")' type='button' class='btn btn-secondary btn-xs'>Vehicle Exit</button>
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

<script type="text/javascript">
  function exitfunction(p1, p2, p3) {
    $.confirm({
      title: 'Confirm!',
      content: 'Are you sure you want to exit vehicle?',
      buttons: {
        confirm: function() {
          $.ajax({
            url: "vehicle_out.php",
            type: 'post',
            dataType: "json",
            data: {
              id: p1,
              ParkingSlot: p2,
              VehicleIn: p3
            },
            success: function(data) {
              $.confirm({
                title: 'Success!',
                content: data,
                type: 'green',
                typeAnimated: true,
                autoClose: 'tryAgain|15000',
                buttons: {
                  tryAgain: {
                    text: 'OK',
                    btnClass: 'btn-green',
                    action: function() {
                      window.location.href = "dashboard.php";
                    }
                  }
                }
              });
            },
            error: function(data) {
              $.confirm({
                title: 'Encountered an error!',
                content: data,
                type: 'red',
                typeAnimated: true,
                autoClose: 'tryAgain|10000',
                buttons: {
                  tryAgain: {
                    text: 'Try again',
                    btnClass: 'btn-red',
                    action: function() {}
                  },
                  close: function() {}
                }
              });
            }
          });
        },
        cancel: function() {
          window.location.href = "dashboard.php";
        }
      }
    });
  }
</script>

<script>
  $("#VehicleNo").autocomplete({
    source: function(request, response) {
      $.ajax({
        url: "AutoComplete/VehicleNo.php",
        type: 'post',
        dataType: "json",
        data: {
          search: request.term
        },
        success: function(data) {
          response(data);
        }
      });
    },
    select: function(event, ui) {
      $('#VehicleNo').val(ui.item.value);
      return false;
    }
  });
</script>