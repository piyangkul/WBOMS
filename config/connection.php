<?php
$host = "localhost";
$user = "root";
$pass = "1111";
$db = "project";
$objConnect = mysql_connect($host,$user,$pass)or die("Error:". mysql_error());
$select_db = mysql_select_db($db)or die("Error:". mysql_error());
mysql_query("SET character_set_results=tis620");//ตั้งค่าการดึงข้อมูลออกมาให้เป็นภาษาไทย
mysql_query("SET character_set_client=tis620");//ตั้งค่าการส่งข้อมุลลงฐานข้อมูลออกมาให้ เป็น ภาษาไทย
mysql_query("SET character_set_connection=tis620");//ตั้งค่าการติดต่อฐานข้อมูลให้เป็น ภาษาไทย
?>