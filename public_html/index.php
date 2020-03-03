<?php
session_start();
include_once("./database/connection.php");
if (isset($_SESSION["user"])) {
    header("location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="css/overlay_style.css">
    <?php include("templates/content.php"); ?>
</head>

<body>
<div class="overlay">
    <div class="loader"></div>
</div>
<div class="content" style="max-width:1600px">
    <!-- Header -->
    <?php include_once("templates/main-header.php"); ?>
    <!-- Grid -->
    <div class="container">
        <div class="log-form-container">
            <!-- Begins form -->
            <form id="login-form" method="post" role="form" style="display: block;" autocomplete="off">
                <div class="form-header">
                    <h3 class="form-title"><i class="fas fa-user"></i>
                        <span>Log In</span>
                    </h3>
                </div>

                <div class="form-body">
                    <!-- json response will be here -->
                    <div class="alert alert-danger" role="alert" id="error" style="display: none;">...</div>
                    <!-- json response will be here -->
                    <div class="form-group">
                        <div class="input-group login-input-group log-bg">
                            <input type="text" name="email" id="email" class="form-control"
                                   placeholder="E-mail Address">
                            <i class="fas fa-user fa-lg fa-fw" aria-hidden="true"></i>
                        </div>
                        <span class="help-block" id="error"></span>
                    </div>
                    <div class="form-group ">
                        <label for="password" hidden>Password</label>
                        <div class="input-group login-input-group log-bg">
                            <input name="password" id="password" type="password" class="form-control"
                                   placeholder="Password">
                            <i class="fas fa-key fa-lg fa-fw" aria-hidden="true"></i>
                        </div>
                        <span class="help-block" id="error"></span>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-login" name="login-submit"
                            id="login-submit">
                        <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span>
                        Login
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php include_once("templates/scripts.php"); ?>
<script src="js/manage.js"></script>
<script>
    $(document).ready(function () {
        let log_obj = new Login();
    })
</script>
</body>
</html>