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
$totalss = $_POST['totalss'];
//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
$products = $_SESSION["productR"];
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
//if (!checkcode($productCode)) {
//echo checkDuplicateProduct($productName, $factoryID);
if (isset($_SESSION["productR"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง
    $idorder = addOrderProductRefunds($idshop, $date_order, $detail_order,$totalss);
    echo "idorder=" . $idorder;
    if ($idorder > 0) {
        //$idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
        for ($i = 1; $i <= count($products); $i++) {
            //$under_unit = $units[$i]['under_unit'];
            //$underIdUnit = $idUnit[$under_unit]; 
            $idproduct[$i] = addProductRefunds($idorder,$products[$i]['idUnit'], $products[$i]['AmountProduct'],$products[$i]['price']);
            echo "555";
            //$idUnit[$i] = addUnit($idshop, $underIdUnit, $units[$i]['AmountPerUnit'], $units[$i]['NameUnit'], $units[$i]['price'], $units[$i]['type']);
        }
        echo "555";
        unset($_SESSION["productR"]);
        unset($_SESSION["countProductR"]);
        header("location: ../product_refunds.php?p=product&action=addCompleted");
    } else {
        unset($_SESSION["productR"]);
        unset($_SESSION["countProductR"]);
        header("location: ../product_refunds.php?p=product&action=addError");
    }
} else {
    unset($_SESSION["productR"]);
    unset($_SESSION["countProductR"]);   
    header("location: ../product_refunds.php?p=product&action=addErrorNotHaveProduct");
}


//} else {
//    unset($_SESSION["unit"]);
//    unset($_SESSION["countUnit"]);
//    header("location: ../product.php?p=product&action=addErrorDuplicateCode");
//}
//สิ้นสุดกลุ่มคำสั่งทำอะไร

    