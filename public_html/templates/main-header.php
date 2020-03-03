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