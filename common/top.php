<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
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
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Date</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                  date_default_timezone_set('Asia/Colombo');
                                                                  $time = date('Y-m-d');
                                                                  echo $time;
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
      <a style="text-decoration:none" href="Vendor_Requests.php">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Parking Spaces Request Count</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                    require_once('connect.php');
                                                                    $date3 = date('Y-m-d');
                                                                    $qry = "SELECT COUNT(`request`) as d FROM `total_geny_records` WHERE `request`='Pending..'";

                                                                    $res = $con->query($qry);
                                                                    while ($data1 = $res->fetch_assoc()) {
                                                                      echo $data1['d'];
                                                                    } ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-battery-quarter fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- 3 -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a style="text-decoration:none" href="Vendor_Requests.php">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Available Parking Spaces Count</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                    require_once('connect.php');
                                                                    $date3 = date('Y-m-d');
                                                                    $qry = "SELECT COUNT(`site_id`) as c FROM `standby_geny_list`";

                                                                    $res = $con->query($qry);
                                                                    while ($data1 = $res->fetch_assoc()) {
                                                                      echo $data1['c'];
                                                                    } ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-battery-full fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>


    <!-- 4 -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Last Month Income</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                  require_once('connect.php');
                                                                  $date3 = date('Y-m-d');
                                                                  $qry = "SELECT COUNT(`site_id`) as d FROM `standby_geny_list`";

                                                                  $res = $con->query($qry);
                                                                  while ($data1 = $res->fetch_assoc()) {
                                                                    echo 'Rs. ' . $data1['d'];
                                                                  }
                                                                  ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calculator fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>