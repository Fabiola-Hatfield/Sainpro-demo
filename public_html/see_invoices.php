<?php
include_once("db_config_isset_session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoices Information</title>
    <?php
    include_once("stylesheets.php");
    ?>

    <?php
    include_once("templates/scripts.php");
    ?>

    <script src="js/manage.js"></script>
</head>

<body>
<!-- Navbar -->
<?php include_once("templates/header.php"); ?>
<br/><br/>

<div class="container table-wrapper">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <h2 class="text-center"><b>Invoice's Details</b></h2>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div class="form-group float-right col-sm-4">
        <input type="text" id="invoice-search"
               name="invoice-search" class="form-control" placeholder="Search&hellip;">
    </div>
    <span class="counter float-right"></span>
    <div class="table-responsive table-wrapper-scroll-y scrollbar-y">
        <table class="table table-hover table-bordered" id="invoice-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Order Date</th>
                <th>Net Total</th>
                <th>Paid</th>
                <th>Show More</th>
            </tr>
            </thead>
            <tbody id="get-invoice">
            <!--BODY IS RECEIVED FROM DATABASE-->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        let manage_obj = new ManagePage("Invoice", ".delin", "#invoice-search", "#get-invoice");
        manage_obj.moreInfo("#get-invoice-det");
    });
</script>
<?php
include_once("templates/invoice_modal.php")
?>
</body>
</html>