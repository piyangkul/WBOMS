<?php

if ($_GET['cancel'] == "cancel") {
    unset($_SESSION["product"]);
    unset($_SESSION["countProduct"]);
    unset($_SESSION["idshop"]);
    header("location: ../order.php");
}