<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';
if ($_GET['q'] > 0) {
    $idunit = $_GET['q'];
    $row = getUnit_cals($idunit);
    foreach ($row as $value) {
        $val = $value['name_unit'];
        $val_price = $value['price_unit'];

        echo $val_price;
        
    }
}
?>