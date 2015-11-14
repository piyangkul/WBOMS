<?php

require_once dirname(__FILE__) . '/../function/func_member.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

$name = $_POST['name_member'];
$lastname_member = $_POST['lastname_member'];
$username = $_POST['username'];
$password = $_POST['confirm_password'];


$memberID=addMember($name, $lastname_member, $username, $password, "");
if($memberID>0){
    header("location: ../membership.php?action=completed");
}
 else {
    header("location: ../membership.php?action=error");
}