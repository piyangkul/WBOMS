<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';

session_start();
echo "<pre>";
print_r($_POST);
//print_r($_SESSION);
echo "</pre>";

//กลุ่มรับค่า
//ส่งข้อมูล หน้า add product มาหน้านี้ 
//$productCode = $_POST['productCode'];
//$code_order = $_POST['code_order'];
$idshop = $_POST['idshop'];
$date_order = $_POST['date_order'];
$time_order = $_POST['time_order'];
$detail_order = $_POST['detail_order'];
//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
$products = $_SESSION["product"];
$countCode = countCode($idshop);
$num = $countCode["CountCode"];

$code_order = $num + 1;
echo $code_order;

//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
//if (!checkcode($productCode)) {
//echo checkDuplicateProduct($productName, $factoryID);
if (isset($_SESSION["product"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง
    $idorder = addOrder($code_order, $idshop, $date_order, $time_order, $detail_order); //idproductของระบบ
    echo "idorder=" . $idorder;
    if ($idorder > 0) {
        //$idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
        for ($i = 1; $i <= count($products); $i++) {
            //$under_unit = $units[$i]['under_unit'];
            //$underIdUnit = $idUnit[$under_unit]; 
            if ($products[$i]['type'] === "PERCENT") {
                $idproduct[$i] = addProductOrder($products[$i]['idUnit'], $idorder, $products[$i]['AmountProduct'], $products[$i]['DifferencePer'], $products[$i]['type'], $products[$i]['total_price'] / $products[$i]['AmountProduct']);
                $getproduct = getIDProduct($products[$i]['idUnit']);
                $idproduct2 = $getproduct['idproduct'];
                $delDiff[$i] = deleteDifference($idproduct2, $idshop);
                $addDiff[$i] = addDiff($idproduct2, $idshop, $products[$i]['type'], $products[$i]['DifferencePer'], $date_order);
            }
            if ($products[$i]['type'] === "BATH") {

                $val_idunit = $products[$i]['idUnit'];
                $val_idproduct = $products[$i]["productName"];
                $amount = 1;
                $getDiff = getDiffBathaction($val_idproduct, $val_idunit);
                foreach ($getDiff as $value) {
                    $val_amount_unit = $value['amount_unit'];
                    $val_price = $value['price_unit'];
                    $amount = $val_amount_unit * $amount;
                }
                $idproduct[$i] = addProductOrder($products[$i]['idUnit'], $idorder, $products[$i]['AmountProduct'], $products[$i]['DifferenceBath'] / $amount, $products[$i]['type'], $products[$i]['total_price'] / $products[$i]['AmountProduct']);
                $getproduct = getIDProduct($products[$i]['idUnit']);
                $idproduct2 = $getproduct['idproduct'];
                $delDiff[$i] = deleteDifference($idproduct2, $idshop);
                $addDiff[$i] = addDiff($idproduct2, $idshop, $products[$i]['type'], $products[$i]['DifferenceBath'], $date_order);
            }
            //echo "555";
            //$idUnit[$i] = addUnit($idshop, $underIdUnit, $units[$i]['AmountPerUnit'], $units[$i]['NameUnit'], $units[$i]['price'], $units[$i]['type']);
        }
        //echo "555";
        unset($_SESSION["product"]);
        unset($_SESSION["countProduct"]);
        if (isset($_SESSION['addProductShipment'])) {
            header("location: ../../shipment/add_shipment3.php?idshipment_period=" . $_SESSION['idshipment_period'] . "&idfactory=" . $_SESSION['idfactory'] . "&price=" . $_SESSION['price'] . "&status_shipment=" . $_SESSION['status_shipment'] . "&action=editProduct_orderCompleted");
            unset($_SESSION['ship']);
            unset($_SESSION['addProductShipment']);
            unset($_SESSION['idshipment_period']);
            unset($_SESSION['idfactory']);
            unset($_SESSION['price']);
            unset($_SESSION['status_shipment']);
        } else {
            header("location: ../order.php?p=history_order&action=addCompleted");
        }
    } else {
        unset($_SESSION["product"]);
        unset($_SESSION["countProduct"]);
        if (isset($_SESSION['addProductShipment'])) {
            header("location: ../../shipment/add_shipment3.php?idshipment_period=" . $_SESSION['idshipment_period'] . "&idfactory=" . $_SESSION['idfactory'] . "&price=" . $_SESSION['price'] . "&status_shipment=" . $_SESSION['status_shipment'] . "&action=editProduct_orderCompleted");
            unset($_SESSION['ship']);
            unset($_SESSION['addProductShipment']);
            unset($_SESSION['idshipment_period']);
            unset($_SESSION['idfactory']);
            unset($_SESSION['price']);
            unset($_SESSION['status_shipment']);
        } else {
            header("location: ../order.php?p=history_order&action=addError");
        }
    }
} else {
    unset($_SESSION["product"]);
    unset($_SESSION["countProduct"]);
    if (isset($_SESSION['addProductShipment'])) {
        header("location: ../../shipment/add_shipment3.php?idshipment_period=" . $_SESSION['idshipment_period'] . "&idfactory=" . $_SESSION['idfactory'] . "&price=" . $_SESSION['price'] . "&status_shipment=" . $_SESSION['status_shipment'] . "&action=editProduct_orderCompleted");
        unset($_SESSION['ship']);
        unset($_SESSION['addProductShipment']);
        unset($_SESSION['idshipment_period']);
        unset($_SESSION['idfactory']);
        unset($_SESSION['price']);
        unset($_SESSION['status_shipment']);
    } else {
        header("location: ../order.php?p=history_order&action=addErrorNotHaveProduct");
    }
}
unset($_SESSION['idshop']);
unset($_SESSION['date']);
unset($_SESSION['time']);


    