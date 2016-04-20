<?php

session_start();
echo $_GET['cancel'];
if ($_GET['cancel'] == "cancel") {
    unset($_SESSION["unit"]);
    unset($_SESSION["countUnit"]);
    header("location: ../product.php");
}
if ($_GET['cancel'] == "addorder") {
    unset($_SESSION["unit"]);
    unset($_SESSION["countUnit"]);
    header("location: ../add_product.php");
}