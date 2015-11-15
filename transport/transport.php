<?php
require '../model/db_user.inc.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'transport';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
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

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2> Transport </h2>   
                            <h5> จัดการขนส่ง </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <a href="popup_add_transport.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มขนส่ง
                            </a>

                            <br/>
                            <br/>
                            <?php
                            //การแสดงผลตอบสนองการเพิ่ม
                            /* if (isset($_COOKIE['p']) && $_COOKIE['p'] == "successfully")
                              echo "<center><h4>คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>";
                              else if (isset($_COOKIE['p']) && $_COOKIE['p'] == "error")
                              echo "<center><h4>ผิดพลาด!! ไม่สามารถเพิ่มได้ </h4></center>"; */
                            ?>

                            <span>
                                <?php
                                if (isset($_REQUEST['del_id'])) {
                                    $getid = $_POST['del_id'];
                                    $countd = del_member($getid);
                                    if ($countd === false) {
                                        die(print_r($con->errorInfo(), true));
                                    } else {
                                        echo $countd . " rows Del <br/>";
                                    }
                                }

                                if (isset($_REQUEST['sumbit']) && $_REQUEST['sumbit'] == "addMem") {//แต่ละช่องมีค่าใช่ไหม และมากจากปุ่มadd
                                    $getName = $_POST['name_member'];
                                    $getLastname = $_POST['lastname_member'];
                                    $getUsername = $_POST['username'];
                                    $getPassword = $_POST['password'];
                                    $count = add_member($getName, $getLastname, $getUsername, $getPassword);

                                    if ($count === false) {
                                        die(print_r($con->errorInfo(), true));
                                    } else {
                                        ?>

                                        <?php
                                        echo "<center><h4>คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>";
                                    }
                                }

                                if (isset($_REQUEST['sumbit']) && $_REQUEST['sumbit'] == "updateMem") {//แต่ละช่องมีค่าใช่ไหม และมากจากปุ่มupdate
                                    $getName = $_POST['name_member'];
                                    $getLastname = $_POST['lastname_member'];
                                    $getPassword = $_POST['password'];
                                    $getid = $_GET['id'];
                                    $count = edit_member($getid, $getPassword, $getName, $getLastname);

                                    if ($count === false) {
                                        die(print_r($con->errorInfo(), true));
                                    } else {
                                        ?>

                                        <?php
                                        echo "<center><h4>คุณได้ทำการอัพเดทสำเร็จแล้ว</h4></center>";
                                    }
                                }
                                ?>
                            </span>
                            <!-- ตารางสมาชิก -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h5>ตารางสมาชิก</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">รหัสขนส่ง</div></th>
                                                    <th><div align="center">ชื่อขนส่ง</div></th>
                                                    <th><div align="center">เบอร์โทรศัพท์</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //ดึงข้อมูลจากตาราง
                                                $i = 1;
                                                $result = get_transport();
                                                while ($user = $result->fetch(PDO::FETCH_OBJ)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $user->idtransport; ?></td>
                                                        <td><?php echo $user->name_transport; ?></td>
                                                        <td><?php echo $user->tel_transport; ?></td>
                                                        <td>
                                                            <a href="popup_edit_membership.php?idmember=<?php echo $user->idmember; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </a>
                                                            <a href="popup_delete_membership.php" class="btn btn-danger " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="ลบ">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>  
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--End ตารางสมาชิก -->
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
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <script>
            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal')
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