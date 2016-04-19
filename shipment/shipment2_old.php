<?php
require_once 'function/func_shipment.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'shipment';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
<?php
if (isset($_GET['idshipment_period'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $date_start = date_create($val_date_start);
    $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
    $val_date_end = $getShipment_period['date_end'];
    $date_end = date_create($val_date_end);
    $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
}
$idfactory = isset($_GET['idfactory']) ? $_GET['idfactory'] : ""; //ถ้าไม่มีค่าก็เป็นค่าว่างๆเลย
$getFactoryByID = getFactoryByID($idfactory);
$val_name_factory = $getFactoryByID['name_factory'];
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <script src="//code.jquery.com/jquery-1.10.2.js"></script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
                            <h2> Shipment </h2>   
                            <h5> การส่งสินค้า </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <a class="btn btn-danger btn-lg" onclick="Back()">
                        <span class="fa fa-arrow-circle-left"></span> Back
                    </a>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                            </div>
                            <br/>
                            <span>
                                <?php
                                if (isset($_GET['action'])) {
                                    if ($_GET['action'] == "addPayfactoryCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มการจ่ายเงินโรงงานสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addPayfactoryError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มการจ่ายเงินโรงงานได้</h4></center>';
                                    } else if ($_GET['action'] == "editPayfactoryCompleted") {//ไม่ใช่
                                        echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editPayfactoryError") {//ไม่ใช่
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>';
                                    } else if ($_GET['action'] == "delPayfactoryCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการลบการจ่ายเงินโรงงานสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "delPayfactoryError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถลบการจ่ายเงินโรงงานได้</h4></center>';
                                    } else if ($_GET['action'] == "finishCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้จัดการการส่งสินค้าของโรงงาน ' . $val_name_factory . ' เสร็จสิ้นแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "finishError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถจัดการการส่งสินค้าของโรงงาน ' . $val_name_factory . ' ให้เสร็จสิ้นได้</h4></center>';
                                    }
                                }
                                ?>
                            </span>
                            <div class="alert alert-success" role="alert">
                                <b>หมายเหตุ</b> เมื่อจ่ายเงินโรงงานแล้ว จะกลับมาส่งสินค้าเพิ่มไม่ได้
                                <br/>จำนวนรายการที่สั่งคงค้าง : (-)สร้างรอบไว้ แต่ยังไม่มีorder (0)ทุกorderของโรงงานนั้นถูกเพิ่มการส่งแล้ว 
                                <br/>จำนวนรายการที่ส่ง : (-)ยังไม่ได้เพิ่มการส่ง ซักรายการเลย
                                <br/>จะเพิ่มการจ่ายเงินโรงงานได้ ก็ต่อเมื่อ มีการกดConfirmทุกรายการสินค้า หรือเลื่อนรายการสินค้าของโรงงานนั้นครบทุกอันแล้ว
                            </div>
                            <!--<div class="alert alert-danger" role="alert">แก้ 1.ทำไมรง.ลูกโป่งไม่ขึ้น ทั้งๆที่ไม่มีรอบ </div>-->
                            <!-- ตารางรายการสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางรายการสินค้า(แยกตามโรงงาน)</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center " id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">โรงงาน</div></th>
                                                    <th><div align="center">จำนวนรายการที่สั่งคงค้าง/ส่ง</div></th>
                                                    <th><div align="center">ยอดเงินที่สั่งซื้อ</div></th>
                                                    <th><div align="center">ค่าขนส่งรวม</div></th>
                                                    <th><div align="center">ยอดเงินรวม</div></th>
                                                    <th><div align="center">สถานะคำสั่งซื้อ</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
                                                $getFactoryByIDshipment_period = getFactoryByIDshipment_period4($idshipment_period);
                                                $leftArr = getCountLeftProduct_order(); //คงค้าง
//                                                            echo "<pre>";
//                                                            print_r($leftArr);
//                                                            echo "</pre>";
                                                $i = 0;
                                                foreach ($getFactoryByIDshipment_period as $value) {
                                                    $i++;
                                                    $val_status_shipment = $value['status_shipment'];
                                                    $val_idshipment_period = $value['idshipment_period'];
                                                    $val_idfactory2 = $value['idfactory'];
                                                    $val_idfactory = searchArr($leftArr, 'idfactory', $value['idfactory']);
                                                    $val_name_factory = $value['name_factory'];
                                                    $val_CountCheck = $value['CountCheck'];
                                                    if ($val_CountCheck == NULL) {
                                                        $val_CountCheck = "-";
                                                    }
                                                    $val_price = $value['price'];
                                                    if ($leftArr["$val_idfactory"]['count_left'] == NULL) {
                                                        continue;
                                                    }
                                                    $getPrice_transportByshipment_period = getPrice_transportByshipment_period($idshipment_period, $val_idfactory2);
                                                    $total_price = $val_price + $getPrice_transportByshipment_period['sum_price_transport'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_name_factory; ?></td>
                                                        <td><?php
                                                            $text = ($leftArr["$val_idfactory"]['count_left'] == NULL ? '-' : $leftArr["$val_idfactory"]['count_left']) . "/" . $val_CountCheck;
                                                            if ($val_status_shipment == "finish") {
                                                                echo "เสร็จสิ้น" . "/" . $val_CountCheck;
                                                            } else {
                                                                echo $text;
                                                            }
                                                            ?></td>
                                                        <?php
                                                        if ($val_price == NULL) {
                                                            $val_price = "-";
                                                            ?>
                                                            <td><?php echo $val_price; ?></td>
                                                        <?php } else { ?>
                                                            <td class="text-right"><?php echo number_format($val_price, 2); ?></td>
                                                        <?php } ?>
                                                        <td class="text-right"><?php echo number_format($getPrice_transportByshipment_period['sum_price_transport'], 2); ?></td>
                                                        <td class="text-right"><?php echo number_format($total_price, 2); ?></td>
                                                        <td>
                                                            <?php if ($val_status_shipment == NULL) { ?>
                                                                <img src = "../images/level0.png" title="รอเพิ่มข้อมูลการส่ง">
                                                                <?php } elseif ($val_status_shipment == 'add_shipment') { ?>
                                                                    <img src = "../images/level1.png" title="เพิ่มข้อมูลการส่งสำเร็จแล้ว รอตรวจสอบยอดบิล">                                                            
                                                                    <?php } elseif ($val_status_shipment == 'check_price' && $leftArr["$val_idfactory"]['count_left'] == 0) { ?>
                                                                        <img src = "../images/level2.png" title="ตรวจสอบยอดบิลสำเร็จแล้ว รอเพิ่มการจ่ายเงินโรงงาน">                                                            
                                                                        <?php } elseif ($val_status_shipment == 'check_price') {
                                                                            ?>
                                                                            <img src = "../images/level1.png" title="เพิ่มข้อมูลการส่งสำเร็จแล้ว รอตรวจสอบยอดบิล">                                                            
                                                                            <?php } elseif ($val_status_shipment == 'pay') {
                                                                                ?>
                                                                                <img src = "../images/level3.png" title="เพิ่มการจ่ายเงินโรงงานสำเร็จแล้ว รอกดปุ่มเสร็จสิ้น">   
                                                                                <?php } elseif ($val_status_shipment == 'finish') { ?>
                                                                                    <img src = "../images/level4.png" title="เสร็จสิ้น"> 
                                                                                    <?php } ?>
                                                                                    </td>
                                                                                    <td class="text-left">
                                                                                        <a href="add_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $val_status_shipment; ?>" class="btn btn-warning " data-toggle="tooltip" title="จัดการการส่งสินค้า">
                                                                                            <span class="glyphicon glyphicon-edit"></span>
                                                                                        </a>
                                                                                        <?php
                                                                                        $check = TRUE;
                                                                                        $Check_confirmDetail = Check_confirmDetail($idshipment_period, $val_idfactory2);
                                                                                        foreach ($Check_confirmDetail as $value) {
                                                                                            $val_status_shipment2 = $value['status_shipment'];
                                                                                            //echo $val_status_shipment2;
                                                                                            if ($val_status_shipment2 != "check_price") {
                                                                                                $check = FALSE;
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <?php if ($check == TRUE && $leftArr["$val_idfactory"]['count_left'] == 0) { ?> <!--สถานะรอการจ่ายเงินโรงงาน และ ไม่มีข้อมูลการจ่ายเงิน&& $val_idpay_factory == NULL-->
                                                                                            <a href = "popup_add_payfactory.php?page=shipment2&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $val_status_shipment; ?>" class = "btn btn-info " data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "เพิ่มการจ่ายเงินโรงงาน">
                                                                                                <span class = "fa fa-plus fa-lg fa-fw"></span><span class = "fa fa-building-o fa-lg"></span>
                                                                                            </a>
                                                                                        <?php } elseif ($val_status_shipment == 'pay') { ?> <!--สถานะรอการกดเสร็จสิ้น และ มีข้อมูลการจ่ายเงิน && $val_idpay_factory != NULL-->
                                                                                            <a href = "popup_detail_payfactory.php?page=shipment2&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $val_status_shipment; ?>" class = "btn btn-success" data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "ดูรายละเอียดการจ่ายโรงงาน">
                                                                                                <span class = "glyphicon glyphicon-list-alt"></span> <span class = "fa fa-building-o fa-lg"></span>
                                                                                            </a>
                                                                                            <a href="action/action_delPayfactory.php?page=shipment2&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $val_status_shipment; ?>" onclick="if (!confirm('คุณต้องการลบหรือไม่')) {
                                                                                                        return false;
                                                                                                    }" class="btn btn-danger " title="ลบการจ่ายเงินโรงงาน">
                                                                                                <span class="fa fa-trash fa-lg fa-fw"></span><span class = "fa fa-building-o fa-lg"></span>
                                                                                            </a>
                                                                                            <a href="action/action_finish.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $val_status_shipment; ?>" onclick="if (!confirm('คุณต้องการกดเสร็จสิ้นหรือไม่')) {
                                                                                                        return false;
                                                                                                    }" class="btn btn-outline" title="เปลี่ยนสถานะเป็นเสร็จสิ้น">
                                                                                                <span class="glyphicon glyphicon-ok"></span>
                                                                                            </a>
                                                                                        <?php } elseif ($val_status_shipment == 'finish') { ?>
                                                                                            <a href = "popup_detail_payfactory.php?page=shipment2&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $val_status_shipment; ?>" class = "btn btn-success" data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "ดูรายละเอียดการจ่ายโรงงาน">
                                                                                                <span class = "glyphicon glyphicon-list-alt"></span> <span class = "fa fa-building-o fa-lg"></span>
                                                                                            </a>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?> 
                                                                                </tbody>
                                                                                </table>

                                                                                </div>
                                                                                </div>
                                                                                </div>
                                                                                <!--End ตารางรายการสินค้า -->

                                                                                </div>
                                                                                </div>

                                                                                </div>
                                                                                <!--                <div class="alert alert-success" role="alert">
                                                                                                    check vaild id shipment period
                                                                                                </div>-->
                                                                                <!-- /. PAGE INNER  -->
                                                                                </div>
                                                                                <!-- /. PAGE WRAPPER  -->
                                                                                </div>
                                                                                <!-- /. WRAPPER  -->
                                                                                <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
                                                                                <!-- JQUERY SCRIPTS -->
                                                                                <script src="../assets/js/jquery-1.10.2.js"></script>                                                                                        
                                                                                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                                                                                <!-- BOOTSTRAP SCRIPTS -->
                                                                                <script src="../assets/js/bootstrap.min.js"></script>
                                                                                <!-- METISMENU SCRIPTS -->
                                                                                <script src="../assets/js/jquery.metisMenu.js"></script>
                                                                                <script>
                                                                                        $(document.body).on('hidden.bs.modal', function () {
                                                                                            $('#myModal').removeData('bs.modal');
                                                                                        });
                                                                                </script>
                                                                                <script>
                                                                                    $(document.body).on('hidden.bs.modal', function () {
                                                                                        $('#myModal-lg').removeData('bs.modal');
                                                                                    });
                                                                                </script>
                                                                                <!-- DATA TABLE SCRIPTS -->
                                                                                <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
                                                                                <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
                                                                                <script>
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-example').dataTable();
                                                                                    });
                                                                                    function Back() {
                                                                                        window.location.assign("shipment1.php");
                                                                                    }
                                                                                </script>
                                                                                </body>
                                                                                </html>
                                                                                <div class="modal fade" id="myModal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content modal-lg ui-front">
                                                                                            <!-- Content -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal fade" id="myModal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content modal-sm ui-front">
                                                                                            <!-- Content -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog">
                                                                                        <div class="modal-content ui-front">
                                                                                            <!-- Content -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>