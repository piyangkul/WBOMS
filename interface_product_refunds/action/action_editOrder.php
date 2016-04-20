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
$date_product_refunds = $_POST['date_order'];
$detail_product_refunds = $_POST['detail_order'];
$total_price_all = 0;

$total = str_replace(",","",$_POST['total_price_all']);
$total_price_all += $total;

//ส่งข้อมูล หน่วยสินค้า มาหน้านี้
$products = $_SESSION["editproductR"];

$editOrder = editOrderRefunds($idorder, $date_product_refunds, $detail_product_refunds,$total_price_all); //idproductของระบบ
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
//if (!checkcode($productCode)) {
//echo checkDuplicateProduct($productName, $factoryID);
/*if (isset($_SESSION["editproductR"])) {//ถามว่า$_SESSION["unit"]ถูกสร้างหรือยัง
    echo "idorder=" . $idorder;
    if ($idorder > 0) {
        //$idUnit[1] = addUnit($idproduct, 0, $units[1]['AmountPerUnit'], $units[1]['NameUnit'], $units[1]['price'], $units[1]['type']);
        for ($i = 1; $i <= count($products); $i++) {
          //  $idproduct[$i] = addProductRefunds($idorder, $products[$i]['idUnit'], $products[$i]['AmountProduct'], $products[$i]['price']);
            //$total_price_all += $products[$i]['price'];
        }
        //echo $total_price_all;
        unset($_SESSION["editproductR"]);
        unset($_SESSION["editcountProductR"]);
        header("location: ../product_refunds.php?p=product&action=editCompleted");
    } else {
        unset($_SESSION["editproductR"]);
        unset($_SESSION["editcountProductR"]);
        header("location: ../product_refunds.php?p=product&action=editError");
    }
} else {
    unset($_SESSION["editproductR"]);
    unset($_SESSION["editcountProductR"]);
    header("location: ../product_refunds.php?p=product&action=addErrorNotHaveUnit");
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
//header("location: ../product_refunds.php?p=product&action=editCompleted");
