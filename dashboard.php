<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<?php include 'common/top.php'; ?>

<!-- Uploader --->

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
          <input type="number" name="VehicleNo" id="VehicleNo" class="form-control" placeholder="Enter Vehicle No" maxlength="10" required>
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
      // date_default_timezone_set('Asia/Colombo');
      // $date = date('Y-m-d H:i:s');Vendor SiteID Type Band Site wp
      //$date = $_POST['date'];

      // --- Site details --
      $SiteID = strtoupper($_POST['SiteID']);
      $SiteName = ucwords($_POST['SiteName']);

      // --- Invoice details --
      $InvoiceNo = $_POST['InvoiceNo'];
      $InvoiceDate = $_POST['InvoiceDate'];
      $PaymentDate = $_POST['PaymentDate'];
      $Remark = $_POST['Remark'];

      // --- litres details --
      $SupplyDate = $_POST['SupplyDate'];
      $StartingBalance = $_POST['StartingBalance'];
      $LitresPumped = $_POST['LitresPumped'];
      $CurrentMeter = $_POST['CurrentMeter'];
      $Vendor = $_POST['Vendor'];

      //$qry = "SELECT * FROM `total_geny_records` WHERE `siteID` = 'AMAKK1' ORDER BY id DESC LIMIT 1";
      $qry = "SELECT * FROM `total_geny_records` WHERE `siteID` = '" . $SiteID . "' ORDER BY id DESC LIMIT 1";
      $res = $con->query($qry);

      if (mysqli_num_rows($res) == 1) {

        while ($data1 = $res->fetch_assoc()) {
          // --- Pre-Site details --
          $PreSupplyDate = $data1['supplyDate'];
          $PreStartingBalance = $data1['startingBalance'];
          $PreLitresPumped = $data1['noLitresPumped'];
          $PreCurrentMeter = $data1['currentMeter'];
        }

        // --- Calculation --
        $DieselConsumption = ($PreStartingBalance + $PreLitresPumped) - $StartingBalance;
        $RunningHours = $CurrentMeter - $PreCurrentMeter;
        $ConsumptionLitHr = ($DieselConsumption / $RunningHours);
        $AmountforDiesel = $LitresPumped * 95;
        $LabourTransport = $LitresPumped * 31;
        $total = $AmountforDiesel + $LabourTransport;
        // $Runningdays = (round($PreSupplyDate - $SupplyDate) / (60 * 60 * 24));
        $date1 = date_create($PreSupplyDate);
        $date2 = date_create($SupplyDate);
        $diff = date_diff($date1, $date2);
        $Runningdays = $diff->format("%a");
        $NBT = 00;
        $VAT = 00;
        $TPRate = $LabourTransport / $LitresPumped;
        $active = '1';

        $qry1 = "INSERT INTO `total_geny_records`(`siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, `currentMeter`, `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, `amountforDiesel`, `labourTransport`, `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`, `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`,`vendor`,`active`) 
        VALUES ('$SiteID','$SiteName ','$SupplyDate','$StartingBalance','$LitresPumped','$CurrentMeter','$PreSupplyDate','$PreCurrentMeter','$DieselConsumption','$RunningHours','$ConsumptionLitHr','$AmountforDiesel','$LabourTransport','$NBT','$VAT','$total','$TPRate','$Runningdays','$InvoiceNo','$InvoiceDate','$PaymentDate','$Remark','$Vendor','$active')";

        // previousSupplyDate	previousMeter	dieselConsumption	runningHours	
        // consumptionLH	amountforDiesel	labourTransport	NBT	VAT	totalAmount	TPRate
        if (!mysqli_query($con, $qry1)) {
          die('Error: ' . mysqli_error());
        } else {
          echo "Your record added Successfull";
        }
      } else {

        // --- Pre-Site details --
        $PreSupplyDate = '1st Time';
        $PreStartingBalance = '1st Time';
        $PreLitresPumped = '1st Time';
        $PreCurrentMeter = '1st Time';


        // --- Calculation --
        $DieselConsumption = '1st Time';
        $RunningHours = '1st Time';
        $ConsumptionLitHr = '1st Time';
        $AmountforDiesel = $LitresPumped * 95;
        $LabourTransport = $LitresPumped * 31;
        $total = $AmountforDiesel + $LabourTransport;
        $Runningdays = '1st Time';
        $NBT = 00;
        $VAT = 00;
        $TPRate = $LabourTransport / $LitresPumped;
        $active = '1';

        $qry2 = "INSERT INTO `total_geny_records`(`siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, `currentMeter`, `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, `amountforDiesel`, `labourTransport`, `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`, `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`,`vendor`,`active`) 
        VALUES ('$SiteID','$SiteName ','$SupplyDate','$StartingBalance','$LitresPumped','$CurrentMeter','$PreSupplyDate','$PreCurrentMeter','$DieselConsumption','$RunningHours','$ConsumptionLitHr','$AmountforDiesel','$LabourTransport','$NBT','$VAT','$total','$TPRate','$Runningdays','$InvoiceNo','$InvoiceDate','$PaymentDate','$Remark','$Vendor','$active')";

        // previousSupplyDate	previousMeter	dieselConsumption	runningHours	
        // consumptionLH	amountforDiesel	labourTransport	NBT	VAT	totalAmount	TPRate
        if (!mysqli_query($con, $qry2)) {
          die('Error: ' . mysqli_error());
        } else {
          echo "Your record added Successfull";
        }
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
      <table class="table table-bordered" id="genytable" width="100%" cellspacing="0">
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
        </tfoot>
      </table><br>
      <!-- <p style="margin-bottom: 2px;text-align: right;">Delete Record Use &nbsp;&nbsp;<i class='fa fa-window-close' style='font-size:18px;color:red'></i></p> -->
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>


<!--jQuary-->
<script>
  $(document).ready(function() {
    var dataTable = $('#genytable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "select.php",
        type: "post"
      }
    });
  });
</script>

<script>
  $("#SiteID").autocomplete({
    source: function(request, response) {
      $.ajax({
        url: "AutoComplete/SiteID.php",
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
      $('#SiteID').val(ui.item.value);
      $('#SiteName').val(ui.item.label);
      return false;
    }
  });
</script>