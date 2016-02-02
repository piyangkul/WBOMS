<?php

require_once dirname(__FILE__) . '/../function/func_member.php';

$idmember = $_GET['idmember'];

$checkDel = delMember($idmember);
if ($checkDel) {
   header("location: ../membership.php?action=delCompleted");
} else {
   header("location: ../membership.php?action=delError");
}