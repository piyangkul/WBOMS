<?php

require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();
if ($_GET['p'] == "delProduct") {
    $product_order = $_GET['idproduct_order'];
    $count = $_SESSION["countProductR"];
    $_SESSION["countProductR"] -= 1;
    for ($i = $product_order; $i < $count; $i++) {
        $_SESSION["productR"][$i]["idUnit"] = $_SESSION["productR"][$i + 1]["idUnit"];
        $_SESSION["productR"][$i]["productName"] = $_SESSION["productR"][$i + 1]["productName"];
        $_SESSION["productR"][$i]["factoryName"] = $_SESSION["productR"][$i + 1]["factoryName"];
        $_SESSION["productR"][$i]["AmountProduct"] = $_SESSION["productR"][$i + 1]["AmountProduct"];
        $_SESSION["productR"][$i]["price"] = $_SESSION["productR"][$i + 1]["price"];
        $_SESSION["productR"][$i]["total_price"] = $_SESSION["productR"][$i + 1]["total_price"];
        $_SESSION["productR"][$i]["diff"] = $diff;
        $_SESSION["productR"][$i]["price_factory"] = $price_factory;
        $_SESSION["productR"][$i]["type_factory"] = $type_factory;
    }


    unset($_SESSION["productR"][$count]);
    echo "1";
}

 /*
        $_SESSION["product"][$i]["idUnit"] = $_SESSION["product"][$i + 1]["idUnit"];
        $_SESSION["product"][$i]["productName"] = $_SESSION["product"][$i + 1]["productName"];
        $_SESSION["product"][$i]["factoryName"] = $_SESSION["product"][$i + 1]["factoryName"];
        $_SESSION["product"][$i]["AmountProduct"] = $_SESSION["product"][$i + 1]["AmountProduct"];
        $_SESSION["product"][$i]["difference"] = $_SESSION["product"][$i + 1]["difference"];
        $_SESSION["product"][$i]["DifferencePer"] = $_SESSION["product"][$i + 1]["DifferencePer"];
        $_SESSION["product"][$i]["DifferenceBath"] = $_SESSION["product"][$i + 1]["DifferenceBath"];
        $_SESSION["product"][$i]["price"] = $_SESSION["product"][$i + 1]["price"];
        $_SESSION["product"][$i]["total_price"] = $_SESSION["product"][$i + 1]["total_price"];
        $_SESSION["product"][$i]["total"] = $_SESSION["product"][$i + 1]["total"];
        $_SESSION["product"][$i]["type"] = $_SESSION["product"][$i + 1]["type"];
*/