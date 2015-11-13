<?php include '../config/connect.php'; ?>
<?php
session_start();
//ตัวกลางที่จะส่งค่าจากหน้าAdd ไปยัง Database รับโดยกดปุ่ม<button type="submit" name="submit">ส่งมา
if (isset($_POST['submit_factory'])) {

    $getName = $_POST['name_factory'];
    $getTel = $_POST['tel'];
    $getAddress = $_POST['address'];
    $getContact = $_POST['contact'];
    $getDiff = $_POST['difference_amount'];
    $getDetail = $_POST['detail_factory'];
    $sql_add = "INSERT INTO factory (name_factory, tel_factory, address_factory,contact_factory,difference_amount_factory,detail_factory)
                                                VALUES ('$getName', '$getTel', '$getAddress','$getContact','$getDiff','$getDetail')";

//resetค่าที่เก็บจากformในตอนเพิ่มค่าในpopup_add เพื่อไม่ให้ตอนrefreshแล้วเพิ่มค่าซ้ำในDatabaseอีก
    if ($conn->query($sql_add) === TRUE) {
        header("Location: factory.php");
        setcookie("p", "successfully", time() + 3);
        //echo "New record created successfully";
    } else {
        header("Location: factory.php");
        setcookie("p", "error", time() + 3);
        //echo "Error: " . $sql_add . "<br>" . $conn->error;
    }
}
?>