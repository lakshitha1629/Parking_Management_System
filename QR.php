<?php include 'common/header.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">QR Scanner</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Scanning QR codes</h6>
                </div>
                <div class="card-body">
                    <div class="embed-responsive embed-responsive-4by3">
                        <video class="embed-responsive-item" id="preview">
                        </video>
                    </div>
                    <canvas id="myCanvas" width="150" height="150" style="border: 1.5px solid blueviolet;position: absolute;bottom: 124px;top: 124px;right: 124px;left: 124px;">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'common/footer.php'; ?>


<script type="text/javascript">
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });
    scanner.addListener('scan', function(content) {
        $.ajax({
            url: "addQrDb.php",
            type: 'post',
            dataType: "json",
            data: {
                id: content
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
                            action: function() {}
                        }
                    }
                });
            },
            error: function(data) {
                $.confirm({
                    title: 'Encountered an error!',
                    content: 'Something went downhill, this may be serious',
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
    });

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function(e) {
        console.error(e);
    });
</script>