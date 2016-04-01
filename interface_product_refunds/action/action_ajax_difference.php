<?php
require_once dirname(__FILE__) . '/../function/func_addorder.php';
if ($_GET['q'] > 0) {
    $idfactory = $_GET['q'];
   
    $row = getDifference($idfactory);
    foreach ($row as $value) {
        $val_idfactory = $value['idfactory'];
        //$val_idfactory = $value['idfactory'];
        $val_difference_amount_factory = $value['difference_amount_factory'];
        echo $val_difference_amount_factory ;
    }
}
?>
