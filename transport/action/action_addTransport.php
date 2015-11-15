<?php

require_once dirname(__FILE__) . '/../function/func_transport.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

$code_transport = $_POST['code_transport'];
$name_transport = $_POST['name_transport'];
$tel_transport = $_POST['tel_transport'];
$address_transport = $_POST['address_transport'];


$transportID = addTransport($code_transport, $name_transport, $tel_transport, $address_transport);
if ($transportID > 0) {
    header("location: ../transport.php?action=addCompleted");
} else {
    header("location: ../transport.php?action=addError");
}