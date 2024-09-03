<div id="menuBar">
    <div class="left">
        <a href="<?php echo $location . "Index.php"; ?>">Home</a>
        <a href="<?php echo $location . "About"; ?>">About</a>
        <a href="<?php echo $location . "About/Contact.php"; ?>">Contact us</a>
    </div>
    <div id="search">
        <input type="text" class="search" autocomplete="new-password" id="searchInput"
               oninput=searchItems(<?php echo "'" . $location . "'"; ?>) >
        <div id="searchResult"></div>
    </div>
    <div class="right">
        <a href="<?php echo $location . "Accounts/chart"; ?>">Chart</a>
        <?php
        if (isset($_SESSION['loggedin'])) {
            echo "<a href='" . $location . "Accounts'>Account</a>";
            echo "<a href='" . $location . "Accounts/login/logout.php'>Log out</a>";
        } else {
            echo "<a href='" . $location . "Accounts/login'>Log in</a>";
            echo "<a href='" . $location . "Accounts/Signup'>Sign up</a>";
        }
        ?>
    </div>
</div>