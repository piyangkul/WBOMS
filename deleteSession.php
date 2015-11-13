<?php
session_start();
if(!isset($_SESSION['username']))
    header('Location: index.php');
session_destroy();
header('Location: index.php');
?>