<?php

session_start();
if (isset($_GET['idshop'])) {
    $_SESSION['idshopP'] = $_GET['idshop'];
}
    
