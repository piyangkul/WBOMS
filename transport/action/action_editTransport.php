<?php

require_once dirname(__FILE__) . '/../function/func_transport.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idtransport = $_GET['idtransport'];
$name_transport = $_POST['name_transport'];
$tel_transport = $_POST['tel_transport'];
$address_transport = $_POST['address_transport'];

$checkEditTransport = editTransport($idtransport, $name_transport, $tel_transport, $address_transport);
if ($checkEditTransport) {
 //   header("location: ../transport.php?action=editCompleted");
} else {
  //  header("location: ../transport.php?action=editError");
}