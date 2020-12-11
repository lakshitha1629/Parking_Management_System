<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User Registration</h1>
  </div>
  <!-- Content Row -->
  <div class="row">
    <!-- Reg  -->
    <div class="col-xl-12 col-md-6 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Registration Form</h6>
        </div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>Email Address :</label>
                <input type="text" name="name" class="form-control" placeholder="Enter the email address" maxlength="10" required>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>Password :</label>
                <input type="password" name="password1" class="form-control" placeholder="Enter the password" maxlength="30" required>
              </div>
              <div style="padding-right: 34px;">
              </div>
              <div class="col-md-4 mb-3">
                <label>Confirm Password :</label>
                <input type="password" name="password2" class="form-control" placeholder="Enter the password again" maxlength="30" required>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>User Type :</label>
                <select class="form-control" name="type" required>
                  <option value="" disabled selected>Choose User Type</option>
                  <option value="1">Admin</option>
                  <option value="3">Executive Officer</option>
                </select>
              </div>
            </div>
            <br>
            <input class="btn btn-success" type=submit value="ADD" name="submit1">
          </form>
        </div>
        <?php

        if (isset($_POST['submit1'])) {
          require_once('connect.php');
          //$date = $_POST['date'];
          $user_id = uniqid();
          $name = $_POST['name'];
          $password1 = $_POST['password1'];
          $password2 = $_POST['password2'];
          $type = $_POST['type'];
          $active = '0';

          if ($password1 != $password2) {
            echo "The two passwords do not match";
          } else {
            $password = md5($password1);
            $qry = "INSERT INTO `user_account`(`user_id`,`email`, `user_type`, `password`, `activated`) VALUES ('$user_id','$name','$type','$password','$active')";
            //echo $qry;
            if (!mysqli_query($con, $qry)) {
              die('Error: ' . mysqli_error());
            }
            echo "Registration Successfull";
          }
        }
        ?>
      </div>
    </div>


    <!-- res -->
    <div class="col-xl-12 col-md-6 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Password Reset Form</h6>
        </div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>Email Address :</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Enter the email address" maxlength="10" required>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label>Password :</label>
                <input type="password" name="pwd1" id="pwd1" class="form-control" placeholder="Enter the password" maxlength="30" required>
              </div>
              <div style="padding-right: 34px;">
              </div>
              <div class="col-md-4 mb-3">
                <label>Confirm Password :</label>
                <input type="password" name="pwd2" id="pwd2" class="form-control" placeholder="Enter the password again" maxlength="30" required>
              </div>
            </div>
            <br>
            <input class="btn btn-success" type=submit value="Reset" name="Reset">
          </form>
          <?php

          if (isset($_POST['Reset'])) {
            require_once('connect.php');
            //$date = $_POST['date'];
            $name = $_POST['email'];
            $password1 = $_POST['pwd1'];
            $password2 = $_POST['pwd2'];

            if ($password1 != $password2) {
              echo "The two passwords do not match";
            } else {
              $password = md5($password1);

              $qry = "UPDATE `user_account` SET `password`='$password' WHERE `user_name` = '$name'";

              //   $qry = "INSERT INTO `cbm_user_account`(`user_name`,`user_type`, `password`, `activated`) VALUES ('$name','$type','$password','$active')";
              //echo $qry;
              if (!mysqli_query($con, $qry)) {
                die('Error: ' . mysqli_error());
              }
              echo "Registration Successfull";
            }
          }
          ?>
        </div>
      </div>
    </div>

    <!-- DataTables  -->
    <div class="col-xl-12 col-md-6 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">User Table</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <?php
            require_once('connect.php');

            $qry = "SELECT * FROM user_account WHERE `user_type`='1' OR `user_type`='2' OR `user_type`='3'";

            echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>   
                  <tr> 
                  <th>Email Address</th>
                  <th>User_Type</th>
                  <th>Activate</th>  
                  <th width="20%"></th>         
                  </tr>
             </thead>';

            if ($res = $con->query($qry)) {
              while ($row = $res->fetch_assoc()) {
                $id = $row["user_id"];
                $field1name = $row["email"];
                $field2name = $row["user_type"];
                $field3name = $row["activated"];

                if ($field2name == '3') {
                  echo "<tr> 
                                <td>" . $field1name . "</td> 
                                <td>Executive Officer</td>";
                  if ($field3name == '1') {
                    echo "<td>Activate</td><td><a href=\"activate.php?id=" . $row['user_id'] . "&active=" . $row['activated'] . "\" type='button' class='btn btn-info'>Activate / Deactivate</a>
                                  </td> 
             
                                  </tr>";
                  } else {
                    echo "<td>Deactivate</td><td><a href=\"activate.php?id=" . $row['user_id'] . "&active=" . $row['activated'] . "\" type='button' class='btn btn-info'>Activate / Deactivate</a>
                                  </td> 
             
                                  </tr>";
                  }
                } else if ($field2name == '2') {       
                  echo "<tr> 
                            <td>" . $field1name . "</td> 
                            <td>Customer</td>";
                  if ($field3name == '1') {
                    echo "<td>Activate</td><td><a href=\"activate.php?id=" . $row['user_id'] . "&active=" . $row['activated'] . "\" type='button' class='btn btn-info'>Activate / Deactivate</a>
                              </td> 
        
                              </tr>";
                  } else {
                    echo "<td>Deactivate</td><td><a href=\"activate.php?id=" . $row['user_id'] . "&active=" . $row['activated'] . "\" type='button' class='btn btn-info'>Activate / Deactivate</a>
                              </td>  
        
                              </tr>";
                  }
                } else if ($field2name == '1') {       
                  echo "<tr> 
                            <td>" . $field1name . "</td> 
                            <td>Admin</td>";
                  if ($field3name == '1') {
                    echo "<td>Activate</td><td><a href=\"activate.php?id=" . $row['user_id'] . "&active=" . $row['activated'] . "\" type='button' class='btn btn-info'>Activate / Deactivate</a>
                              </td> 
        
                              </tr>";
                  } else {
                    echo "<td>Deactivate</td><td><a href=\"activate.php?id=" . $row['user_id'] . "&active=" . $row['activated'] . "\" type='button' class='btn btn-info'>Activate / Deactivate</a>
                              </td>  
        
                              </tr>";
                  }
                }else {
                  echo "<tr><td>Undefined User</td></tr>";
                }
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
  <script>
    var table = document.getElementById('dataTable');

    for (var i = 1; i < table.rows.length; i++) {
      table.rows[i].onclick = function() {
        //rIndex = this.rowIndex;
        document.getElementById("email").value = this.cells[0].innerHTML;
        //  document.getElementById("pwd1").value = this.cells[1].innerHTML;
      };
    }
  </script>