<?php
    session_start();

    session_destroy();

    echo "You have logged out successfully. Click here to <a href='../auth/index.php'> Login </a>";

?>