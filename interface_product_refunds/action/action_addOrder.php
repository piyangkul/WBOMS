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
$idshop = $_POST['idshop'];
$date_order = $_POST['date_order'];
$detail_order = $_POST['detail_order'];
$idshipment_period = $_POST['idShipment'];
$totalss = str_replace(",", "", $_POST['totalss']);
//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
$products = $_SESSION["productR"];
//$getIDShipment = getDateShipment();
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
//if (!checkcode($productCode)) {
//echo checkDuplicateProduct($productName, $factoryID);
if (isset($_SESSION["productR"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง
    $idorder = addOrderProductRefunds($idshop, $date_order, $detail_order, $totalss, $idshipment_period);
    echo "idorder=" . $idorder;
    if ($idorder > 0) {
        //$idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
        for ($i = 1; $i <= count($products); $i++) {
            //$under_unit = $units[$i]['under_unit'];
            //$underIdUnit = $idUnit[$under_unit]; 

            $idProduct = $products[$i]['productName'];
            $amount = 1;
            $idunit = $products[$i]['idUnit'];
            $getDiff = getDiffBathaction($idProduct, $idunit);
            foreach ($getDiff as $value) {
                $val_amount_unit = $value['amount_unit'];
                $val_price = $value['price_unit'];
                $amount = $val_amount_unit * $amount;
            }
            $idproduct[$i] = addProductRefunds($idorder, $products[$i]['idUnit'], $products[$i]['AmountProduct'], $products[$i]['price'], $products[$i]['type_factory'], $products[$i]['diff']/$amount);
            echo "555";
        }
        echo "555";
        unset($_SESSION["idshopP"]);
        unset($_SESSION["productR"]);
        unset($_SESSION["countProductR"]);
        header("location: ../product_refunds.php?p=product_refunds&action=addCompleted");
    } else {
        unset($_SESSION["idshopP"]);
        unset($_SESSION["productR"]);
        unset($_SESSION["countProductR"]);
        header("location: ../product_refunds.php?p=product_refunds&action=addError");
    }
} else {
    unset($_SESSION["idshopP"]);
    unset($_SESSION["productR"]);
    unset($_SESSION["countProductR"]);
    header("location: ../product_refunds.php?p=product_refunds&action=addErrorNotHaveProduct");
}


//} else {
//    unset($_SESSION["unit"]);
//    unset($_SESSION["countUnit"]);
//    header("location: ../product.php?p=product&action=addErrorDuplicateCode");
//}
//สิ้นสุดกลุ่มคำสั่งทำอะไร

    