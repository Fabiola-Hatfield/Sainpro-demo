<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="./logo.png" width="180" height="65" alt="Logo">
    </a>
    <?php
    if (isset($_SESSION["user"])){
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="collapsingNavbar">

            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="./dashboard.php"><i class="fas fa-home">&nbsp;</i>Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="./manage_client.php"><i class="fas fa-users">&nbsp;</i>Clients</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="./manage_product.php"><i class="fas fa-industry">&nbsp;</i>Products</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownOrdersLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-list">&nbsp;</i>
                        Orders
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownOrdersLink">
                        <a class="dropdown-item" href="./new_order.php">New Order</a>
                        <a class="dropdown-item" href="./see_invoices.php">Previous Orders</a>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="./manage_user.php"><i class="fas fa-users-cog">&nbsp;</i>Users</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href='./operations/set-unset-session.php?action=logOut'><i class="fas fa-sign-out-alt">&nbsp;</i>Log out</a>
                </li>
            </ul>
        </div>
        <?php
    }
    ?>
</nav>