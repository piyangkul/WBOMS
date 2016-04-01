<?php

require_once dirname(__FILE__) . '/../function/func_addorder.php';
if ($_GET['q'] > 0) {
    $idproduct = $_GET['q'];
    $getUnit = getUnit($idproduct);
    echo "<option>กรุณาเลือกหน่วยขาย</option>";
    foreach ($getUnit as $value) {
        $val_idunit = $value['idunit'];
        $val_name_unit = $value['name_unit'];
        $val_price_unit = $value['price_unit'];
        $val_type_unit = $value['type_unit'];
        $val_idunitsub = $val_idunit + 1;
        echo "<option value={$val_idunit}>{$val_name_unit}</option>";
    }
}
?>
