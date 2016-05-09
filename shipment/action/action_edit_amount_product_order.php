<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
session_start();

unset($_SESSION['date']);
unset($_SESSION['time']);

$idproduct_order = $_GET['idproduct_order'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$idamount_product_order = $_GET['amount_product_order'];
$idunit = $_GET['name_unit'];
echo $idunit;

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

    $_SESSION['shipment_edit_idunit'] = $idunitOld;
    $_SESSION['shipment_edit_idproduct'] = $idproductOld;
    $_SESSION['shipment_edit_idfactory'] = $idfactoryOld;
    $_SESSION['shipment_edit_amount'] = $amountOld;
    $_SESSION['shipment_edit_price'] = $priceOld;
    $_SESSION['shipment_edit_diff'] = $diffOld;
    $_SESSION['shipment_edit_diff_amount_product'] = $diff;
    $_SESSION['shipment_edit_type'] = $typeOld;

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
            $amountSSS = 1;
            $getDiff = getDiffBathaction($idproductOld, $idunitOld);
            foreach ($getDiff as $value) {
                $val_amount_unit = $value['amount_unit'];
                $amountSSS = $val_amount_unit * $amountSSS;
            }
            $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = "";
            $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = $diffOld * $amountSSS;
            $_SESSION["product"][$_SESSION["countProduct"]]["total"] = (($price_unit * 1) + ($diffOld / $amountSSS)) * ($amountOld - $idamount_product_order);
        }

        $_SESSION["product"][$_SESSION["countProduct"]]["price"] = ($price_unit * 1);
        $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $price_unit * ($amountOld - $idamount_product_order);
        $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $typeOld;
    } else if ($idunit > $idunitOld) {
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
                    $amountSSS = 1;
                    $getDiff = getDiffBathaction($idproductOld, $idunitS);
                    foreach ($getDiff as $value) {
                        $val_amount_unit = $value['amount_unit'];
                        $amountSSS = $val_amount_unit * $amountSSS;
                    }
                    $_SESSION ["product"][$_SESSION["countProduct"]]["DifferencePer"] = "";
                    $_SESSION["product"][$_SESSION ["countProduct"]]["DifferenceBath"] = $diffOld * $amountSSS;
                    $_SESSION["product"][$_SESSION ["countProduct"]]["total"] = (($priceMod * 1) + ($diffOld / $amountSSS)) * $amountMod;
                }
                $_SESSION["product"][$_SESSION ["countProduct"]]["price"] = ($priceMod * 1);
                $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $priceMod * $amountMod;
                $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $typeOld;
            }
            if ($idUnitBig === "0") {
                if ($amountLatest > 0) {
                    if (isset($_SESSION["countProduct"])) {
                        $_SESSION["countProduct"] ++;
                    } else {
                        $_SESSION["countProduct"] = 1;
                    }
                    $_SESSION["product"][$_SESSION["countProduct"]]["idUnit"] = $idunitS;
                    $_SESSION["product"][$_SESSION["countProduct"]]["productName"] = $idproductOld;
                    $_SESSION["product"][$_SESSION ["countProduct"]]["factoryName"] = $idfactoryOld;
                    $_SESSION["product"][$_SESSION["countProduct"]]["AmountProduct"] = $amountLatest;
                    $_SESSION["product"][$_SESSION["countProduct"]]["difference"] = $diff;
                    if ($typeOld === "PERCENT") {
                        $_SESSION ["product"] [$_SESSION["countProduct"]]["DifferencePer"] = $diffOld;
                        $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = "";
                        $_SESSION["product"][$_SESSION["countProduct"]]["total"] = ($priceMod - (($priceMod * $diffOld) / 100)) * $amountLatest;
                    } else {
                        $amountSSS = 1;
                        $getDiff = getDiffBathaction($idproductOld, $idunitS);
                        foreach ($getDiff as $value) {
                            $val_amount_unit = $value['amount_unit'];
                            $amountSSS = $val_amount_unit * $amountSSS;
                        }
                        $_SESSION ["product"] [$_SESSION["countProduct"]]["DifferencePer"] = "";
                        $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = $diffOld;
                        $_SESSION["product"][$_SESSION["countProduct"]]["total"] = (($priceMod * 1) + ($diffOld / $amountSSS)) * $amountLatest;
                    }
                    $_SESSION["product"][$_SESSION["countProduct"]]["price"] = ($priceMod * 1);
                    $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $priceMod * $amountLatest;
                    $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $typeOld;
                }
            }
            $amountLatest = floor($amountLatest / $getUnitcal['amount_unit']);
            $idunitS = $getUnitcal['idunit_big'];
        }
    } else if ($idunit < $idunitOld) {
        $amountUnitNew = $amountOld; //5ห่อ
        $amountLast = $amountOld;
        $amountLatest = $amountOld;
        $getAmountNew = getUnitNewDESC($idproductOld, $idunitOld, $idunit);
        $val_price = 0;
        // $idunitS = $idunit; //มัด $idamount_product_order 1มัด
        $count = 0;
        $i = 0;
        foreach ($getAmountNew as $value) {
            $val_amount_unit = $value['amount_unit'];
            $val_price = $value['price_unit'];
            $idunitW = $value['idunit'];
            $amountKKK = $amountUnitNew % $val_amount_unit;
            $amountUnitNew = $amountUnitNew / $val_amount_unit;
            $val_idunitBig = $value['idunit_big'];
            if ($amountKKK > 0) {
                if (isset($_SESSION["countProduct"])) {
                    $_SESSION["countProduct"] ++;
                } else {
                    $_SESSION["countProduct"] = 1;
                }
                $_SESSION["product"][$_SESSION["countProduct"]]["idUnit"] = $idunitW;
                $_SESSION["product"][$_SESSION["countProduct"]]["productName"] = $idproductOld;
                $_SESSION ["product"][$_SESSION["countProduct"]]["factoryName"] = $idfactoryOld;
                $_SESSION["product"][$_SESSION["countProduct"]]["AmountProduct"] = $amountKKK;
                $_SESSION["product"][$_SESSION["countProduct"]]["difference"] = $diff;
                if ($typeOld === "PERCENT") {
                    $_SESSION ["product"] [$_SESSION["countProduct"]]["DifferencePer"] = $diffOld;
                    $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = "";
                    $_SESSION["product"][$_SESSION["countProduct"]]["total"] = ($val_price - (($val_price * $diffOld) / 100)) * $amountKKK;
                } else {
                    $amountSSS = 1;
                    $getDiff = getDiffBathaction($idproductOld, $idunitW);
                    foreach ($getDiff as $value) {
                        $val_amount_unitS = $value['amount_unit'];
                        $amountSSS = $val_amount_unitS * $amountSSS;
                    }
                    $_SESSION ["product"][$_SESSION["countProduct"]]["DifferencePer"] = "";
                    $_SESSION["product"][$_SESSION ["countProduct"]]["DifferenceBath"] = $diffOld;
                    $_SESSION["product"][$_SESSION ["countProduct"]]["total"] = (($val_price * 1) + ($diffOld * $amountSSS)) * $amountKKK;
                }
                $_SESSION["product"][$_SESSION["countProduct"]]["price"] = ($val_price * 1);
                $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $val_price * $amountKKK;
                $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $typeOld;
            } elseif (!isset($idUnitBig)) {
                if (floor($amountUnitNew) > 0) {
                    $amountUnitNew -= $idamount_product_order;
                    if ($amountUnitNew >= 1) {
                        if (isset($_SESSION["countProduct"])) {
                            $_SESSION["countProduct"] ++;
                        } else {
                            $_SESSION["countProduct"] = 1;
                        }
                        $_SESSION["product"][$_SESSION["countProduct"]]["idUnit"] = $idunitW;
                        $_SESSION["product"][$_SESSION["countProduct"]]["productName"] = $idproductOld;
                        $_SESSION["product"][$_SESSION["countProduct"]]["factoryName"] = $idfactoryOld;
                        $_SESSION["product"][$_SESSION["countProduct"]]["AmountProduct"] = floor($amountUnitNew);
                        $_SESSION["product"][$_SESSION["countProduct"]]["difference"] = $diff;
                        if ($typeOld === "PERCENT") {
                            $_SESSION ["product"][$_SESSION ["countProduct"]]["DifferencePer"] = $diffOld;
                            $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = "";
                            $_SESSION["product"][$_SESSION["countProduct"]]["total"] = ($val_price - (($val_price * $diffOld) / 100)) * floor($amountUnitNew);
                        } else {
                            $amountSSS = 1;
                            $getDiff = getDiffBathaction($idproductOld, $idunitW);
                            foreach ($getDiff as $value) {
                                $val_amount_unitS = $value['amount_unit'];
                                $amountSSS = $val_amount_unitS * $amountSSS;
                            }
                            $_SESSION ["product"] [$_SESSION["countProduct"]]["DifferencePer"] = "";
                            $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = $diffOld;
                            $_SESSION["product"][$_SESSION["countProduct"]]["total"] = (($val_price * 1) + ($diffOld * $amountSSS)) * floor($amountUnitNew);
                        }
                        $_SESSION["product"][$_SESSION["countProduct"]]["price"] = ($val_price * 1);
                        $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $val_price * floor($amountUnitNew);
                        $_SESSION["product"] [$_SESSION["countProduct"]]["type"] = $typeOld;
                    }
                }
            }
            /* $amountLast = $amountUnitNew; */
            if ($amountUnitNew >= 1) {
                $count++;
            }
        }
        $amountLatest = $amountUnitNew - $idamount_product_order;
        //echo $amountLatest;
        //echo $count;
    }
}
if ($_GET['p'] === "editProduct") {
    $checkEdit_Amount_Product_order = editProduct_order($idproduct_order, $idamount_product_order, $idunit, $price_unit);
}
    /* if ($checkEdit_Amount_Product_order) {
      header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price . "&status_shipment=" . $status_shipment_factory . "&action=editProduct_orderCompleted");
      } else {
      header("location: ../add_shipment3.php?idshipment_period=" . $idshipment_period . "&idfactory=" . $idfactory . "&price=" . $price . "&status_shipment=" . $status_shipment_factory . "&action=editProduct_orderError");
      } */    