<?php

session_start();
echo $_GET['cancel'];
if ($_GET['cancel'] == "cancel") {
    unset($_SESSION["product"]);
    unset($_SESSION["countProduct"]);
    unset($_SESSION["idshop"]);
    unset($_SESSION["detail"]);
    unset($_SESSION["time"]);
    unset($_SESSION["date"]);
    header("location: ../order.php");
}
if ($_GET['cancel'] == "addorder") {
    unset($_SESSION["product"]);
    unset($_SESSION["countProduct"]);
    unset($_SESSION["idshop"]);
    unset($_SESSION["detail"]);
    unset($_SESSION["time"]);
    unset($_SESSION["date"]);
    header("location: ../add_order.php");
}