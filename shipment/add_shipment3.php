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
if (isset($_GET['idshipment_period'])and isset($_GET['idfactory'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $date_start = date_create($val_date_start);
    $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
    $val_date_end = $getShipment_period['date_end'];
    $date_end = date_create($val_date_end);
    $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));

    $idfactory = $_GET['idfactory'];
    $getFactory = getFactoryByID($idfactory);
    $val_name_factory = $getFactory['name_factory'];

    $getCountshipment_perroid = getCountshipment_perroidByID($idfactory, $idshipment_period);
    $val_count_idorder_transport = $getCountshipment_perroid['count_idorder_transport'];

    $price = $_GET['price']; //ไม่ใช้แล้ว
    $status_shipment_factory = $_GET['status_shipment'];

    $getPrice_transportByshipment_period = getPrice_transportByshipment_period($idshipment_period, $idfactory);
    $price_transport = $getPrice_transportByshipment_period['sum_price_transport'];
    $getPriceFactoryByIDshipment_period = getPriceFactoryByIDshipment_period($idshipment_period, $idfactory);
    $price = $getPriceFactoryByIDshipment_period['price'];
    $total_price = $price + $price_transport;
}
?>
<!DOCTYPE html>
<html lang="th">
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
<!--        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
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
                                <center><h4 class="text text-info"><b>โรงงาน</b> <?php echo $val_name_factory; ?></h4></center>
                                <center><h4 class="text text-info"><b>จำนวนใบขนส่ง</b> <?php echo $val_count_idorder_transport; ?> <b>ใบ</b></h4></center>
                                <center><h4 class="text text-info"><b>ยอดเงินที่โรงงานเรียกเก็บ</b> <?php echo number_format($total_price, 2); ?> <b>บาท</b> </h4></center>
                            </div>

                            <span>
                                <?php
                                if (isset($_GET['action'])) {
                                    if ($_GET['action'] == "addCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>';
                                    } else if ($_GET['action'] == "editCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>';
                                    } else if ($_GET['action'] == "delProduct_orderCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการลบรายการสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "delProduct_orderError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถลบรายการสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "addShipmentCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการเพิ่มข้อมูลการส่งสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addShipmentError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถเพิ่มข้อมูลการส่งสินค้ารายการสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "editProduct_orderCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการแก้ไขจำนวนสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editProduct_orderError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถแก้ไขจำนวนสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "editStatus_check_priceCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการตรวจสอบยอดบิลแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editStatus_check_priceError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถทำการตรวจสอบยอดบิลได้</h4></center>';
                                    } else if ($_GET['action'] == "addPayfactoryCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการเพิ่มการจ่ายเงินโรงงานสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addPayfactoryError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถเพิ่มการจ่ายเงินโรงงานได้</h4></center>';
                                    } else if ($_GET['action'] == "delPayfactoryCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการลบการจ่ายเงินโรงงานสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "delPayfactoryError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถลบการจ่ายเงินโรงงานได้</h4></center>';
                                    } else if ($_GET['action'] == "EditShipmentCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการแก้ไขข้อมูลการส่งสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "EditShipmentError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถทำการแก้ไขข้อมูลการส่งสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "PostponeCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการเลื่อนรายการสินค้าไปส่งในรอบถัดไปสำเร็จแล้ว </h4></center>';
                                    } else if ($_GET['action'] == "PostponeError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถทำการเลื่อนรายการสินค้าไปส่งในรอบถัดไปได้</h4></center>';
                                    }
                                }
                                ?>
                            </span>
                            <input type="hidden" id="idfactory" value="<?php echo $idfactory; ?>">
                            <input type="hidden" id="idshipment_period" value="<?php echo $idshipment_period; ?>">
                            <input type="hidden" id="status_shipment_factory" value="<?php echo $status_shipment_factory; ?>">
                            <input type="hidden" id="total_price" value="<?php echo $total_price; ?>">
                            <?php
                            $price_pay_factory = getPrice_pay_factory($idshipment_period, $idfactory);
                            $val_status_shipment = $price_pay_factory['status_shipment'];
                            $Check_confirm = Check_confirm($idshipment_period, $idfactory);
                            ?>

                            <div class="alert alert-success" role="alert"><b>คำชี้แจง</b> : กรุณาตรวจสอบรายการสินค้าที่สั่งซื้อและเพิ่มข้อมูลการส่งสินค้า
                                <br><b>หมายเหตุ</b> : เมื่อเพิ่มข้อมูลการส่งสินค้าแล้ว คุณจะไม่สามารถแก้ไขหรือลบจำนวนสินค้าได้ 
                                <br> เมื่อตรวจสอบยอดบิลแล้ว(กดConfirm) คุณจะไม่สามารถแก้ไขข้อมูลการส่งสินค้าได้  
                            </div>

                            <?php if ($status_shipment_factory != 'pay' && $status_shipment_factory != 'finish') { ?>                           
                                <a href="popup_add_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" type="submit" name="check_shipment" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal-lg"> 
                                    <span class="fa fa-truck"></span> เพิ่มข้อมูลการส่งสินค้า
                                </a>
                            <?php } ?>

                            <?php
                            $getShipmentsByID = getShipmentByID($idfactory, $idshipment_period);
                            $i = 0;
                            foreach ($getShipmentsByID as $value) {
                                $i++;
                                $val_status_checktransport = $value['status_checktransport'];
                                if ($val_status_checktransport == "uncheck") {
                                    //echo $val_status_checktransport;
                                    break;
                                }
                                ?>
                                <?php //echo $val_status_checktransport; ?>
                            <?php } ?>

                            <?php
                            $check = TRUE;
                            $nn = 0;
                            $Check_confirmDetail = Check_confirmDetail($idshipment_period, $idfactory);
                            foreach ($Check_confirmDetail as $value) {
                                $val_status_shipment2 = $value['status_shipment'];
                                //echo $val_status_shipment2;
                                if ($val_status_shipment2 != "check_price") {
                                    $check = FALSE;
                                    break;
                                }
                            }
                            ?>
                            <?php if ($check == TRUE && $val_status_checktransport != "uncheck") { ?> <!--สถานะรอการจ่ายเงินโรงงาน และ ไม่มีข้อมูลการจ่ายเงิน&& $val_idpay_factory == NULL-->
                                <a href = "popup_add_payfactory.php?page=shipment3&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "เพิ่มการจ่ายโรงงาน">
                                    <span class = "fa fa-building-o"></span> เพิ่มข้อมูลการจ่ายเงินโรงงาน
                                </a>
                            <?php } elseif ($val_status_shipment == 'pay') { ?> <!--สถานะรอการกดเสร็จสิ้น และ มีข้อมูลการจ่ายเงิน && $val_idpay_factory != NULL-->
                                <a href = "popup_detail_payfactory.php?page=shipment3&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" class = "btn btn-success btn-lg" data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "ดูรายละเอียดการจ่ายโรงงาน">
                                    <span class = "fa fa-building-o fa-lg"></span> ดูรายละเอียดการจ่ายโรงงาน
                                </a>
                                <a href="action/action_delPayfactory.php?page=shipment3&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" onclick="if (!confirm('คุณต้องการลบการจ่ายเงินโรงงานหรือไม่')) {
                                                return false;
                                            }" class="btn btn-danger btn-lg" title="ลบการจ่ายเงินโรงงาน">
                                    <span class = "fa fa-building-o"></span> ลบข้อมูลการจ่ายเงินโรงงาน
                                </a>
                            <?php } elseif ($val_status_shipment == 'finish') { ?>
                                <a href = "popup_detail_payfactory.php?page=shipment3&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" class = "btn btn-success btn-lg" data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "ดูรายละเอียดการจ่ายโรงงาน">
                                    <span class = "fa fa-building-o fa-lg"></span> ดูรายละเอียดการจ่ายโรงงาน
                                </a>
                            <?php } ?>

                            <!--
                            <a href="popup_edit_payfactory.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="fa fa-building-o"></span> แก้ไขข้อมูลการจ่ายเงินโรงงาน
                            </a>-->
                            <!--<div><br></div>-->
                            <br/>
                            <br/>
                            <!-- ตารางรายการสินค้าที่รอเพิ่มการส่ง -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางรายการสินค้าที่รอเพิ่มการส่งสินค้า</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_not_send_table">
                                        <!-- action_not_send_show -->
                                    </div>
                                </div>
                            </div>
                            <!--End ตารางรายการสินค้าที่รอเพิ่มการส่ง -->

                            <!-- ตารางรายการสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางรายการสินค้าที่เพิ่มการส่งสินค้าแล้ว</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_send_table">
                                        <!-- action_send_show -->
                                    </div>
                                </div>
                            </div>
                            <!--End ตารางรายการสินค้าที่เพิ่มการส่งแล้ว -->
                            
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
                window.location.assign("shipment2.php?idshipment_period=<?php echo $idshipment_period; ?>");
            }

            show_not_send_table();
            function show_not_send_table() {
                var idfactory = $("#idfactory").val();
                var idshipment_period = $("#idshipment_period").val();
                var status_shipment_factory = $("#status_shipment_factory").val();
                var total_price = $("#total_price").val();
                $.get('action/action_not_send_show.php?idfactory=' + idfactory + '&idshipment_period=' + idshipment_period + '&status_shipment_factory=' + status_shipment_factory + '&total_price=' + total_price, function (data, status) {//+"&id="+
                    $("#show_not_send_table").html(data);
                });
            }

            show_send_table();
            function show_send_table() {
                var idfactory = $("#idfactory").val();
                var idshipment_period = $("#idshipment_period").val();
                var status_shipment_factory = $("#status_shipment_factory").val();
                var total_price = $("#total_price").val();
                $.get('action/action_send_show.php?idfactory=' + idfactory + '&idshipment_period=' + idshipment_period + '&status_shipment_factory=' + status_shipment_factory + '&total_price=' + total_price, function (data, status) {//+"&id="+
                    $("#show_send_table").html(data);
                });
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