<?php include '../config/connect.php'; ?>
<?php

session_start();
//ตัวกลางที่จะส่งค่าจากหน้าAdd ไปยัง Database รับโดยกดปุ่ม<button type="submit" name="submit">ส่งมา
if (isset($_POST['submit_member'])) {

    $getName = $_POST['name'];
    $getLast = $_POST['lastname'];
    $getUser = $_POST['username'];
    $getPass = $_POST['password'];
    $sql_add = "INSERT INTO member (name, lastname, username,password)
                                                VALUES ('$getName', '$getLast', '$getUser', '$getPass')";

//resetค่าที่เก็บจากformในตอนเพิ่มค่าในpopup_add เพื่อไม่ให้ตอนrefreshแล้วเพิ่มค่าซ้ำในDatabaseอีก
    if ($conn->query($sql_add) === TRUE) {
        header("Location: membership.php");
        setcookie("p", "successfully", time() + 3);
        //echo "New record created successfully";
    } else {
        header("Location: membership.php");
        setcookie("p", "error", time() + 3);
        //echo "Error: " . $sql_add . "<br>" . $conn->error;
    }
}
?>