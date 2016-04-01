<?php
require_once dirname(__FILE__) . '/../function/func_addorder.php';
if ($_GET['q'] > 0) {
    $idfactory = $_GET['q'];
   
    $row = getProduct($idfactory);
    echo "<option selected value='Choose'>กรุณาเลือกโรงงาน</option>";   
    foreach ($row as $value) {
        $val_idproduct = $value['idproduct'];
        //$val_idfactory = $value['idfactory'];
        $val_name_product = $value['name_product'];
        
       echo "<option value={$val_idproduct}>{$val_name_product}</option>";
    }
}
?>
