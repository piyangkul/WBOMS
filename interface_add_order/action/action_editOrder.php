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
$idorder = $_GET['idorder'];
$code_order = $_POST['code_order'];
//$idshop = $_POST['idshop'];
$date_order = $_POST['date_order'];
$time_order = $_POST['time_order'];
$detail_order = $_POST['detail_order'];
//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
$products = $_SESSION["editproduct"];
$productsE = $_SESSION["editproductE"];
$productsD = $_SESSION["editproductD"];

$editOrder = editOrder($idorder, $code_order, $date_order, $time_order, $detail_order); //idproductของระบบ
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
//if (!checkcode($productCode)) {
//echo checkDuplicateProduct($productName, $factoryID);
if (isset($_SESSION["editproduct"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง
    echo "idorder=" . $idorder;
    if ($idorder > 0) {
        //$idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
        for ($i = 1; $i <= count($products); $i++) {
            //$under_unit = $units[$i]['under_unit'];
            //$underIdUnit = $idUnit[$under_unit]; 
            if ($products[$i]['type'] === "PERCENT") {
                $idproduct[$i] = addProductOrder($products[$i]['idUnit'], $idorder, $products[$i]['AmountProduct'], $products[$i]['DifferencePer'], $products[$i]['type'], $products[$i]['price']);
            }
            if ($products[$i]['type'] === "BATH") {
                $idproduct[$i] = addProductOrder($products[$i]['idUnit'], $idorder, $products[$i]['AmountProduct'], $products[$i]['DifferenceBATH'], $products[$i]['type'], $products[$i]['price']);
            }
            //$idUnit[$i] = addUnit($idshop, $underIdUnit, $units[$i]['AmountPerUnit'], $units[$i]['NameUnit'], $units[$i]['price'], $units[$i]['type']);
            //echo $products[$i]['idUnit'];
            //echo $products[$i]['type'];
        }

        unset($_SESSION["editproduct"]);
        unset($_SESSION["editcountProduct"]);
        //header("location: ../order.php?p=product&action=editCompleted");
    } else {
        unset($_SESSION["editproduct"]);
        unset($_SESSION["editcountProduct"]);
        // header("location: ../order.php?p=product&action=editError");
    }
} else {
    unset($_SESSION["editproduct"]);
    unset($_SESSION["editcountProduct"]);
    //header("location: ../add_order.php?p=product&action=addErrorNotHaveUnit");
}
/*
  if (isset($_SESSION["editproductE"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง
  echo "idorder=" . $idorder;
  if ($idorder > 0) {
  //$idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
  for ($i = 1; $i <= count($productsE); $i++) {
  //$under_unit = $units[$i]['under_unit'];
  //$underIdUnit = $idUnit[$under_unit];
  $idproductE[$i] = EditProductOrder($productsE[$i]['idproduct_order'], $productsE[$i]['idUnit'], $productsE[$i]['AmountProduct'], $productsE[$i]['DifferencePer'], $productsE[$i]['type'], $productsE[$i]['total_price']);
  //$idUnit[$i] = addUnit($idshop, $underIdUnit, $units[$i]['AmountPerUnit'], $units[$i]['NameUnit'], $units[$i]['price'], $units[$i]['type']);
  }
  unset($_SESSION["editproductE"]);
  unset($_SESSION["editcountProductE"]);
  //header("location: ../order.php?p=product&action=editCompleted"); */
/* }else {
  unset($_SESSION["editproductE"]);
  unset($_SESSION["editcountProductE"]);
  // header("location: ../order.php?p=product&action=editError");
  }
  } else {
  unset($_SESSION["editproductE"]);
  unset($_SESSION["editcountProductE"]);
  // header("location: ../add_order.php?p=product&action=addErrorNotHaveUnit");
  } */
/*
  if (isset($_SESSION["editproductD"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง
  echo "idorder=" . $idorder;
  if ($idorder > 0) {
  //$idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
  for ($i = 1; $i <= count($productsD); $i++) {
  //$under_unit = $units[$i]['under_unit'];
  //$underIdUnit = $idUnit[$under_unit];
  $idproductE[$i] = deleteProductOrder($productsD[$i]['idproduct_order']);
  //$idUnit[$i] = addUnit($idshop, $underIdUnit, $units[$i]['AmountPerUnit'], $units[$i]['NameUnit'], $units[$i]['price'], $units[$i]['type']);
  }
  unset($_SESSION["editproductD"]);
  unset($_SESSION["editcountProductD"]);
  //header("location: ../order.php?p=product&action=editCompleted"); */
// } /*else {
/* unset($_SESSION["editproductD"]);
  unset($_SESSION["editcountProductD"]);
  // header("location: ../order.php?p=product&action=editError");
  }
  } /*else {
  unset($_SESSION["editproductD"]);
  unset($_SESSION["editcountProductD"]);
  // header("location: ../add_order.php?p=product&action=addErrorNotHaveUnit");
  }
 */
header("location: ../order.php?p=product&action=editCompleted");
