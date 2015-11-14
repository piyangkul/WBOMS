<?php
session_start();
require '../model/db_user.inc.php';

if (isset($_POST['name_shop_add'])) {
    $getName_shop_add = $_POST['name_shop_add'];
    $getTel_shop_add = $_POST['tel_shop_add'];
    $getAddress_shop_add = $_POST['address_shop_add'];
    $getIDProvince_shop_add = $_POST['idprovince_shop_add'];
    $getDetail_shop_add = $_POST['detail_shop_add'];

    $res_shop_add = add_shop($getName_shop_add, $getIDProvince_shop_add, $getTel_shop_add, $getAddress_shop_add, $getDetail_shop_add);

    if ($res_shop_add == true) {
        header("Location: shop.php");
        ?><script> alert("เพิ่มร้านค้าสำเร็จ");</script> <?php
        setcookie("k", "successfully", time() + 3);
    } else {
        echo "Failed";
    }
} elseif (isset($_POST['name_shop_edit'])) {
    $getID_shop_edit = $_POST['idshop_edit'];
    $getName_shop_edit = $_POST['name_shop_edit'];
    $getTel_shop_edit = $_POST['tel_shop_edit'];
    $getAddress_shop_edit = $_POST['address_shop_edit'];
    $getIDProvince_shop_edit = $_POST['idprovince_shop_edit'];
    $getDetail_shop_edit = $_POST['detail_shop_edit'];

    $res_shop_edit = edit_shop($getName_shop_edit, $getIDProvince_shop_edit, $getTel_shop_edit, $getAddress_shop_edit, $getDetail_shop_edit, $getID_shop_edit);
    if ($res_shop_edit == true) {
        header("Location: shop.php");
        ?><script> alert("แก้ไขร่านค้าสำเร็จ");</script> <?php
        setcookie("k", "successfully", time() + 3);
//echo "New record created successfully";
    } else {
        echo "Failed";
        echo $getName_shop_edit, " ", $getIDProvince_shop_edit, " ", $getTel_shop_edit, " ", $getAddress_shop_edit, " ", $getDetail_shop_edit, " ", $getID_shop_edit;
    }
} elseif (isset($_GET['idshop'])) {
    $getIDshop_delete = $_GET['idshop'];

    $res_delete = del_shop($getIDshop_delete);

//resetค่าที่เก็บจากformในตอนเพิ่มค่าในpopup_add เพื่อไม่ให้ตอนrefreshแล้วเพิ่มค่าซ้ำในDatabaseอีก
    if ($res_delete == true) {
        header("Location: shop.php");
        ?><script> alert("แก้ไขร้านค้าสำเร็จ");</script> <?php
        setcookie("k", "successfully", time() + 3);
//echo "New record created successfully";
    } else {
        echo $getIDfactory_delete;
        echo "zzzz";
    }
}

