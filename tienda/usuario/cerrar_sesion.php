<?php
    session_start();
    session_destroy();
    header("location: ../util/index.php");
    exit;
?>