<?php

require_once dirname(__FILE__) . '/../function/func_product.php';
require_once dirname(__FILE__) . '/../../interface_factory/function/func_factory.php';

$idfactory = $_GET['idfactory'];

$getFactory = getFactoryByID($idfactory);

echo $getFactory['difference_amount_factory'];