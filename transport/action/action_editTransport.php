<?php

require_once dirname(__FILE__) . '/../function/func_transport.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idtransport = $_GET['idtransport'];
$code_transport = $_POST['code_transport'];
$name_transport = $_POST['name_transport'];
$tel_transport = $_POST['tel_transport'];
$address_transport = $_POST['address_transport'];

//if (!checkDuplicateTranport($name_transport, $code_transport)) {
$checkEditTransport = editTransport($code_transport, $name_transport, $tel_transport, $address_transport, $idtransport);
if ($checkEditTransport) {
    header("location: ../transport.php?action=editTransportCompleted");
} else {
    header("location: ../transport.php?action=editTransportError");
}
//}
//else {
//    header("location: ../transport.php?action=editTransportDuplicateError");
//}