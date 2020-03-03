<?php
include_once("db_config_isset_session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users Administration</title>
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
            <h2 class="text-center"><b>User's Details</b></h2>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div class="form-group float-right col-sm-4">
        <input type="text" id="user-search"
               name="user-search" class="form-control" placeholder="Search&hellip;">
    </div>
    <span class="counter float-right"></span>
    <div class="table-responsive table-wrapper-scroll-y scrollbar-y">
        <table class="table table-hover table-bordered" id="user-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>E-mail Address</th>
                <th>Register Date</th>
                <th>Last Connection</th>
                <th>User Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="get-user">
            <!--BODY IS RECEIVED FROM DATABASE-->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        let manage_obj = new ManagePage("User", ".del-user", "#user-search", "#get-user");
    })
</script>
<?php
include_once("templates/update_user.php")
?>
</body>
</html>