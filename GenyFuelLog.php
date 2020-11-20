<?php include 'common/header.php'; ?>

<?php include 'common/navigation.php'; ?>

<?php include 'common/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Geny Fuel Details Log</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Geny Fuel Details Tables</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="genytable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
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
                                <th>NBT</th>
                                <th>VAT</th>
                                <th>Total Amount</th>
                                <th>TP Rate</th>
                                <th>Running Days</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Payment Date</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
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
                                <th>NBT</th>
                                <th>VAT</th>
                                <th>Total Amount</th>
                                <th>TP Rate</th>
                                <th>Running Days</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Payment Date</th>
                                <th>Remark</th>
                            </tr>
                        </tfoot>
                        <tbody>

                        </tbody>
                    </table>

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
                url: "select_Log.php",
                type: "post"
            }
        });
    });
</script>