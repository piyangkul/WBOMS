<?php
require_once 'function/func_docket.php';
require_once '../interface_shop/function/func_shop.php';
require_once '../shipment/function/func_shipment.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'docket';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
<?php
$idshipment_period = $_GET['idshipment_period'];
$getShipment_period = getShipment_periodByID($idshipment_period);
$val_date_start = $getShipment_period['date_start'];
$date_start = date_create($val_date_start);
$date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
$val_date_end = $getShipment_period['date_end'];
$date_end = date_create($val_date_end);
$date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
$idshop = $_GET['idshop'];
$getShop = getShopByID($idshop);
$val_name_shop = $getShop['name_shop'];
$val_name_region = $getShop['name_region'];
$val_name_province = $getShop['name_province'];
$val_tel_shop = $getShop['tel_shop'];
if ($val_tel_shop == NULL) {
    $val_tel_shop = "-";
}

$Beforeid = getBeforeid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
$val_before_idshipment_period = $Beforeid['idshipment_period'];
$getPayDetailByID = getPayDetailByID($idshop, $val_before_idshipment_period);
$val_debt_before_shipment = $getPayDetailByID['debt']; //ยอดค้างชำระ(รอบที่แล้ว)
//echo $val_before_idshipment_period;
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
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
                            <h2> Shop Bill </h2>   
                            <h5> การจัดการร้านค้า </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <a class="btn btn-danger btn-lg" onclick="Back()">
                        <span class="fa fa-arrow-circle-left"></span> Back
                    </a>

                    <div class="table-responsive">
                        <div id="table1">
                            <h3 class="text-danger" align="center">ใบแจ้งหนี้ </h3>
                            <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo date_format($date_start, 'd-m-Y'); ?> ถึง <?php echo date_format($date_end, 'd-m-Y'); ?></h4></center>
                            <h4 class="text-center">ร้าน : <?php echo $val_name_shop; ?> &nbsp; &nbsp; &nbsp; ที่อยู่ : <?php echo $val_name_region; ?>  จ. <?php echo $val_name_province; ?> &nbsp; &nbsp; &nbsp; เบอร์โทรศัพท์ : <?php echo $val_tel_shop; ?></h4>
                            <h4 class="text-center">ยอดค้างชำระ &nbsp;&nbsp; <b><?php echo number_format($val_debt_before_shipment, 2); ?></b> &nbsp;&nbsp; บาท</h4>
                            <h4 class="text-center">ยอดเงินเรียกเก็บสุทธิ &nbsp;&nbsp; <b id="hidden_price_pay"> </b> &nbsp;&nbsp; บาท </h4>  
                            <input type="hidden" id="debt_before_shipment" value="<?php echo number_format($val_debt_before_shipment, 2); ?>">

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h5>รายการสินค้าคืน C/N จากรอบที่แล้ว</h5>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover text-center ">
                                        <thead>
                                            <tr>
                                                <th><div align="center">ลำดับ</div></th>
                                                <th><div align="center">วันที่คืน</div></th>
                                                <th><div align="center">โรงงาน</div></th>
                                                <th><div align="center">ชื่อสินค้า</div></th>
                                                <th><div align="center">จำนวน</div></th> 
                                                <th><div align="center">ราคาคืน/หน่วย</div></th>
                                                <th><div align="center">ราคาคืน</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getProductRefundByID = getProductRefundByID($idshop, $idshipment_period);
                                            $i2 = 0;
                                            $refund = 0;
                                            $sum_refund = 0;
                                            foreach ($getProductRefundByID as $value) {
                                                $i2++;
                                                $val_idfactory = $value['idfactory'];
                                                $val_name_factory = $value['name_factory'];
                                                $val_name_product = $value['name_product'];
                                                $val_price_unit = $value['price_unit'];
                                                $val_amount_product_refunds = $value['amount_product_refunds'];
                                                $val_name_unit = $value['name_unit'];
                                                $val_date_product_refunds = $value['date_product_refunds'];
                                                $date_product_refunds = date_create($val_date_product_refunds);
                                                $date_product_refunds->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                $val_price_difference = $value['price_difference']; //ขายลด
                                                $val_type_money = $value['type_money'];
                                                if ($value['type_money'] == "PERCENT") {
                                                    $cost2 = $val_price_unit - (($val_price_difference / 100.0) * $val_price_unit);
                                                } else {
                                                    $cost2 = $val_price_unit + $val_price_difference;
                                                }
                                                $refund = $cost2 * $val_amount_product_refunds;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i2; ?></td>
                                                    <td><?php echo date_format($date_product_refunds, 'd-m-Y'); ?></td> 
                                                    <td><?php echo $val_name_factory; ?></td>  
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_refunds . " " . $val_name_unit; ?></td>
                                                    <td class="text-right"><?php echo number_format($cost2, 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($refund, 2); ?></td>
                                                    <?php $sum_refund = $sum_refund + $refund; ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="text-danger" align="right">ราคาคืนรวม &nbsp;&nbsp; <b><?php echo number_format($sum_refund, 2); ?></b> &nbsp;&nbsp; บาท </div>  
                                    <input type="hidden" value="<?php echo number_format($sum_refund, 2); ?>" id="hidden_refund" >
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h5>รายการสินค้าที่สั่งซื้อ</h5>
                                    </div>
                                    <table class="table table-striped table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                                                <th colspan="3"><div align="center">ข้อมูลการส่งสินค้า</div></th>
                                                <th rowspan="2"><div align="center">โรงงาน</div></th>
                                                <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                                <th rowspan="2"><div align="center">จำนวน</div></th> 
                                                <th rowspan="2"><div align="center">ราคาขาย/หน่วย</div></th>
                                                <th rowspan="2"><div align="center">ราคาขาย</div></th>
                                            </tr>
                                            <tr>
                                                <th><div align="center">วันที่ส่ง</div></th>
                                                <th><div align="center">ชื่อ/เล่มที่/เลขที่</div></th>
                                                <th><div align="center">ค่าส่ง</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
                                            $getProductDocketByID = getProductDocketByID($idshop, $idshipment_period);
                                            $i = 0;
                                            $n = 0;
                                            $sum_cost = 0;
                                            $sum_price_transport = 0;
                                            foreach ($getProductDocketByID as $value) {
                                                $i++;
                                                $val_idfactory = $value['idfactory'];
                                                $val_name_factory = $value['name_factory'];
                                                $val_name_product = $value['name_product'];
                                                $val_price_unit = $value['price_unit'];
                                                $val_amount_product_order = $value['amount_product_order'];
                                                $val_name_unit = $value['name_unit'];
                                                $val_date_transport = $value['date_transport'];
                                                $date_transport = date_create($val_date_transport);
                                                $date_transport->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                $val_name_transport = $value['name_transport'];
                                                $val_volume = $value['volume'];
                                                if ($val_volume == NULL) {
                                                    $val_volume = "-";
                                                }
                                                $val_number = $value['number'];
                                                if ($val_number == NULL) {
                                                    $val_number = "-";
                                                }
                                                $val_price_transport = $value['price_transport'];
                                                $val_difference_product_order = $value['difference_product_order']; //ขายลด
                                                $val_type_product_order = $value['type_product_order'];
                                                if ($value['type_product_order'] == "PERCENT") {
                                                    $cost = $val_price_unit - (($val_difference_product_order / 100.0) * $val_price_unit);
                                                } else {
                                                    $cost = $val_price_unit + $val_difference_product_order;
                                                }
                                                $sale = $cost * $val_amount_product_order;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <?php
                                                    $test = getProductDuplicateDocketByID($idshop, $idshipment_period, $val_name_transport, $val_number, $val_volume, $val_idfactory);
                                                    if ($test > 1) {
                                                        if ($n == 0) {
                                                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" >' . date_format($date_transport, 'd-m-Y') . '</td>';
                                                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" >' . $val_name_transport . "/" . $val_volume . "/" . $val_number . '</td>';
                                                            echo "<td class=\"text-right\" style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" valign="middle">' . number_format($val_price_transport, 2) . '</td>';
                                                            $sum_price_transport = $sum_price_transport + $val_price_transport;
                                                        }
                                                        $n++;
                                                        if ($n == $test) {
                                                            $n = 0;
                                                        }
                                                    } else {
                                                        ?>
                                                        <td><?php echo date_format($date_transport, 'd-m-Y'); ?></td>
                                                        <td><?php echo $val_name_transport . "/" . $val_volume . "/" . $val_number; ?></td>
                                                        <td class="text-right"><?php echo number_format($val_price_transport, 2); ?></td>
                                                        <?php
                                                        $sum_price_transport = $sum_price_transport + $val_price_transport;
                                                    }
                                                    ?>
                                                    <td><?php echo $val_name_factory; ?></td>  
                                                    <td><?php echo $val_name_product; ?></td>
                                                    <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                                                    <td class="text-right"><?php echo number_format($cost, 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($sale, 2); ?></td>
                                                    <?php $sum_cost = $sum_cost + $sale; ?><!--ราคาขายรวม-->
                                                </tr>
                                            <?php } ?>
                                            <?php $sum_order = $sum_cost + $sum_price_transport; ?><!--ยอดสั่งซื้อรวม-->
                                        </tbody>
                                    </table>
                                    <div align="right">ราคาขายรวม &nbsp;&nbsp; <b><?php echo number_format($sum_cost, 2); ?></b> &nbsp;&nbsp; บาท </div>     
                                    <div align="right">ค่าส่งรวม &nbsp;&nbsp; <b><?php echo number_format($sum_price_transport, 2); ?></b> &nbsp;&nbsp; บาท </div>
                                    <div class="text-danger" align="right">ยอดสั่งซื้อรวม &nbsp;&nbsp; <b><?php echo number_format($sum_order, 2); ?></b> &nbsp;&nbsp; บาท </div>
                                    <input type="hidden" value="<?php echo number_format($sum_order, 2); ?>" id="hidden_order" >
                                </div>
                                <!--<div align="right">ยอดเงินเรียกเก็บสุทธิ &nbsp;&nbsp; <b><?php //echo number_format($sum_order - $sum_refund, 2);    ?></b> &nbsp;&nbsp; บาท </div>-->                                  
                                <input type="hidden" value="<?php echo number_format($val_debt_before_shipment + $sum_order - $sum_refund, 2); ?>" id="hidden_total" >
                                    </div>
                                    </div>
                                    <p>
                                        <button class="btn btn-info" id="btn1" type="submit">พิมพ์</button>
                                    </p>

                                    <!-- /. PAGE INNER  -->
                                    </div>
                                    <!-- /. PAGE WRAPPER  -->
                                    </div>
                                    <!-- /. WRAPPER  -->
                                    </div>
                                    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
                                    <!-- JQUERY SCRIPTS -->
                                    <!--<script src="../assets/js/jquery-1.10.2.js"></script>-->
                                    <!-- BOOTSTRAP SCRIPTS -->
                                    <script src="../assets/js/bootstrap.min.js"></script>
                                    <!-- METISMENU SCRIPTS -->
                                    <script src="../assets/js/jquery.metisMenu.js"></script>
                                    <!-- DATA TABLE SCRIPTS -->
                                    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
                                    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
                                    <script>
                        $(document).ready(function () {
                            //console.log($('#hidden_total').val());
                            var order = $('#hidden_order').val();
                            var refund = $('#hidden_refund').val();
                            var total = $('#hidden_total').val();
                            var debt_before_shipment = document.getElementById("debt_before_shipment").value;
                            $('#hidden_price_pay').html("<b>" + "( " + debt_before_shipment + " + " + order + " )" + " - " + refund + " = " + total + "</b>");
                            $('#dataTables-example').dataTable();
                        });
                                    </script>
                                    <script>
                                        function Back() {
                                            window.location.assign("docket.php?idshop=<?php echo $idshop; ?>");
                                        }
                                        $(function () {
                                            $('[data-toggle="tooltip"]').tooltip();
                                        });

                                        $(document.body).on('hidden.bs.modal', function () {
                                            $('#myModal').removeData('bs.modal');
                                        });
                                    </script>
                                    <script src="../printMe/jquery-printme.js"></script>
                                    <script>
                                        $("#btn1").click(function () {
                                            $("#table1").printMe({"path": "../printMe/libs/bootstrap.min.css", "title": ""});
                                        });
                                        $("#btn2").click(function () {
                                            $("#table2").printMe({"path": "../printMe/libs/bootstrap.min.css", "title": "Bootstrap Table"});
                                        });
                                    </script>
                                    </body>
                                    </html>

                                    <!--<div class="alert alert-danger" role="alert">1.ยังไม่ได้ทำ ยอดค้างชำระ </div>-->