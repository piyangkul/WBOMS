<?php

require_once dirname(__FILE__) . '/../function/func_member.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

$name = $_POST['name_member'];
$lastname = $_POST['lastname_member'];
$username = $_POST['username'];
$password = $_POST['confirm_password'];

if (!checkDuplicateMember($name, $lastname)) {
    $memberID = addMember($name, $lastname, $username, $password, "");
    if ($memberID > 0) {
        header("location: ../membership.php?action=addMemCompleted");
    } else {
        header("location: ../membership.php?action=addMemError");
    }
} else {
    header("location: ../membership.php?action=addMemDuplicateError");
}