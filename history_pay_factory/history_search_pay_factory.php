<?php
require_once 'function/func_history_pay_factory.php';
$get_searchFactory = $_GET['searchFactory'];
$getFactoryByName = getFactoryByName($get_searchFactory);
foreach ($getFactoryByName as $value) {

    //$val_shipment_period_idshipment = $value['shipment_period_idshipment'];
    $val_idfactory = $value['idfactory'];
    $val_name_factory = $value['name_factory'];
    $val_code_factory = $value['code_factory'];
    //$val_idpay_factory = $value['idpay_factory'];
    
    ?>
    <option value="<?php echo $val_idfactory; ?>"><?php echo "[$val_code_factory] - $val_name_factory"; ?></option>
<?php } ?>
<!--<option value="<?php //echo $val_idfactory; ?>"><?php //echo "[$val_code_factory] $val_name_product - $val_name_factory"; ?></option>-->