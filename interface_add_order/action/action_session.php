<?php

session_start();
if (isset($_GET['idshop'])) {
    $_SESSION['idshop'] = $_GET['idshop'];
}
if (isset($_GET['date'])) {
    $_SESSION['date'] = $_GET['date'];
}
if (isset($_GET['time'])) {
    $_SESSION['time'] = $_GET['time'];
}
if(isset($_GET['detail'])){
    $_SESSION['detail'] = $_GET['detail'];
}

