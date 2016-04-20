<?php

session_start();
require_once dirname(__FILE__) . '/../function/func_addorder.php';
if (isset($_GET['idshop'])) {
    $_SESSION['idshopP'] = $_GET['idshop'];
    if (isset($_SESSION["countProductR"])) {
        $count = $_SESSION["countProductR"];
        for ($i = 1; $i <= $count; $i++) {

            $idshop = $_SESSION['idshopP'];
            $price_factory = $_SESSION["productR"][$i]["price_factory"];
            $amount = $_SESSION["productR"][$i]["AmountProduct"];
            $idproduct = $_SESSION["productR"][$i]["productName"];
            $total_price = $_SESSION["productR"][$i]["total_price"];
            $diff = $_SESSION["productR"][$i]["diff"];
            $type = $_SESSION["productR"][$i]["type_factory"];

            $row = hisDiff($idproduct, $idshop);
            $price_diff = $row['price_difference'];

            if (isset($price_diff)) {
                if ($type === "PERCENT") {
                    $_SESSION["productR"][$i]["price"] = $price_factory - ($price_factory * ($price_diff / 100));
                    $_SESSION["productR"][$i]["total_price"] = ($price_factory - ($price_factory * ($price_diff / 100))) * $amount;
                    $_SESSION["productR"][$i]["diff"] = $price_diff;
                } else {
                    $_SESSION["productR"][$i]["price"] = ($price_factory * 1) + ($price_diff * 1);
                    $_SESSION["productR"][$i]["total_price"] = ($price_factory * $amount) + ($price_diff * $amount);
                    $_SESSION["productR"][$i]["diff"] = $price_diff;
                }
            } else {
                $getDiffProduct = getDiffProduct($idproduct);
                $diffProduct = $getDiffProduct['difference_amount_product'];
                if ($type === "PERCENT") {
                    $_SESSION["productR"][$i]["price"] = $price_factory - ($price_factory * ($diffProduct / 100));
                    $_SESSION["productR"][$i]["total_price"] = ($price_factory - ($price_factory * ($diffProduct / 100))) * $amount;
                    $_SESSION["productR"][$i]["diff"] = $diffProduct;
                } else {
                    $_SESSION["productR"][$i]["price"] = ($price_factory * 1) + ($diffProduct * 1);
                    $_SESSION["productR"][$i]["total_price"] = ($price_factory * $amount) + ($diffProduct * $amount);
                    $_SESSION["productR"][$i]["diff"] = $diffProduct;
                }
            }
        }
    }
}
    
