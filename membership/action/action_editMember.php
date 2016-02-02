<?php

require_once dirname(__FILE__) . '/../function/func_member.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idmember = $_GET['idmember'];
$name = $_POST['name_member'];
$lastname = $_POST['lastname_member'];
$password = $_POST['confirm_password'];

if (!checkDuplicateMember($name, $lastname)) {
    $checkEdit = editMember($name, $lastname, $password, "", $idmember);
    if ($checkEdit) {
        header("location: ../membership.php?action=editMemCompleted");
    } else {
        header("location: ../membership.php?action=editMemError");
    }
} else {
    header("location: ../membership.php?action=editMemDuplicateError");
}