﻿<?php
session_start();
if (!isset($_SESSION['username']))
    header('Location: ../index.php');

$p = 'product';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>THIP WAREE Project</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- MORRIS CHART STYLES-->
        <link href="../assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="../assets/css/custom.css" rel="stylesheet" />
    </head>
    <body>
        <div id="wrapper">
            <!--  NAV TOP  -->
            <?php include '../interface_template/template_nav_top.php'; ?>  

            <!--  NAV SIDE  -->
            <?php include '../interface_template/template_nav_side.php'; ?>

            <!--  CONNECT DATABASE  -->
            <?php include '../config/connect.php'; ?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2> Product </h2>   
                            <h5> สินค้า </h5>

                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />

                    <div class="row">
                        <div class="col-md-12">
                            <a href="add_product.php" class="btn btn-info btn-lg">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มสินค้า
                            </a>
                            <br/><br/>
                            <a href="popup_product_detail.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-plus"></span> รายละเอียด
                            </a>
                            <!-- ตารางสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    ตารางสินค้า
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">รหัสสินค้า</div></th>
                                                    <th><div align="center">ชื่อสินค้า</div></th>
                                                    <th><div align="center">ชื่อโรงงาน</div></th>
                                                    <th><div align="center">หน่วยสินค้า</div></th>
                                                    <th><div align="center">ราคาเปิด</div></th>
                                                    <th><div align="center">ต้นทุนลด</div></th>
                                                    <th><div align="center">หน่วยลด</div></th>
                                                    <th><div align="center">ราคาต้นทุน</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //$sql = "SELECT idproduct ,code_product,name_product,name_factory,price_product,amount_product,type_product,(price_product * amount_product / 100)AS A FROM product INNER JOIN  factory ON product.factory_id_factory = factory.id_factory;";
                                                //$result = $conn->query($sql);

//                                                if ($result->num_rows > 0) {
//                                                    // output data of each row
//                                                    while ($row = $result->fetch_assoc()) {
//                                                        echo "<tr><td>" . $row["idproduct"] . "</td><td>" . $row["code_product"] . "</td><td>" . $row["name_product"] . "</td><td>" . $row["name_factory"] . "</td><td>" . $row["price_product"] . "</td><td>" . $row["amount_product"] . "</td><td>" . $row["type_product"] . "</td>";
//                                                        if ($row["type_product"] == "PERCENT") {
//                                                            echo "<td>" . $row["A"] . "</td>";
//                                                        } else if ($row["type_product"] == "NON") {
//                                                            echo "<td>" . $row["price_product"] . "</td>";
//                                                        }
//                                                        echo '<td>                                                           
//                                                                <a href="popup_product_detail.php" class="btn btn-success" data-toggle="modal" data-target="#myModal">
//                                                                    <span class="glyphicon glyphicon-list-alt"></span>
//                                                                </a>
//
//                                                                <a href="edit_product.php" class="btn btn-warning " >
//                                                                    <span class="glyphicon glyphicon-edit"></span>
//                                                                </a>
//                                                                
//                                                                <a href="#" class="btn btn-danger " data-toggle="modal" data-target="#myModal">
//                                                                    <span class="glyphicon glyphicon-trash"></span>
//                                                                </a>
//                                                                
//                                                            </td></tr>';
//                                                    }
//                                                }
                                                ?>
                                                <tr>
                                                    <td>1</td>
                                                    <td>A001</td>
                                                    <td>เยลลี่ 5 บาท</td>
                                                    <td>A</td>
                                                    <td>มัด</td>
                                                    <td>560</td>
                                                    <td>10</td>
                                                    <td>%</td>
                                                    <td>504</td>
                                                    <td> 
                                                        <a href="popup_product_detail.php" class="btn btn-success" data-toggle="modal" data-target="#myModal1">
                                                            <span class="glyphicon glyphicon-list-alt"></span>
                                                        </a>

                                                        <a href="edit_product.php" class="btn btn-warning " >
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </a>
                                                        <a href="popup_delete_product.php" class="btn btn-danger " data-toggle="modal" data-target="#myModal">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>B001</td>
                                                    <td>เยลลี่ 5 บาท</td>
                                                    <td>B</td>
                                                    <td>กล่อง</td>
                                                    <td>280</td>
                                                    <td>10</td>
                                                    <td>%</td>
                                                    <td>252</td>
                                                    <td> 
                                                        <a class="btn btn-success"  href="#" role="button">รายละเอียด</a>
                                                        <a class="btn btn-warning"  href="#" role="button">แก้ไข</a>
                                                        <a class="btn btn-danger"  href="#" role="button">ลบ</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>C001</td>
                                                    <td>เยลลี่ 5 บาท</td>
                                                    <td>C</td>
                                                    <td>กล่อง</td>
                                                    <td>280</td>
                                                    <td>40</td>
                                                    <td>บาท</td>
                                                    <td>240</td>
                                                    <td> 
                                                        <a class="btn btn-success"  href="#" role="button">รายละเอียด</a>

                                                        <a class="btn btn-warning"  href="#" role="button">แก้ไข</a>
                                                        <a class="btn btn-danger"  href="#" role="button">ลบ</a>
                                                    </td>
                                                </tr>
                                        </table>

                                    </div>

                                </div>
                            </div>
                            <!--End Advanced Tables -->
                        </div>
                    </div>

                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. WRAPPER  -->
        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
        </script>

    </body>
</html>

<div class="modal fade" id="myModal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content -->
        </div>
    </div>
</div>