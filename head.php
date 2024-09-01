<div id="menuBar">
    <div class="left">
        <a href="<?php echo $location . "Index.php"; ?>">Home</a>
        <a href="<?php echo $location . "Index.php"; ?>">To be added</a>
        <a href="<?php echo $location . "Index.php"; ?>">TODO</a>
    </div>
    <div id="search">
        <input type="text" class="search" oninput=searchItems(<?php echo "'" . $location . "'"; ?>) id="searchInput">
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