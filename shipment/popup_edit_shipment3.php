<?php
require_once 'function/func_shipment.php';
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

$idorder_transport = $_GET['idorder_transport'];

$price = $_GET['price'];
$status_shipment_factory = $_GET['status_shipment'];

$getShipmentDetailByID = getShipmentDetailByID($idorder_transport, $idshipment_period, $idfactory);
$val_idtransport = $getShipmentDetailByID['idtransport'];
$val_code_transport = $getShipmentDetailByID['code_transport'];
$val_date_transport = $getShipmentDetailByID['date_transport'];
$date_transport = date_create($val_date_transport);
$date_transport->add(new DateInterval('P543Y0M0DT0H0M0S'));
$val_name_transport = $getShipmentDetailByID['name_transport'];
$val_volume = $getShipmentDetailByID['volume'];
$val_number = $getShipmentDetailByID['number'];
$val_price_transport = $getShipmentDetailByID['price_transport'];
?>
<script>
    var idtransport;
    var data = JSON.stringify(<?php echo getTransport(); ?>);//ดึงค่า
    var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
    //alert(Obj);
    var Arr = new Array();
    var JSON_transportCode = new Array();
    var JSON_transportName = new Array();
    //pushข้อมูลลงArray
    for (var i = 0; i < Obj.length; i++) {
        //Arr.push(Obj[i].code_transport);
        Arr.push(Obj[i].name_transport + " (" + Obj[i].code_transport + ")");
        JSON_transportCode["'" + Obj[i].code_transport + "'"] = Obj[i].idtransport;
        JSON_transportName["'" + Obj[i].name_transport + "'"] = Obj[i].idtransport;
        console.log(JSON_transportCode);
        console.log(JSON_transportName);
    }
    $(function () {
        $("#idtransport").autocomplete({
            source: Arr
        });
    });

    function getFactoryId(e) {
        if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {
            var input = document.getElementById("idtransport").value;
            //alert(input);
            firstParen = input.lastIndexOf("(");
            secondParen = input.lastIndexOf(")");
            input = input.substr(firstParen + 1, secondParen - firstParen - 1);
            //alert(input+ firstParen +","+ secondParen);
            if (JSON_transportCode["'" + input + "'"] != null) {
                idtransport = JSON_transportCode["'" + input + "'"];
            }
            else {
                idtransport = JSON_transportName["'" + input + "'"];
            }
            console.log(idtransport);
            //$("#test").text(idtransport);
            document.getElementById("id").value = idtransport;
        }
        return false;
    }
</script>
<form class="form" action="action/action_editShipment.php?idorder_transport=<?php echo $idorder_transport; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price_pay_factory=<?php echo $price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลการส่งสินค้า</h4>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_transport">วันที่ส่งสินค้า</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" name="date_transport" id="date_transport" value="<?php echo $val_date_transport; ?>" required/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport">รหัสหรือชื่อบริษัทขนส่ง</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-truck" ></i></span>
                        <input type="text" class="form-control" id="idtransport" autocomplete=on value="<?php echo $val_name_transport; echo ' (';echo $val_code_transport; echo ')'; ?>" name="idtransport_show" onblur ="getFactoryId(event)" onkeypress="getFactoryId(event)" required >
                        <input type="hidden" id="id" name="idtransport" value="<?php echo $val_idtransport; ?>">
                    </div>
                </div>
                
<!--                <div class="form-group col-xs-12">
                    <label for="name_transport">ชื่อบริษัทขนส่ง</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-truck"  ></i></span>
                        <select class="form-control" id="idtransport" name="idtransport" id="idtransport" required >
                            <option selected value="<?php// echo $val_idtransport; ?>"><?php// echo $val_name_transport; ?></option>
                            <?php
//                            require_once '../transport/function/func_transport.php';
//                            $getTransports = getTransports();
//                            foreach ($getTransports as $value) {
//                                $val_idtransport_s = $value['idtransport'];
//                                $val_name_transport_s = $value['name_transport'];
//                                ?>
                                <?php //if ($val_idtransport_s != $val_idtransport) { ?>
                                    <option value="<?php //echo $val_idtransport_s; ?>"><?php //echo $val_name_transport_s; ?></option>
                                <?php //} ?>
                            <?php//} ?>
                        </select>
                    </div>
                </div>-->
                
                <div class="form-group col-xs-12">
                    <label for="volume">เล่มที่</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเล่มที่ " name="volume" value="<?php echo $val_volume; ?>" required/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="number">เลขที่</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเลขที่" name="number" value="<?php echo $val_number; ?>" required />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="price_transport">ค่าส่งสินค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar" ></i></span>
                        <input type="text" class="form-control" id="price_transport" name ="price_transport" value="<?php echo $val_price_transport; ?>" />
                        <span class="input-group-addon">.00</span>
                    </div>
                </div>
                <!--                <div class="form-group col-xs-12">
                                    <input type="checkbox" onchange="chkPrice_transport()" id="check_price" value="" />
                                    <label for="price_transport">ค่าส่งสินค้า</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-dollar" ></i></span>
                                        <input type="text" onchange="chkPrice_transport()" class="form-control" id="price_transport" placeholder="กรุณากรอกค่าส่งสินค้า" name ="price_transport" value="0" disabled/>
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </div>-->

            </div>
        </div>

        <div class="row">
            <div class = "col-md-1 col-sm-1 "></div>
            <div class = "col-md-10 col-sm-10 ">
                <!-- ตารางรายการสินค้า -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <label>ตารางรายการสินค้าที่สั่ง</label>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover text-center " id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th  valign="middle"><div align="center">เลือก</div></th>
                                <th><div align="center">วันที่สั่ง</div></th>
                                <th><div align="center">ร้านค้า</div></th>
                                <th><div align="center">ชื่อสินค้า</div></th>
                                <th><div align="center">ราคาเปิดต่อหน่วย</div></th>
                                <th><div align="center">จำนวน</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getShipmentsByID = getProductDetail_shipmentEdit($idshipment_period, $idfactory, $val_idtransport, $val_date_transport, $val_volume, $val_number, $val_price_transport);
                                    $i = 0;
                                    foreach ($getShipmentsByID as $value) {
                                        $i++;
                                        $val_idproduct_order = $value['idproduct_order'];
                                        $val_date_order_p = $value['date_order_p'];
                                        $date_order_p = date_create($val_date_order_p);
                                        $date_order_p->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                        $val_name_shop = $value['name_shop'];
                                        $val_name_product = $value['name_product'];
                                        $val_price_unit = $value['price_unit'];
                                        $val_amount_product_order = $value['amount_product_order'];
                                        $val_name_unit = $value['name_unit'];
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" checked="true" name="check_shipment[]" id="check_shipment_<?php echo $i; ?>" value="<?php echo $val_idproduct_order; ?>" onclick="chkCount('<?php echo $i; ?>')">
                                                <input id="check_shipment_hidden_<?php echo $i; ?>" type="hidden" value="<?php echo $val_idproduct_order; ?>" name="check_shipment_hidden[]">
                                            </td>
                                            <td><?php echo date_format($date_order_p, 'd-m-Y'); ?></td>
                                            <td><?php echo $val_name_shop; ?></td>
                                            <td><?php echo $val_name_product; ?></td>
                                            <td><?php echo $val_price_unit; ?></td>
                                            <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!--End ตารางรายการสินค้า -->
            </div>
        </div>
    </div>

    <div class="modal-footer">
<!--        <p id="alertPass"></p>-->
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="test_btn_save" name="sumbit" class="btn btn-primary">Save changes</button>
    </div>
</form>



<script>
    var cc = 0;
    function chkCount(id) {
        if ($("#check_shipment_" + id).prop("checked")) {
            cc++;
        }
        else {
            cc--;
        }
        if (cc <= 0) {
            $("#btn_save").prop("disabled", true);
        }
        else {
            $("#btn_save").prop("disabled", false);
        }
    }
</script>
<!--<button type="submit" id="btn_save" disabled name="sumbit" class="btn btn-primary" onclick="return confirm('กรุณาตรวจสอบความถูกต้องข้อมูลการส่งสินค้าเนื่องจากจะไม่สามารถแก้ไขข้อมูลการส่งได้');">Save changes</button>-->
<!--<script>
<button type="submit" name="sumbit" class="btn btn-primary" onclick="chkTransport()">Save changes</button>
function chkTransport() {
    var test = $("#idtransport").val();
    var date_transport = $("#date_transport").val();
    var check_shipment = $("#check_shipment").val();
    if (test != "" && date_transport != "" && check_shipment != "") {

        if (confirm('กรุณาตรวจสอบความถูกต้องข้อมูลการส่งสินค้าเนื่องจากจะไม่สามารถแก้ไขข้อมูลการส่งได้')) {
            alert('Yes');

        } else {
            alert('cancel');
            return false;
        }
    }
}
</script>-->
<!--<div class="alert alert-danger" role="alert">แก้ 1.required checkbox 2.กดปุ่มยกเลิกไม่ได้ </div>-->
<!--
<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
    <thead>
        <tr>
            <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
<th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
<th rowspan="2"><div align="center">จำนวน</div></th>
<th colspan="5"><div align="center">ราคา/หน่วย</div></th>
<th colspan="3"><div align="center">ราคาทั้งหมด</div></th>
</tr>

<tr>
    <th><div align="center">ราคาเปิด</div></th>
<th><div align="center">ต้นทุนลด</div></th>
<th><div align="center">ราคาต้นทุน</div></th>
<th><div align="center">ขายลด</div></th>
<th><div align="center">ราคาขาย</div></th>
<th><div align="center">ราคาเปิดรวม</div></th>
<th><div align="center">ราคาต้นทุนรวม</div></th>
<th><div align="center">ราคาขายรวม</div></th>
</tr>

</thead>
<tbody>
    //<?php
//    $sum_sale_transport = 0;
//    $getProductDetail_shipment = getProductDetail_shipment($idshipment_period, $idfactory, $idtransport, $volume, $number, $price_transport);
//    $i = 0;
//    foreach ($getProductDetail_shipment as $value) {
//        $i++;
//        $val_name_product = $value['name_product'];
//        $val_amount_product_order = $value['amount_product_order'];
//        $val_name_unit = $value['name_unit'];
//        $val_price_unit = $value['price_unit']; //ราคาเปิด
//
//        if ($value['difference_amount_product'] == null) {
//            $val_difference_amount = $value['difference_amount_factory'];
//        } else {
//            $val_difference_amount = $value['difference_amount_product'];
//        }
//        $cost = $val_price_unit - (($val_difference_amount / 100.0) * $val_price_unit);
//
//        $val_difference_product_order = $value['difference_product_order']; //ขายลด
//        $val_type_product_order = $value['type_product_order'];
//        if ($value['type_product_order'] == "PERCENT") {
//            $cost2 = $val_price_unit - (($val_difference_product_order / 100.0) * $val_price_unit);
//        } else {
//            $cost2 = $val_price_unit - $val_difference_product_order;
//        }
//        
?>
        <tr>
            <td>//<?php // echo $i;  ?></td>
            <td>//<?php // echo $val_name_product;  ?></td>
            <td>//<?php // echo $val_amount_product_order . " " . $val_name_unit;  ?></td> จำนวน
            <td class="text-right">//<?php // echo number_format($val_price_unit, 2, '.', '');  ?></td> ราคาเปิด
            <td>//<?php // echo $val_difference_amount . "%";  ?></td> ต้นทุนลด                                      
            <td class="text-right">//<?php // echo number_format($cost, 2, '.', '')  ?></td> ราคาต้นทุน
            <td>//<?php // echo $val_difference_product_order;  ?><?php // echo ($val_type_product_order == "PERCENT") ? "%" : "฿";  ?></td>
            <td>//<?php // echo $cost2;  ?></td>  ราคาขาย 
            <td>//<?php // echo $val_price_unit * $val_amount_product_order;  ?></td>
            <td>//<?php // echo $cost * $val_amount_product_order;  ?></td>  ราคาต้นทุนรวม 
            <td>//<?php // echo $cost2 * $val_amount_product_order;  ?></td>  ราคาขายรวม 
            //<?php // $sum_sale_transport = $sum_sale_transport + $cost2 * $val_amount_product_order;  ?>
        </tr>
    //<?php // }  ?>
</table>-->

<!--<td><input type="checkbox" checked="true" name="check_shipment[]" id="check_shipment_<?php echo $i; ?>" value="<?php echo $val_idproduct_order; ?>" onclick="chkCount('<?php echo $i; ?>')"></td>-->