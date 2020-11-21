<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<?php include 'common/top.php'; ?>

<!-- Uploader --->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Multi-Geny Fuel Details Uploader</h6>
  </div>
  <div class="card-body">
    <form method="post" action="" enctype="multipart/form-data">

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Upload your Multi-Geny Fuel Excel File :</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" name="excelfile" id="excelfile" class="">
            </div>
          </div>
          <br>
          <div class="form-group">
            <button class="btn btn-success">Upload</button>
          </div>


    </form>
    <?php

    use Box\Spout\Reader\ReaderFactory;
    use Box\Spout\Common\Type;

    require_once('connect.php');
    require_once('Spout/Autoloader/autoload.php');

    if (!empty($_FILES['excelfile']['name'])) {

      $pathinfo = pathinfo($_FILES['excelfile']['name']);

      if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
        && $_FILES['excelfile']['size'] > 0
      ) {
        $file = $_FILES['excelfile']['tmp_name'];

        $reader = ReaderFactory::create(Type::XLSX);

        $reader->open($file);
        $count = 0;

        foreach ($reader->getSheetIterator() as $sheet) {

          foreach ($sheet->getRowIterator() as $row) {

            if ($count > 0) {
              date_default_timezone_set('Asia/Colombo');

              // --- Site details --
              $SiteID = strtoupper($row[0]);
              $SiteName = ucwords($row[1]);

              // --- Invoice details --
              $InvoiceNo = $row[6];
              $InvoiceDate = $row[7]->format('Y-m-d');
              $PaymentDate = $row[8]->format('Y-m-d');
              $Remark = $row[9];

              // --- litres details --
              $SupplyDate = $row[2]->format('Y-m-d');
              $StartingBalance = $row[3];
              $LitresPumped = $row[4];
              $CurrentMeter = $row[5];

              //$qry = "SELECT * FROM `total_geny_records` WHERE `siteID` = 'AMAKK1' ORDER BY id DESC LIMIT 1";
              $qry1 = "SELECT * FROM `total_geny_records` WHERE `siteID` = '" . $SiteID . "' ORDER BY id DESC LIMIT 1";
              $res1 = $con->query($qry1);

              if (mysqli_num_rows($res1) == 1) {

                while ($data1 = $res1->fetch_assoc()) {
                  // --- Pre-Site details --
                  $PreSupplyDate = $data1['supplyDate'];
                  $PreStartingBalance = $data1['startingBalance'];
                  $PreLitresPumped = $data1['noLitresPumped'];
                  $PreCurrentMeter = $data1['currentMeter'];
                }

                // --- Calculation --
                $DieselConsumption = ($PreStartingBalance + $PreLitresPumped) - $StartingBalance;
                $RunningHours = $CurrentMeter - $PreCurrentMeter;
                $ConsumptionLitHr = (round($DieselConsumption / $RunningHours));
                $AmountforDiesel = $LitresPumped * 95;
                $LabourTransport = $LitresPumped * 31;
                $total = $AmountforDiesel + $LabourTransport;
                //$Runningdays = (round($SupplyDate - $PreSupplyDate) / (60 * 60 * 24));
                $date1 = date_create($PreSupplyDate);
                $date2 = date_create($SupplyDate);
                $diff = date_diff($date1, $date2);
                $Runningdays = $diff->format("%a");

                $NBT = 00;
                $VAT = 00;
                $TPRate = $LabourTransport / $LitresPumped;

                $qry = "INSERT INTO `total_geny_records`(`siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, `currentMeter`, `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, `amountforDiesel`, `labourTransport`, `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`, `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`) 
        VALUES ('$SiteID','$SiteName','$SupplyDate','$StartingBalance','$LitresPumped','$CurrentMeter','$PreSupplyDate','$PreCurrentMeter','$DieselConsumption','$RunningHours','$ConsumptionLitHr','$AmountforDiesel','$LabourTransport','$NBT','$VAT','$total','$TPRate','$Runningdays','$InvoiceNo','$InvoiceDate','$PaymentDate','$Remark')";
                echo $qry;
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


                $qry = "INSERT INTO `total_geny_records`(`siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, `currentMeter`, `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, `amountforDiesel`, `labourTransport`, `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`, `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`) VALUES ('$SiteID','$SiteName ','$SupplyDate','$StartingBalance','$LitresPumped','$CurrentMeter','$PreSupplyDate','$PreCurrentMeter','$DieselConsumption','$RunningHours','$ConsumptionLitHr','$AmountforDiesel','$LabourTransport','$NBT','$VAT','$total','$TPRate','$Runningdays','$InvoiceNo','$InvoiceDate','$PaymentDate','$Remark')";
              }

              $res = mysqli_query($con, $qry);
            }
            $count++;
          }
        }

        if ($res) {
          echo "Your file Uploaded Successfull";
        } else {
          echo "Your file Uploaded Failed";
        }

        $reader->close();
      } else {
        echo "Please Choose only Excel file";
      }
    } else {
      //echo "test";
    }

    ?>


  </div>
  <!-- <div class="col-xl-1 col-sm-6 mb-3">

  </div> -->
  <div class="col-xl-4 col-sm-6 mb-3">
    Use this table format:- <form><input type="button" value="Download Template" onClick="window.location.href='AutoComplete/downloads/Template.xlsx'" class="btn btn-info"></form>
    <hr>
    <table class="table table-bordered" width="80%" cellspacing="0">
      <thead style="background-color: aliceblue;">
        <tr style="font-size: smaller;">
          <th>Site ID</th>
          <th>Site Name</th>
          <th>Supply Date</th>
          <th>Starting Balance/ Lit.</th>
          <th>No.of Litres Pumped</th>
          <th>Current Meter Reading</th>
          <th>Invoice No</th>
          <th>Invoice Date</th>
          <th>Payment Date</th>
          <th>Remark</th>
          <th>Vendor</th>
        </tr>
      </thead>

      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
    <!-- <p style="margin-bottom: 2px;">Please give Request Type <b>Block</b> or <b>Deblock</b>
      <div style="color: red;">*(As in the <b>Bold</b> format)</div>
    </p> -->

  </div>
  <div class="col-xl-3 col-sm-6 mb-3">

  </div>
</div>
</div>
</div>

<!-- form --->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Single Geny Fuel Details Form</h6>
  </div>
  <div class="card-body">
    <form method="post" action="">

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Site ID :</label>
          <input type="text" name="SiteID" id="SiteID" class="form-control" placeholder="Enter Site ID" maxlength="50" style="text-transform: uppercase;" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Site Name :</label>
          <input type="text" name="SiteName" id="SiteName" class="form-control" placeholder="Enter Site Name" maxlength="30" style="text-transform: initial;" readonly>
        </div>
      </div>
      <hr>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Invoice No :</label>
          <input type="number" name="InvoiceNo" id="InvoiceNo" class="form-control" placeholder="Enter Invoice No" maxlength="50" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Invoice Date :</label>
          <input type="date" name="InvoiceDate" id="InvoiceDate" class="form-control" placeholder="Enter Invoice Date" maxlength="60" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Payment Date :</label>
          <input type="date" name="PaymentDate" id="PaymentDate" class="form-control" placeholder="Enter Payment Date" required>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-12 mb-3">
          <label>Remark :</label>
          <input type="text" name="Remark" id="Remark" class="form-control" placeholder="Enter Remark">
        </div>
      </div>
      <hr>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Supply Date :</label>
          <input type="date" name="SupplyDate" class="form-control" placeholder="Enter Supply Date" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Starting Balance/ Lit. :</label>
          <input type="number" name="StartingBalance" id="StartingBalance" class="form-control" placeholder="Enter Starting Balance" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>No.of Litres Pumped :</label>
          <input type="number" name="LitresPumped" class="form-control" placeholder="Enter Integer Value" maxlength="40" required>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Current Meter Reading :</label>
          <input type="number" name="CurrentMeter" id="CurrentMeter" class="form-control" placeholder="Enter Integer Value" maxlength="40" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Vendor Name :</label>
          <input type="text" name="Vendor" id="Vendor" class="form-control" placeholder="<?php echo $_SESSION['user_name']; ?>" maxlength="80" readonly>
        </div>
      </div>

      <!-- <div class="form-row">
        <div class="col-md-12 mb-3">
          <label>Current Meter Reading :</label>
          <input type="int" name="CurrentMeter" id="CurrentMeter" class="form-control" placeholder="Enter Current Meter Reading" maxlength="40" required>
        </div>
      </div> -->
      <input class="btn btn-success" type=submit value="ADD" name="submit1">

    </form>
    <?php

    if (isset($_POST['submit1'])) {
      require_once('connect.php');
      // date_default_timezone_set('Asia/Colombo');
      // $date = date('Y-m-d H:i:s');Vendor SiteID Type Band Site wp
      //$date = $_POST['date'];

      // --- Site details --
      $Request = 'Pending..';
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
      $Vendor = $_SESSION['email'];

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

        $active = '0';

        $qry1 = "INSERT INTO `total_geny_records`(`request`,`siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, `currentMeter`, `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, `amountforDiesel`, `labourTransport`, `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`, `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`,`vendor`,`active`) 
        VALUES ('$Request','$SiteID','$SiteName ','$SupplyDate','$StartingBalance','$LitresPumped','$CurrentMeter','$PreSupplyDate','$PreCurrentMeter','$DieselConsumption','$RunningHours','$ConsumptionLitHr','$AmountforDiesel','$LabourTransport','$NBT','$VAT','$total','$TPRate','$Runningdays','$InvoiceNo','$InvoiceDate','$PaymentDate','$Remark','$Vendor','$active')";

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

        $active = '0';
        $qry2 = "INSERT INTO `total_geny_records`(`request`,`siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, `currentMeter`, `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, `amountforDiesel`, `labourTransport`, `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`, `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`,`vendor`,`active`) 
        VALUES ('$Request','$SiteID','$SiteName ','$SupplyDate','$StartingBalance','$LitresPumped','$CurrentMeter','$PreSupplyDate','$PreCurrentMeter','$DieselConsumption','$RunningHours','$ConsumptionLitHr','$AmountforDiesel','$LabourTransport','$NBT','$VAT','$total','$TPRate','$Runningdays','$InvoiceNo','$InvoiceDate','$PaymentDate','$Remark','$Vendor','$active')";

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
    <h6 class="m-0 font-weight-bold text-primary">Geny Fuel Details Tables</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="genytable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Request</th>
            <th>Site ID</th>
            <th>Site Name</th>
            <th>Supply Date</th>
            <th>Starting Balance/ Lit.</th>
            <th>No.of Litres Pumped</th>
            <th>Current Meter Reading</th>
            <th>Previous Supply Date</th>
            <th>Previous Meter Reading</th>
            <th>Diesel Consumption</th>
            <th>Running Hours</th>
            <th>Consumption Lit/Hr</th>
            <th>Amount for Diesel</th>
            <th>Labour + Transport</th>
            <th>Total Amount</th>
            <!-- <th></th> -->
          </tr>

        </thead>
        <tfoot>
          <tr>
            <th>Request</th>
            <th>Site ID</th>
            <th>Site Name</th>
            <th>Supply Date</th>
            <th>Starting Balance/ Lit.</th>
            <th>No.of Litres Pumped</th>
            <th>Current Meter Reading</th>
            <th>Previous Supply Date</th>
            <th>Previous Meter Reading</th>
            <th>Diesel Consumption</th>
            <th>Running Hours</th>
            <th>Consumption Lit/Hr</th>
            <th>Amount for Diesel</th>
            <th>Labour + Transport</th>
            <th>Total Amount</th>
            <!-- <th></th> -->
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
        url: "select_Vendor.php",
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