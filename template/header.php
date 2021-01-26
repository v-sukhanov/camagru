
<div class="header">
    <div class="logo">
        <span>
            camagru
        </span>
    </div>
    <div id="burger" class="burger">
        <i class="material-icons">menu</i>
    </div>
    <div class="navbar" id="links">
        <div class="navbar__item">
            <a href="../index.php">
                GALLERY
            </a>
        </div>
        <?php
            if (isset($_SESSION['logged_name'])) {

        ?>
        <div class="navbar__item">
            <a href="../profile.php">
                PROFILE
            </a>
        </div>
        <div class="navbar__item">
            <a href="../settings.php">
                SETTINGS
            </a>
        </div>
        <?php
            }
        ?>
        <div class="navbar__item">
            <?php
                if (isset($_SESSION['logged_name'])) {
                    echo '<a href="../controls/signout.php">SIGN OUT</a>';
                } else {
                    echo '<a href="../signin.php">SIGN IN</a>';
                }
            ?>

        </div>
    </div>
</div>
 <script type="text/javascript" src="../js/header.js"></script>
