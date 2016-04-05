<?php

require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();
$z = 1;
//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idorder = $_GET['idorder'];
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $price = $_GET['price'];
    $total_price = $_GET['total_price'];
    $total_price_all = $_GET['total_price_all'];




    /*  if (isset($_SESSION["editcountProductR"])) {
      $_SESSION["editcountProductR"] ++;
      } else
      $_SESSION["editcountProductR"] = 1;
      $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["idUnit"] = $idUnit;
      $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["productName"] = $productName;
      $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["factoryName"] = $factoryName;
      $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["AmountProduct"] = $AmountProduct;
      $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["price"] = $price;
      $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["total_price"] = $total_price; */

    $idproduct = addProductRefunds($idorder, $idUnit, $AmountProduct, $price);
    $Edit = editTotal_order($idorder, $total_price_all);
    header("location: ../edit_product_refunds.php");
    echo "1";
}
?>