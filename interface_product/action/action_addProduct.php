<?php

require_once dirname(__FILE__) . '/../function/func_product.php';

session_start();
echo "<pre>";
print_r($_POST);
//print_r($_SESSION);
echo "</pre>";
//กลุ่มรับค่า
//ส่งข้อมูล หน้า add product มาหน้านี้ 
//$productCode = $_POST['productCode'];
$productName = $_POST['productName'];
$factoryID = $_POST['idfactory'];
$productDetail = $_POST['porductDetail'];
$difference_amount = $_POST['difference_amount'];
$bigestPriceResult = $_POST['bigestPriceResult'];
//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
$units = $_SESSION["unit"];
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
//if (!checkcode($productCode)) {
//echo checkDuplicateProduct($productName, $factoryID);
if (isset($_SESSION["unit"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง

    if (!checkDuplicateProduct($productName, $factoryID)) {

        $idproduct = addProduct($factoryID, $productName, $productDetail, $difference_amount); //idproductของระบบ
        echo "idproduct=" . $idproduct;
        if ($idproduct > 0) {
            $idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
            for ($i = 2; $i <= count($units); $i++) {
                $under_unit = $units[$i]['under_unit'];
                $underIdUnit = $idUnit[$under_unit];
                $idUnit[$i] = addUnit($idproduct, $underIdUnit, $units[$i]['AmountPerUnit'], $units[$i]['NameUnit'], $units[$i]['price'], $units[$i]['type']);
            }
            unset($_SESSION["unit"]);
            unset($_SESSION["countUnit"]);
            header("location: ../product.php?p=product&action=addCompleted");
//    echo "finished";
        } else {
            unset($_SESSION["unit"]);
            unset($_SESSION["countUnit"]);
            header("location: ../product.php?p=product&action=addError");
//    echo "error";
        }
    } else {
        unset($_SESSION["unit"]);
        unset($_SESSION["countUnit"]);
        header("location: ../product.php?p=product&action=addErrorDuplicateProduct");
    }
} else {
    unset($_SESSION["unit"]);
    unset($_SESSION["countUnit"]);
    header("location: ../product.php?p=product&action=addErrorNotHaveUnit");
}
//} else {
//    unset($_SESSION["unit"]);
//    unset($_SESSION["countUnit"]);
//    header("location: ../product.php?p=product&action=addErrorDuplicateCode");
//}
//สิ้นสุดกลุ่มคำสั่งทำอะไร
