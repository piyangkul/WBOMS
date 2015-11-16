<?php

require_once dirname(__FILE__) . '/../function/func_member.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idmember = $_GET['idmember'];
$name = $_POST['name_member'];
$lastname_member = $_POST['lastname_member'];
$password = $_POST['confirm_password'];

$checkEdit = editMember($name, $lastname_member,$password, "", $idmember);
if ($checkEdit) {
    header("location: ../membership.php?action=editCompleted");
} else {
    header("location: ../membership.php?action=editError");
}