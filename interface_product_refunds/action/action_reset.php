<?php

session_start();
echo $_GET['cancel'];
if ($_GET['cancel'] == "cancel") {
    unset($_SESSION["productR"]);
    unset($_SESSION["countProductR"]);
    unset($_SESSION["idshopP"]);
   /* unset($_SESSION["detail"]);
    unset($_SESSION["time"]);
    unset($_SESSION["date"]);*/
    header("location: ../product_refunds.php");
}
if ($_GET['cancel'] == "addorder") {
    unset($_SESSION["productR"]);
    unset($_SESSION["countProductR"]);
    unset($_SESSION["idshopP"]);
  /*  unset($_SESSION["detail"]);
    unset($_SESSION["time"]);
    unset($_SESSION["date"]);*/
    header("location: ../add_product_refunds.php");
}