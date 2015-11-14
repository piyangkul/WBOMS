<?php

require_once 'db_connect.inc.php';

//Member

function get_member() {
    global $con;
    $res = $con->query("SELECT * FROM member");
    return $res;
}

function get_member_id($idmember) {
    global $con;
    $res = $con->query("SELECT * FROM member WHERE idmember = '$idmember'");
    return $res;
}

function add_member($getName, $getLastname, $getUsername, $getPassword) {
    global $con;
    $res = $con->exec("INSERT INTO member (name,lastname,username,password)
               VALUES ('$getName', '$getLastname', '$getUsername','$getPassword')");
    return $res;
}

function edit_member($getid,$getPassword,$getName,$getLastname) {
    global $con;
    $res = $con->exec("UPDATE member SET password='$getPassword', name = '$getName',lastname = '$getLastname' WHERE idmember = '$getid'");
    return $res;
}

function del_member($getid) {
    global $con ;
    $res = $con->query("DELETE FROM member WHERE idmember = '$getid'") ;
    return $res ;
}


//Factory

function get_factory() {

    global $con;
    $res = $con->query("SELECT *FROM factory");
    return $res;
}

function add_factory($getName, $getTel, $getAddress, $getContact, $getDiff, $getDetail) {

    global $con;
    $res = $con->exec("INSERT INTO factory (name_factory,tel_factory,address_factory,contact_factory,difference_amount_factory,detail_factory)
                VALUES ('$getName','$getTel','$getAddress','$getContact','$getDiff','$getDetail')");
    return $res;
}

function edit_factory() {
    
}

function del_factory() {
    
}

//Shop
//Shop
function get_shop() {
    global $con;
    $res = $con->query("SELECT *FROM shop INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON region.idregion = province.idregion");
    return $res;
}

function get_shop_id($idshop) {
    global $con;
    $res = $con->query("SELECT * FROM shop where idshop = '$idshop'");
    return $res;
}

function add_shop($getName, $getIDProvince, $getTel, $getAddress, $getDetail) {
    global $con;
    $res = $con->exec("INSERT INTO shop (name_shop,idprovince,tel_shop,address_shop,detail_shop)
        VALUE('$getName','$getIDProvince','$getTel','$getAddress','$getDetail')");
    return exec;
}

function edit_shop($getName, $getIDProvince, $getTel, $getAddress, $getDetail, $getIDshop) {
    global $con;
    $res = $con->exec("UPDATE shop SET  name_shop='$getName',idprovince = '$getIDProvince' , tel_shop='$getTel',address_shop='$getAddress',detail_shop='$getDetail'
                WHERE idshop = '$getIDshop'");
    return $res;
}

function del_shop($getIDshop) {
    global $con;
    $res = $con->query("DELETE FROM shop WHERE idshop = '$getIDshop'");
    return $res;
}
//province and region
function get_province($getIDregion){
    global $con;
    $res = $con->query("SELECT * FROM province WHERE idregion = '$getIDregion'");
    return $res;
}

function get_region(){
    global $con;
    $res = $con->query("SELECT * FROM region");
    return $res;
}
