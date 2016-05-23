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
    if (isset($_SESSION['addProductShipment'])) {
        header("location: ../../shipment/add_shipment3.php?idshipment_period=" . $_SESSION['idshipment_period'] . "&idfactory=" . $_SESSION['idfactory'] . "&price=" . $_SESSION['price'] . "&status_shipment=" . $_SESSION['status_shipment'] . "&action=editProduct_orderCompleted");
        unset($_SESSION['addProductShipment']);
        unset($_SESSION['ship']);
        unset($_SESSION['idshipment_period']);
        unset($_SESSION['idfactory']);
        unset($_SESSION['price']);
        unset($_SESSION['status_shipment']);
    } else {
        header("location: ../order.php");
    }
}
if ($_GET['cancel'] == "addorder") {
    unset($_SESSION["product"]);
    unset($_SESSION["countProduct"]);
    unset($_SESSION["idshop"]);
    unset($_SESSION["detail"]);
    unset($_SESSION["time"]);
    unset($_SESSION["date"]);
    if (isset($_SESSION['addProductShipment'])) {
        unset($_SESSION['addProductShipment']);
        unset($_SESSION['ship']);
        unset($_SESSION['idshipment_period']);
        unset($_SESSION['idfactory']);
        unset($_SESSION['price']);
        unset($_SESSION['status_shipment']);
    }
    header("location: ../add_order.php");
}