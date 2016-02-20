<?php

require_once dirname(__FILE__) . '/../function/func_factory.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idfactory = $_GET['idfactory'];
$code_factory = $_POST['code_factory'];
$name_factory = $_POST['name_factory'];
$tel_factory = $_POST['tel_factory'];
$address_factory = $_POST['address_factory'];
$contact_factory = $_POST['contact_factory'];
$difference_amount_factory = $_POST['difference_amount_factory'];
$detail_factory = $_POST['detail_factory'];


$checkEditFactory = editFactory($code_factory, $name_factory, $tel_factory, $address_factory, $contact_factory, $difference_amount_factory, $detail_factory ,$idfactory);
//print_r($checkEditFactory);
if ($checkEditFactory) {
    header("location: ../factory.php?p=factory&action=editFactoryCompleted");
} else {
    header("location: ../factory.php?p=factory&action=editFactoryError");
}

