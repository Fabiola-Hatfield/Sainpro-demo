<?php
include_once ("db_config_isset_session.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory System</title>

    <!-- CSS links and scripts -->
    <?php
    include_once ("templates/main_css.php");
    include_once("templates/scripts.php");
    ?>
    <script src="js/manage.js"></script>

</head>
<body>

<!-- Navbar !-->
<?php include_once("templates/main-header.php"); ?>
<br><br/>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mx-auto">
                    <img class="card-img-top mx-auto pt-2" src="images/user2.png" style="width: 45%;" alt="User Icon">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fas fa-user">&nbsp;</i> User's Name</h4>
                        <p class="card-text"><?= $_SESSION['user']['user_name'] ?></p>
                        <p class="card-text"><i class="fas fa-user">&nbsp;</i><?= $_SESSION['user']['user_type'] ?></p>
                        <p class="card-text">Last Connection: <?= $_SESSION['user']['last_login'] ?></p>
                        <a href="#" class="btn btn-primary edit-profile" id="<?php echo $_SESSION["user"]["user_id"];?>" data-toggle="modal" data-target="#upd-prof-modal" ><i class="fas fa-edit">&nbsp;</i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 main-div">
                <div class="jumbotron">
                    <h1>Welcome, <span class="user"><?= $_SESSION['user']['user_name'] ?></span> </h1>
                    <div class="row clock-row">
                        <div class="col-md-6">
                            <iframe scrolling="no" frameborder="no" clocktype="html5" style="overflow:hidden;border:0;margin:0;padding:0;width:300px;height:180px;" src="https://www.clocklink.com/html5embed.php?clock=044&timezone=USA_Springfield&color=white&size=450&Title=&Message=&Target=&From=2020,1,1,0,0,0&Color=white"></iframe>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Orders</h4>
                                    <p class="card-text">Create new orders here.</p>
                                    <a href="new_order.php" class="btn btn-primary">New Order</a>
                                    <a href="see_invoices.php" class="btn btn-primary">Prev. Invoices</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card bottom-cards">
                    <div class="card-body">
                        <h4 class="card-title">Clients</h4>
                        <p class="card-text">Add & Manage clients here</p>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-client-modal" >Add</a>
                        <a href="manage_client.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bottom-cards">
                    <div class="card-body">
                        <h4 class="card-title">Products</h4>
                        <p class="card-text">Add & Manage products here</p>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-product-modal">Add</a>
                        <a href="manage_product.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bottom-cards">
                    <div class="card-body">
                        <h4 class="card-title">Users (admin only)</h4>
                        <p class="card-text">Add & Manage users of the system here</p>

                        <?php
                        if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'Admin') {
                            ?>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-user-modal">Add</a>
                            <a href="manage_user.php" class="btn btn-primary" id="mana_user">Manage</a><?php
                        }else{?>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add-user-modal" disabled>Add</button>
                            <button class="btn btn-primary" id="mana_user" disabled>Manage</button><?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//user modal form
include_once("templates/user.php");

//client modal form
include_once("templates/client.php");

//product modal form
include_once("templates/product.php");

//profile modal form
include_once("templates/update_profile.php");
?>

<script>
    $(document).ready(function(){
        let man_obj = new ManageProfile();
        let add_rec_obj = new AddRecords();
    })
</script>
</body>
</html>