<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" data-image="images/sidebar-1.jpg">

    <!-- <ul class="sidebar" data-color="purple" data-background-color="white" data-image="images/sidebar-1.jpg"> -->

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
      <div class="sidebar-brand-icon">
        <i class="fas fa-parking"></i>
      </div>
      <div class="sidebar-brand-text mx-3">PMS</div>
    </a>
    <hr class="sidebar-divider">
    <!-- Nav Item  -->

    <?php
    if ($_SESSION['user_type'] == 'Admin' | $_SESSION['user_type'] == 'Executive_Officer') {
      echo '
      <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="QR_Scanner.php">
        <i class="fas fa-qrcode"></i>
        <span>QR Scanner</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Parking_Spaces_Requests.php">
        <i class="fas fa-comments"></i>
        <span>Parking Spaces Requests</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Parking_Details_Log.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Parking Details Log</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Payment_Management.php">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Payment Management</span></a>
    </li>';
    } else {
      echo '
      <li class="nav-item">
      <a class="nav-link" href="dashboard_Customer.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Parking_Spaces_Requests.php">
        <i class="fas fa-comments"></i>
        <span>Booking Details Log</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Smart_Wallet.php">
      <i class="fab fa-google-wallet"></i>
        <span>Smart Wallet</span></a>
    </li>';
    }
    ?>


    <?php
    if ($_SESSION['user_type'] == 'Admin') {
      echo '
      <hr class="sidebar-divider">
    <li class="nav-item">
      <a class="nav-link" href="Registration.php">
        <i class="fas fa-users"></i>
        <span>Registration</span></a>
    </li>';
    } else {
    }

    ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->