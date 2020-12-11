<?php include 'common/header.php'; ?>
<!-- <meta http-equiv="refresh" content="900"> -->

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">QR Scanner</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-2 col-md-6 mb-4">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Code Reader</h6>
                </div>
                <div class="card-body">
                    <!-- <video id="preview"></video> -->
                    <button type="button" class="btn btn-light" onclick="myFunction()"><i class="fa fa-qrcode" aria-hidden="true" style="font-size:145px;color: indigo;"></i></button>

                </div>
            </div>
        </div>
        <div class="col-xl-10 col-md-6 mb-4">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Scan log</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="genytable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Vehicle No</th>
                                    <th>Vehicle Categorie</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Vehicle Type</th>
                                    <th>Phone Number</th>
                                    <th>Vehicle IN Time</th>
                                    <th>Vehicle Out Time</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Vehicle No</th>
                                    <th>Vehicle Categorie</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Vehicle Type</th>
                                    <th>Phone Number</th>
                                    <th>Vehicle IN Time</th>
                                    <th>Vehicle Out Time</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
    window.setTimeout(function() {
        location.reload();
    }, 4000);

    $(document).ready(function() {
        var dataTable = $('#genytable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "Select_QR_Scanner.php",
                type: "post"
            }
        });
    });
</script>

<script>
    function myFunction() {
        var myWindow = window.open("QR.php", "", "width=450,height=550");
    }
</script>