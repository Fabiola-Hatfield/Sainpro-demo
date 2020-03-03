<?php
include_once ("db_config_isset_session.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Clients Administration</title>
    <?php
    include_once("stylesheets.php");
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
            <h2 class="text-center"><b>Client's </b>Details</h2>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div class="form-group float-right col-sm-4">
        <input type="text" id="client_search"
               name="client_search" class="form-control" placeholder="Search&hellip;">
    </div>
    <span class="counter float-right"></span>
    <div class="table-responsive table-wrapper-scroll-y scrollbar-y">
        <table class="table table-hover table-bordered" id="client_table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>E-mail Address</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="get_client">
            <!--BODY IS RECEIVED FROM DATABASE-->
            </tbody>
        </table>
    </div>
</div>


<!-- script to call ManagePage function when document is ready-->
<script>
    $(document).ready(function(){
        let manage_obj = new ManagePage("Client", ".del-client", "#client_search", "#get_client");
    });
</script>
<?php
include_once("templates/update_client.php")
?>
</body>
</html>