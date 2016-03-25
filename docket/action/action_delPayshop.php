<?php
require_once dirname(__FILE__) . '/../function/func_docket.php';

echo '<pre>';
print_r($_POST);
print_r($_GET);
echo '</pre>';

$idshipment_period = $_GET['idshipment_period'];
$idshop = $_GET['idshop'];

$delPayshop = delPayshop($idshipment_period,$idshop);
if ($delPayshop) {
    header("location: ../docket.php?idshop=$idshop&action=delPayshopCompleted");
} else {
    header("location: ../docket.php?idshop=$idshop&action=delPayshopError");
}
