<?php
require_once dirname(__FILE__) . '/../function/func_product.php';

session_start();
echo "<pre>";
print_r($_POST);
print_r($_SESSION["unit"]);
echo "</pre>";