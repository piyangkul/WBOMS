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
$code_order = $_POST['code_order'];
$idshop = $_POST['idshop'];
$date_order = $_POST['date_order'];
$time_order = "08:29:00";
$detail_order = $_POST['detail_order'];
//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
$products = $_SESSION["product"];
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
            $idproduct[$i] = addProductOrder($products[$i]['idUnit'], $idorder, $products[$i]['AmountProduct'], $products[$i]['DifferencePer'], $products[$i]['type']);
            
            //$idUnit[$i] = addUnit($idshop, $underIdUnit, $units[$i]['AmountPerUnit'], $units[$i]['NameUnit'], $units[$i]['price'], $units[$i]['type']);
            echo $products[$i]['idUnit'];
            echo $products[$i]['type'];
        }
        echo "5555";
    } else {
        unset($_SESSION["product"]);
        unset($_SESSION["countProduct"]);
        header("location: ../add_order.php?p=product&action=addErrorDuplicateProduct");
    }
} else {
    unset($_SESSION["product"]);
    unset($_SESSION["countProduct"]);
    header("location: ../add_order.php?p=product&action=addErrorNotHaveUnit");
}
//} else {
//    unset($_SESSION["unit"]);
//    unset($_SESSION["countUnit"]);
//    header("location: ../product.php?p=product&action=addErrorDuplicateCode");
//}
//สิ้นสุดกลุ่มคำสั่งทำอะไร

    