<?php
require_once 'function/func_stat_shop_bill.php';
require_once '../docket/function/func_docket.php';
?>
<?php
$year_pay = $_GET['year_pay'];
$idshop = $_GET['idshop'];
$getShopsByID = getShopsByID($idshop);
$name_shop = $getShopsByID['name_shop'];
$status_pay = $_GET['status_pay'];
?>
<form class="form" action="" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ตารางข้อมูลการเก็บเงิน(ประเภทเก็บครบและเงินสด) </h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>

                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example"> 
                    <thead>
                        <tr>
                            <th><div align="center">วันที่เริ่มรอบ</div></th>
                    <th><div align="center">วันที่สิ้นสุดรอบ</div></th>
                    <th><div align="center">วันที่จ่ายเงิน</div></th>
                    <th><div align="center">ยอดค้างชำระ</div></th>
                    <th><div align="center">ยอดสั่งซื้อ</div></th>
                    <th><div align="center">ยอดสินค้าคืน</div></th><!-- จากorder product refund-->
                    <th><div align="center">ยอดสุทธิ</div></th><!--ยอดเก็บเงินสุทธิ-->
                    <th><div align="center">ยอดที่เก็บได้</div></th>
                    <th><div align="center">ยอดหนี้</div></th>
                    <!--<th><div align="center">สถานะ</div></th>สถานะการเก็บเงิน เก็บได้ เก็บไม่ได้-->
                    <!--<th><div align="center">การกระทำ</div></th>-->
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getPay_cash = getPay_cash($idshop, $status_pay);
                        $i = 0;
                        foreach ($getPay_cash as $value) {
                            $i++;
                            $val_idshipment_period = $value['idshipment_period'];
                            $val_date_start = $value['date_start'];
                            $date_start = date_create($val_date_start);
                            $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
                            $val_date_end = $value['date_end'];
                            $date_end = date_create($val_date_end);
                            $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
                            $val_date_pay = $value['date_pay'];
                            if ($val_date_pay == "") {
                                $date_pay = "-";
                            } else {
                                $date_pay = date_create($val_date_pay);
                                $date_pay->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                $date_pay = date_format($date_pay, 'd-m-Y');
                            }
                            $val_debt = $value['debt']; //ยอดหนี้(รอบที่แล้ว)
                            if ($val_debt == "") {
                                $val_debt = "0";
                            } else {
                                $val_debt = $val_debt;
                            }
                            $val_price_pay = $value['price_pay']; //ยอดจ่ายเงินสุทธิ   
                            if ($val_price_pay == "") {
                                $val_price_pay = "0";
                            } else {
                                $val_price_pay = $val_price_pay;
                            }
                            $val_status_pay = $value['status_pay']; //สถานะการเก็บเงินเก็บได้ เก็บไม่ได้
                            if ($val_status_pay == "") {
                                $val_status_pay = "-";
                            } elseif ($val_status_pay == "get") {
                                $val_status_pay = "เก็บครบ";
                            } elseif ($val_status_pay == "unget") {
                                $val_status_pay = "เก็บไม่ได้";
                            } else {
                                $val_status_pay = "เก็บไม่ครบ";
                            }
                            $val_status_process = $value['status_process'];

                            //ไม่ใช้ $val_price_order_total = $value['price_order_total']; //ยอดสั่งซื้อรวม

                            $n = 0;
                            $sum_cost = 0;
                            $sum_price_transport = 0;
                            $getProductDocketByID = getProductDocketByID($idshop, $val_idshipment_period);
                            foreach ($getProductDocketByID as $value) {
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
                                    $cost = $val_price_unit - $val_difference_product_order;
                                }
                                $sale = $cost * $val_amount_product_order; //ราคาขาย
                                $sum_cost = $sum_cost + $sale; //ราคาขายรวม

                                $getProductDuplicateDocketByID = getProductDuplicateDocketByID($idshop, $val_idshipment_period, $val_name_transport, $val_number, $val_volume, $val_idfactory);
                                if ($getProductDuplicateDocketByID > 1) {
                                    if ($n == 0) {
                                        $sum_price_transport = $sum_price_transport + $val_price_transport; //ราคาค่าส่งรวม
                                    }
                                    $n++;
                                    if ($n == $getProductDuplicateDocketByID) {
                                        $n = 0;
                                    }
                                } else {
                                    $sum_price_transport = $sum_price_transport + $val_price_transport; //ราคาค่าส่งรวม
                                }
                            }
                            $sum_order = $sum_cost + $sum_price_transport; //ยอดสั่งซื้อรวม

                            $Beforeid = getBeforeid($val_idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
                            $val_before_idshipment_period = $Beforeid['idshipment_period'];
                            $getOrder_product_refundsByID = getOrder_product_refundsByID($idshop, $val_idshipment_period);
                            $val_order_price_product_refunds = $getOrder_product_refundsByID['order_price_product_refunds'];
                            $getPayDetailByID = getPayDetailByID($idshop, $val_before_idshipment_period);
                            $val_debt_before_shipment = $getPayDetailByID['debt']; //ยอดค้างชำระ(รอบที่แล้ว)
                            ?>
                            <tr>
                                <td><?php echo date_format($date_start, 'd-m-Y'); ?></td>
                                <td><?php echo date_format($date_end, 'd-m-Y'); ?></td>
                                <td><?php echo $date_pay; ?></td>
                                <td class="text-right"><!-- ยอดค้างชำระ(รอบที่แล้ว)-->
                                    <?php echo number_format($val_debt_before_shipment, 2); ?>
                                </td>
                                <td class="text-right"><!-- ยอดสั่งซื้อ -->
                                    <?php echo number_format($sum_order, 2); ?>
                                    <?php //echo "<a href='../docket/popup_order_docket.php?idshipment_period=$val_idshipment_period&idshop=$idshop' data-toggle='modal' data-target='#myModal-lg'> " . number_format($sum_order, 2) . " </a>"; ?>
                                </td>
                                <td class="text-right"><!-- สินค้าคืน(รอบที่แล้ว)-->
                                    <?php echo number_format($val_order_price_product_refunds, 2); ?>
                                    <?php //echo "<a href='popup_product_refund.php?idshipment_period=$val_idshipment_period&idshop=$idshop' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_order_price_product_refunds, 2) . " </a>"; ?>
                                </td>
                                <td class="text-right"><!-- ยอดเรียกเก็บสุทธิ -->
                                    <?php echo number_format($val_debt_before_shipment + $sum_order - $val_order_price_product_refunds, 2); ?>
                                </td>
                                <td class="text-right"><!-- ยอดที่เก็บได้ -->
                                    <?php echo number_format($val_price_pay - $val_debt, 2); ?>
                                </td>
                                <?php if ($val_debt == 0) { ?>
                                    <td class="text-right"><?php echo number_format(-1 * $val_debt, 2); ?></td>
                                <?php } else { ?> 
                                    <td class="text-right" style="color: red"><!-- ยอดหนี้(รอบปัจจุบัน)-->
                                        <?php echo number_format(-1 * $val_debt, 2); ?>
                                    </td>
                                <?php } ?>
                                <!--<td><?php // echo $val_status_pay; ?></td>-->
    <!--                                    <td>
                                     ดูใบปะหน้า 
                                    <a href="../docket/docket_paper.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>" class="btn btn-primary" data-toggle="tooltip" title="ดูใบปะหน้า">
                                        <span class="fa fa-file-text-o"></span>
                                    </a>

                                     ดูการเก็บเงินร้านค้า 
                                    <a href="popup_detail_payshop.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>&sum_order=<?php echo $sum_order; ?>&debt=<?php echo $val_debt; ?>&price_product_refunds=<?php echo $val_order_price_product_refunds; ?>" class="btn btn-success" data-toggle = "modal" data-target = "#myModal-lg" data-toggle="tooltip" title="ดูการเก็บเงินร้านค้า">
                                        <span class = "fa fa-file-text-o fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                                    </a>

                                </td>-->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
<!--<div class="alert alert-danger" role="alert">ยังไม่ได้แก้ sql </div>-->