<?php
require_once dirname(__FILE__) . '/../function/func_shipment.php';
?>
<?php
$idfactory = $_GET['idfactory'];
$idshipment_period = $_GET['idshipment_period'];
$status_shipment_factory = $_GET['status_shipment_factory']; //ไม่ใช้
$total_price = $_GET['total_price'];
?>
<?php
$price_pay_factory = getPrice_pay_factory($idshipment_period, $idfactory);
$val_status_shipment = $price_pay_factory['status_shipment'];
$Check_confirm = Check_confirm($idshipment_period, $idfactory);
?>
<table class="table table-striped table-bordered table-hover text-center " >
    <thead>
        <tr>
            <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
<th rowspan="2"><div align="center">วันที่สั่ง</div></th>
<th rowspan="2"><div align="center">ร้านค้า</div></th>
<th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
<th rowspan="2"><div align="center">ราคาเปิดต่อหน่วย</div></th>
<th rowspan="2"><div align="center">จำนวน</div></th>
<th colspan="3"><div align="center">ข้อมูลการส่งสินค้า</div></th>
<th rowspan="2"><div align="center">การกระทำสินค้าที่สั่งซื้อ</div></th>
</tr>
<tr>
    <th><div align="center">วันที่ส่ง</div></th>
<th><div align="center">ชื่อ/เล่มที่/เลขที่</div></th>
<th><div align="center">ค่าส่ง</div></th>
</tr>
</thead>
<tbody>

    <?php
    $getShipmentsByID_send = getShipmentByID_send($idfactory, $idshipment_period);
    $i = 0;
    $n = 0;
    foreach ($getShipmentsByID_send as $value) {
        $val_idorder_p = $value['idorder_p'];
        $val_idproduct = $value['idproduct'];
        $val_idproduct_order = $value['idproduct_order'];
        $val_idorder_transport = $value['idorder_transport'];
        $val_date_order_p = $value['date_order_p'];
        $date_order_p = date_create($val_date_order_p);
        $date_order_p->add(new DateInterval('P543Y0M0DT0H0M0S'));
        $val_name_shop = $value['name_shop'];
        $val_name_product = $value['name_product'];
        $val_price_unit = $value['price_unit'];
        $val_amount_product_order = $value['amount_product_order'];
        $val_name_unit = $value['name_unit'];
        $val_status_checktransport = $value['status_checktransport'];
        $val_confirm_status_shipment = $value['status_shipment'];
        $val_idtransport = $value['idtransport'];

        $val_date_transport = $value['date_transport'];
        //echo $val_date_transport;
        $date_transport = date_create($val_date_transport);
        $date_transport->add(new DateInterval('P543Y0M0DT0H0M0S'));
        if ($val_date_transport == NULL) {
            $date_transport = "-";
        }
        $val_name_transport = $value['name_transport'];
        if ($val_name_transport == NULL) {
            $val_name_transport = "-";
        }
        $val_volume = $value['volume'];
        if ($val_volume == NULL) {
            $val_volume = "-";
        }
        $val_number = $value['number'];
        if ($val_number == NULL) {
            $val_number = "-";
        }
        $val_price_transport = $value['price_transport'];
        $i++;
        ?>
        <?php if ($val_confirm_status_shipment == "pay" || $val_confirm_status_shipment == "finish") { ?> <!-- สถานะรายการสินค้า -->
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo date_format($date_order_p, 'd-m-Y'); ?></td>
                <td><?php echo $val_name_shop; ?></td>
                <td><?php echo $val_name_product; ?></td>
                <td class="text-right"><?php echo number_format($val_price_unit, 2); ?></td>
                <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                <?php
                $ShipmentDuplicate = getShipmentDuplicateByID($idfactory, $idshipment_period, $val_name_transport, $val_number, $val_volume);
                if ($ShipmentDuplicate > 1) {//ถ้าการส่ง1ครั้ง มีหลายรายการสั่ง
                    if ($n == 0) {
                        echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" >' . date_format($date_transport, 'd-m-Y') . '</td>';
                        echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" >' . $val_name_transport . "/" . $val_volume . "/" . $val_number . '</td>';
                        echo "<td class='text-right' style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" valign="middle">' . number_format($val_price_transport, 2) . '</td>';
                        ?>

                        <td style="vertical-align: middle" rowspan="<?php echo $ShipmentDuplicate; ?>">
                            <?php if ($date_transport != "-") { ?>
                                <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>&price=<?php echo $total_price; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด">
                                    <span class="glyphicon glyphicon-list-alt"></span>
                                </a>
                            <?php } else { ?>
                                <a href="popup_edit_amount_product_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไขจำนวนสินค้า">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>                                                 
                                <a href="action/action_delProduct_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>" onclick="if (!confirm('คุณต้องการลบรายการสินค้าหรือไม่')) {
                                                                return false;
                                                            }" class="btn btn-danger " title="ลบ">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            <?php } ?>
                        </td>


                        <?php
                    }
                    $n++;
                    if ($n == $ShipmentDuplicate) {
                        $n = 0;
                    }
                } else {//ถ้าการส่ง1ครั้ง มี1รายการสั่ง
                    ?>
                    <td><?php echo date_format($date_transport, 'd-m-Y'); ?></td>
                    <!--<td><?php //echo ($val_name_transport == "-" ? ($val_name_transport . "/" . $val_volume . "/" . $val_number) : ("<a href='popup_edit_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&idorder_transport=$val_idorder_transport&idtransport=$val_idtransport' data-toggle='modal' data-target='#myModal'>$val_name_transport/$val_volume/$val_number </a>"));                                                                                                        ?></td>-->
                    <td><?php
                        if ($val_name_transport == "-") {
                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                        } elseif ($val_status_shipment == "pay" || $val_confirm_status_shipment == "finish") {
                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                        }
                        ?> </td>
                    <td class="text-right"><?php echo number_format($val_price_transport, 2); ?></td>

                    <td>
                        <?php if ($date_transport != "-") { ?>
                            <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>&price=<?php echo $total_price; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </a>
                        <?php } else { ?>
                            <a href="popup_edit_amount_product_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไขจำนวนสินค้า">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>                                                 
                            <a href="action/action_delProduct_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $total_price; ?>" onclick="if (!confirm('คุณต้องการลบรายการสินค้าหรือไม่')) {
                                                        return false;
                                                    }" class="btn btn-danger " title="ลบ">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        <?php } ?>
                    </td>

                    <?php
                }
                ?>
            </tr>
        <?php } else { ?>
            <!-- $val_confirm_status_shipment = addshipment -->
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo date_format($date_order_p, 'd-m-Y'); ?></td>
                <td><?php echo $val_name_shop; ?></td>
                <td><?php echo $val_name_product; ?></td>
                <td class="text-right"><?php echo $val_price_unit; ?></td>
                <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                <?php
                $ShipmentDuplicate = getShipmentDuplicateByID($idfactory, $idshipment_period, $val_name_transport, $val_number, $val_volume);
                if ($ShipmentDuplicate > 1) {//ถ้าการส่ง1ครั้ง มีหลายรายการสั่ง
                    if ($n == 0) {
                        echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" >' . date_format($date_transport, 'd-m-Y') . '</td>';

                        $check_transport_Dupli = TRUE;
                        $getProductDetail_shipment = getProductDetail_shipment($idshipment_period, $idfactory, $val_idtransport, $val_volume, $val_number, $val_price_transport);
                        foreach ($getProductDetail_shipment as $value) {
                            $val_check_status_shipment = $value['status_shipment'];
                            //echo $val_check_status_shipment;
                            if ($val_check_status_shipment == "check_price") {
                                $check_transport_Dupli = TRUE;
                                break;
                            } else {
                                $check_transport_Dupli = FALSE;
                            }
                        }

                        if ($check_transport_Dupli == FALSE) { //กรณี $val_status_shipment == "add_shipment"
                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" > <a href="popup_edit_shipment3.php?idshipment_period=' . $idshipment_period . '&idfactory=' . $idfactory . '&idorder_transport=' . $val_idorder_transport . '&idtransport=' . $val_idtransport . '&status_shipment=' . $status_shipment_factory . '&price=' . $total_price . '" data-toggle="modal" data-target="#myModal">' . $val_name_transport . "/" . $val_volume . "/" . $val_number . '</a></td>';
                        } else { //กรณี check_price
                            echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" > ' . $val_name_transport . "/" . $val_volume . "/" . $val_number . ' </td>';
                        }
                        echo "<td class='text-right' style=\"vertical-align:middle\" " . "rowspan=" . '"' . $ShipmentDuplicate . '" valign="middle">' . number_format($val_price_transport, 2) . '</td>';
                        ?>
                        <td style="vertical-align: middle" rowspan="<?php echo $ShipmentDuplicate; ?>">

                            <!--เปลี่ยนสีปุ่มเมื่อ confirm แล้ว กรณีการส่ง1ครั้ง มีหลายรายการสั่ง-->
                            <?php
                            $check_confirm_Dupli = TRUE;
                            $getProductDetail_shipment2 = getProductDetail_shipment($idshipment_period, $idfactory, $val_idtransport, $val_volume, $val_number, $val_price_transport);
                            foreach ($getProductDetail_shipment2 as $value) {
                                $val_check_status_shipment2 = $value['status_shipment'];
                                //echo $val_check_status_shipment;
                                if ($val_check_status_shipment2 == "check_price") {
                                    $check_confirm_Dupli = TRUE;
                                    break;
                                } else {
                                    $check_confirm_Dupli = FALSE;
                                }
                            }
                            ?>
                            <?php if ($check_confirm_Dupli == TRUE) { ?><!-- ตรวจแล้ว-->
                                <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>&price=<?php echo $total_price; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด ตรวจสอบยอดบิลแล้ว">
                                    <span class="glyphicon glyphicon-list-alt"></span>
                                </a>
                            <?php } else { ?>
                                <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>&price=<?php echo $total_price; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด รอการตรวจสอบยอดบิล">
                                    <span class="glyphicon glyphicon-list-alt"></span>
                                </a>
                            <?php } ?>

                        </td>
                        <?php
                    }
                    $n++;
                    if ($n == $ShipmentDuplicate) {
                        $n = 0;
                    }
                } else {//ถ้าการส่ง1ครั้ง มี1รายการสั่ง
                    ?>
                    <td><?php echo date_format($date_transport, 'd-m-Y'); ?> </td>
                    <td><?php
                        if ($val_confirm_status_shipment == "add_shipment") {
                            echo "<a href='popup_edit_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&idorder_transport=$val_idorder_transport&idtransport=$val_idtransport&status_shipment=$status_shipment_factory&price=$total_price' data-toggle='modal' data-target='#myModal'>$val_name_transport/$val_volume/$val_number </a>";
                        } else { //กรณี $val_confirm_status_shipment = "check_price" 
                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                        }
                        ?> 
                    </td>
                    <td class="text-right"><?php echo number_format($val_price_transport, 2); ?></td>
                    <td>
                        <!--เปลี่ยนสีปุ่มเมื่อ confirm แลว้ กรณีการส่ง1ครั้ง มี1รายการสั่ง-->                                                                           
                        <?php
                        if ($val_confirm_status_shipment == "check_price") {// ตรวจแล้ว
                            ?>
                            <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>&price=<?php echo $total_price; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด ตรวจสอบยอดบิลแล้ว">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </a>
                        <?php } else { ?>
                            <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>&price=<?php echo $total_price; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด รอการตรวจสอบยอดบิล">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </a>
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
            <?php
        }
    }
    ?>

</tbody>
</table>