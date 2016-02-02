<?php

require_once dirname(__FILE__) . '/../function/func_login.php';
session_start();

$checkLogout = logout();
if ($checkLogout) {
    header('Location: ../../index.php?action=logoutCompleted');
} else {
    header('Location: ../../index.php??action=logoutError');
}