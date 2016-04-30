<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
session_start();

$idproduct_order = $_GET['idproduct_order'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$idamount_product_order = $_GET['amount_product_order'];
$idunit = $_GET['name_unit'];

$getprice_unit = getedit_price_unit($idunit);
$price_unit = $getprice_unit['price_unit'];

$price = $_GET['price'];
$status_shipment_factory = $_GET['status_shipment'];

$_SESSION['idshipment_period'] = $idshipment_period;
$_SESSION['price'] = $price;
$_SESSION['status_shipment'] = $status_shipment;
$_SESSION['idfactory'] = $idfactory;



if (isset($_GET['addP'])) {
    $_SESSION['addProductShipment'] = "Chk";
    $getproduct_orderOld = getProductOrderOld($idproduct_order);
    $idunitOld = $getproduct_orderOld['idunit'];
    $idshopOld = $getproduct_orderOld['idshop'];
    $idfactoryOld = $getproduct_orderOld['idfactory'];
    $idproductOld = $getproduct_orderOld['idproduct'];
    $amountOld = $getproduct_orderOld['amount_product_order'];
    $priceOld = $getproduct_orderOld['price_product_order'];
    $diffOld = $getproduct_orderOld['difference_product_order'];
    $diff = $getproduct_orderOld['difference_amount_product'];
    $typeOld = $getproduct_orderOld['type_product_order'];
    $_SESSION['idshop'] = $idshopOld;
    if ($idunit === $idunitOld) {
        if (isset($_SESSION["countProduct"])) {
            $_SESSION["countProduct"] ++;
        } else {
            $_SESSION["countProduct"] = 1;
        }
        $_SESSION["product"][$_SESSION["countProduct"]]["idUnit"] = $idunitOld;
        $_SESSION["product"][$_SESSION["countProduct"]]["productName"] = $idproductOld;
        $_SESSION["product"][$_SESSION["countProduct"]]["factoryName"] = $idfactoryOld;
        $_SESSION["product"][$_SESSION["countProduct"]]["AmountProduct"] = $amountOld - $idamount_product_order;
        $_SESSION["product"][$_SESSION["countProduct"]]["difference"] = $diff;
        if ($typeOld === "PERCENT") {
            $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = $diffOld;
            $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = "";
            $_SESSION["product"][$_SESSION["countProduct"]]["total"] = ($price_unit - (($price_unit * $diffOld) / 100)) * ($amountOld - $idamount_product_order);
        } else {
            $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = "";
            $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = $diffOld;
            $_SESSION["product"][$_SESSION["countProduct"]]["total"] = (($price_unit * 1) + ($diffOld * 1)) * ($amountOld - $idamount_product_order);
        }

        $_SESSION["product"][$_SESSION["countProduct"]]["price"] = ($price_unit * 1);
        $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $price_unit * ($amountOld - $idamount_product_order);
        $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $typeOld;
    } else {
        $amountUnitNew = $amountOld;
        $getAmountNew = getUnitNew($idproductOld, $idunit, $idunitOld);
        $val_price = 0;
        $idunitS = $idunit;
        $count = 0;
        foreach ($getAmountNew as $value) {
            $val_amount_unit = $value['amount_unit'];
            $val_price = $value['price_unit'];
            $amountUnitNew = $val_amount_unit * $amountUnitNew;
            $count++;
        }
        $amountLatest = $amountUnitNew - $idamount_product_order;
        for ($i = 1; $i <= $count; $i++) {
            $getUnitcal = getUnitCal($idunitS);
            $idUnitBig = $getUnitcal['idunit_big'];
            $amountMod = $amountLatest % $getUnitcal['amount_unit'];
            $priceMod = $getUnitcal['price_unit'];
            echo $amountMod . " ";
            if ($amountMod > 0) {
                if (isset($_SESSION["countProduct"])) {
                    $_SESSION["countProduct"] ++;
                } else {
                    $_SESSION["countProduct"] = 1;
                }
                $_SESSION["product"][$_SESSION["countProduct"]]["idUnit"] = $idunitS;
                $_SESSION["product"][$_SESSION["countProduct"]]["productName"] = $idproductOld;
                $_SESSION["product"][$_SESSION["countProduct"]]["factoryName"] = $idfactoryOld;
                $_SESSION["product"][$_SESSION["countProduct"]]["AmountProduct"] = $amountMod;
                $_SESSION["product"][$_SESSION["countProduct"]]["difference"] = $diff;
                if ($typeOld === "PERCENT") {
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = $diffOld;
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = "";
                    $_SESSION["product"][$_SESSION["countProduct"]]["total"] = ($priceMod - (($priceMod * $diffOld) / 100)) * $amountMod;
                } else {
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = "";
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = $diffOld;
                    $_SESSION["product"][$_SESSION["countProduct"]]["total"] = (($priceMod * 1) + ($diffOld * 1)) * $amountMod;
                }
                $_SESSION["product"][$_SESSION["countProduct"]]["price"] = ($priceMod * 1);
                $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $priceMod * $amountMod;
                $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $typeOld;
            }
            if ($idUnitBig === "0") {
                if (isset($_SESSION["countProduct"])) {
                    $_SESSION["countProduct"] ++;
                } else {
                    $_SESSION["countProduct"] = 1;
                }
                $_SESSION["product"][$_SESSION["countProduct"]]["idUnit"] = $idunitS;
                $_SESSION["product"][$_SESSION["countProduct"]]["productName"] = $idproductOld;
                $_SESSION["product"][$_SESSION["countProduct"]]["factoryName"] = $idfactoryOld;
                $_SESSION["product"][$_SESSION["countProduct"]]["AmountProduct"] = $amountLatest;
                $_SESSION["product"][$_SESSION["countProduct"]]["difference"] = $diff;
                if ($typeOld === "PERCENT") {
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = $diffOld;
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = "";
                    $_SESSION["product"][$_SESSION["countProduct"]]["total"] = ($priceMod - (($priceMod * $diffOld) / 100)) * $amountLatest;
                } else {
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = "";
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = $diffOld;
                    $_SESSION["product"][$_SESSION["countProduct"]]["total"] = (($priceMod * 1) + ($diffOld * 1)) * $amountLatest;
                }
                $_SESSION["product"][$_SESSION["countProduct"]]["price"] = ($priceMod * 1);
                $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $priceMod * $amountLatest;
                $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $typeOld;
            }
            $amountLatest = floor($amountLatest / $getUnitcal['amount_unit']);
            $idunitS = $getUnitcal['idunit_big'];
        }
    }
}
if ($_GET['p'] === "editProduct") {
    $checkEdit_Amount_Product_order = editProduct_order($idproduct_order, $idamount_product_order, $idunit, $price_unit);
}
/*if ($checkEdit_Amount_Product_order) {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price . "&status_shipment=" . $status_shipment_factory . "&action=editProduct_orderCompleted");
} else {
    header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price . "&status_shipment=" . $status_shipment_factory . "&action=editProduct_orderError");
}*/