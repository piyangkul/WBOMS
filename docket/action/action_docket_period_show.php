<?php
require_once dirname(__FILE__) . '/../function/func_docket.php';
?>
<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example"> 
    <thead>
        <tr>
            <th><div align="center">ร้านค้า</div></th>
<th><div align="center">วันที่จ่ายเงิน</div></th>
<th><div align="center">ยอดค้างชำระ</div></th>
<th><div align="center">ยอดสั่งซื้อ</div></th>
<th><div align="center">ยอดสินค้าคืน</div></th><!-- จากorder product refund-->
<th><div align="center">ยอดสุทธิ</div></th><!--ยอดเก็บเงินสุทธิ-->
<th><div align="center">ยอดที่เก็บได้</div></th>
<th><div align="center">ยอดหนี้</div></th>
<th><div align="center">สถานะ</div></th><!--สถานะการเก็บเงิน เก็บได้ เก็บไม่ได้-->
<th><div align="center">การกระทำ</div></th>
</tr>
</thead>
<tbody>
    <?php
    $idshipment_period = $_GET['idshipment_period'];
    $idregion = $_GET['idregion'];
    $idprovince = $_GET['idprovince'];
    $check_popup_addShop = TRUE;
    $getPayByID = getPayByIDPeriod($idshipment_period, $idregion, $idprovince);
    $i = 0;
    foreach ($getPayByID as $value) {
        $i++;
        $val_idshipment_period = $value['idshipment_period'];
        $idshop = $value['idshop'];
        $val_name_shop = $value['name_shop'];
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
                $cost = $val_price_unit + $val_difference_product_order;
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
        $price = $val_debt_before_shipment + $sum_order - $val_order_price_product_refunds;
        ?>
        <?php if ($sum_order != 0 || $val_debt_before_shipment != 0) { ?>
            <tr>
                <td><?php echo $val_name_shop; ?></td>
                <td><?php echo $date_pay; ?></td>
                <td class="text-right"><!-- ยอดค้างชำระ(รอบที่แล้ว)-->
                    <?php echo number_format($val_debt_before_shipment, 2); ?>
                </td>
                <td class="text-right"><!-- ยอดสั่งซื้อ -->
                    <?php if ($sum_order != 0) { ?>
                        <?php echo "<a href='popup_order_docket.php?idshipment_period=$val_idshipment_period&idshop=$idshop' data-toggle='modal' data-target='#myModal-lg'> " . number_format($sum_order, 2) . " </a>"; ?>
                        <?php
                    } else {
                        echo number_format($sum_order, 2);
                    }
                    ?>
                </td>
                <td class="text-right"><!-- สินค้าคืน(รอบที่แล้ว)-->
                    <?php if ($val_order_price_product_refunds != 0) { ?>
                        <?php echo "<a href='popup_product_refund.php?idshipment_period=$val_idshipment_period&idshop=$idshop' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_order_price_product_refunds, 2) . " </a>"; ?>
                        <?php
                    } else {
                        echo number_format($val_order_price_product_refunds, 2);
                    }
                    ?>
                </td>
                <td class="text-right"><!-- ยอดเรียกเก็บสุทธิ -->
                    <?php echo number_format($price, 2); ?>
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
                <td><?php echo $val_status_pay; ?></td>

                <td>
                    <!-- ดูใบปะหน้า -->
                    <a href="docket_paper.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>" class="btn btn-primary" data-toggle="tooltip" title="ดูใบปะหน้า">
                        <span class="fa fa-file-text-o"></span>
                    </a>
                    <?php if ($val_date_pay == "") { ?><!-- ถ้ายังไม่มีการเก็บเงิน ,ถ้ารอบข้างบนยังไม่finish -->

                        <?php
                        $getPayByID_check_add_payshop = getPayByIDcheckStatus($idshop, $val_idshipment_period);
                        $val_status_check_add_payshop = $getPayByID_check_add_payshop['status_process'];

                        $Beforeid2 = getBeforeid($val_idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
                        $val_before_idshipment_period_check = $Beforeid2['idshipment_period'];
//
                        $getPayByID_check_finish_payshop = getPayByIDcheckStatus($idshop, $val_before_idshipment_period_check);
                        $val_status_check_finish_payshop = $getPayByID_check_finish_payshop['status_process'];
//                   echo $val_order_price_product_refunds;
                        ?>
                        <?php
                        $n = 0;
                        $sum_cost = 0;
                        $sum_price_transport = 0;
                        $getProductDocketByID = getProductDocketByID($idshop, $val_before_idshipment_period_check);
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
                                $cost = $val_price_unit + $val_difference_product_order;
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
                        $sum_order2 = $sum_cost + $sum_price_transport; //ยอดสั่งซื้อรวม
                        ?>

                        <?php
                        // เพิ่มการเก็บเงินร้านค้า 
                        if ($sum_order != 0 && $val_status_check_add_payshop != "finish" && $val_before_idshipment_period_check == "") {//เป็นรอบแรก สั่งซื้อไม่ใช่0 รอบมันเองไม่ใช่finish
                            ?>
                            <a href="popup_add_payshop.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>&sum_order=<?php echo $sum_order; ?>&debt=<?php echo $val_debt; ?>&price_product_refunds=<?php echo $val_order_price_product_refunds; ?>" class="btn btn-info" data-toggle = "modal" data-target = "#myModal-lg" data-toggle="tooltip" title="เพิ่มการเก็บเงินร้านค้า">
                                <span class = "fa fa-plus fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                            </a><?php
                        } elseif ($sum_order != 0 && $val_status_check_add_payshop != "finish" && $sum_order2 == 0) {
                            ?><!-- สั่งซื้อไม่ใช่0 รอบมันเองไม่ใช่finish ยอดสั่งซื้อก่อนหน้า=0 -->
                            <a href="popup_add_payshop.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>&sum_order=<?php echo $sum_order; ?>&debt=<?php echo $val_debt; ?>&price_product_refunds=<?php echo $val_order_price_product_refunds; ?>" class="btn btn-info" data-toggle = "modal" data-target = "#myModal-lg" data-toggle="tooltip" title="เพิ่มการเก็บเงินร้านค้า">
                                <span class = "fa fa-plus fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                            </a>
                            <?php
                        } elseif ($check_popup_addShop == TRUE && $price != 0 && $val_status_check_add_payshop != "finish" && $val_status_check_finish_payshop == "finish") {
                            ?><!-- ทำให้ปุ่มเพิ่มออกครั้งเดียว ยอดสุทธิต้องไม่เป็น0 รอบมันเองไม่ใช่finish และรอบก่อนหน้าต้องเป็นfinish  -->

                            <a href="popup_add_payshop.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>&sum_order=<?php echo $sum_order; ?>&debt=<?php echo $val_debt; ?>&price_product_refunds=<?php echo $val_order_price_product_refunds; ?>" class="btn btn-info" data-toggle = "modal" data-target = "#myModal-lg" data-toggle="tooltip" title="เพิ่มการเก็บเงินร้านค้า">
                                <span class = "fa fa-plus fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                            </a>
                            <?php
                            $check_popup_addShop = FALSE;
                        } elseif ($sum_order == 0 && $val_order_price_product_refunds != 0 && $val_status_check_finish_payshop == "finish") {//เดือนนี้ไม่ได้สั่ง แต่เดือนที่แล้วมีของคืน จะข้ามไปเก็บเงินรอบถัดไป
                            ?>
                            <a href="popup_add_payshop_refund.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>&sum_order=<?php echo $sum_order; ?>&debt=<?php echo $val_debt; ?>&price_product_refunds=<?php echo $val_order_price_product_refunds; ?>" class="btn btn-warning" data-toggle = "modal" data-target = "#myModal-lg" data-toggle="tooltip" title="เลื่อนการเก็บเงินร้านค้าไปรอบถัดไป">
                                <span class = "fa fa-repeat fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                            </a>
                        <?php }
                        ?>

                    <?php } else { ?> <!-- ถ้าเพิ่มการเก็บเงินแล้ว -->

                        <!-- ดูการเก็บเงินร้านค้า -->
                        <a href="popup_detail_payshop.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>&sum_order=<?php echo $sum_order; ?>&debt=<?php echo $val_debt; ?>&price_product_refunds=<?php echo $val_order_price_product_refunds; ?>" class="btn btn-success" data-toggle = "modal" data-target = "#myModal-lg" data-toggle="tooltip" title="ดูการเก็บเงินร้านค้า">
                            <span class = "fa fa-file-text-o fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                        </a>

                        <?php if ($val_status_process == "add") { ?>
                            <!-- ลบการเก็บเงินร้านค้า -->
                            <a href="action/action_delPayshop.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>" onclick="if (!confirm('คุณต้องการลบหรือไม่')) {
                                                    return false;
                                                }" class="btn btn-danger " title="ลบการเก็บเงินร้านค้า">
                                <span class="fa fa-trash fa-lg fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                            </a>

                            <!-- เปลี่ยนสถานะเก็บเงินร้านค้าเป็นเสร็จสิ้น -->
                            <a href="action/action_finishPayshop.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>" onclick="if (!confirm('คุณต้องการกดเสร็จสิ้นหรือไม่')) {
                                                    return false;
                                                }" class="btn btn-outline " title="เปลี่ยนสถานะเก็บเงินร้านค้าเป็นเสร็จสิ้น">
                                <span class="fa fa-check fa-lg fa-fw"></span><span class = "fa fa-shopping-cart fa-lg"></span>
                            </a>

                        <?php } elseif ($val_status_process == "finish") { ?>

                        <?php } ?>

                    <?php } ?>

                </td>
            </tr>
        <?php } ?>
    <?php } ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable({"sort": false});
    });
</script>

