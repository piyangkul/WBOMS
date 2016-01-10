<?php
require_once 'function/func_shipment.php';
$idshipment_period = $_GET['idshipment_period'];
$getShipment_period = getShipment_periodByID($idshipment_period);
$val_date_start = $getShipment_period['date_start'];
$change_date_start = date("d-m-Y", strtotime($val_date_start));
$val_date_end = $getShipment_period['date_end'];
$change_date_end = date("d-m-Y", strtotime($val_date_end));

$idfactory = $_GET['idfactory'];
$getFactory = getFactoryByID($idfactory);
$val_name_factory = $getFactory['name_factory'];
?>
<form class="form" action="action/action_addShipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่ม/อัพเดท ข้อมูลการส่งสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_transport">วันที่ส่งสินค้า<label class="text-danger">*</label></label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" id="date_transport" name="date_transport" required/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport">ชื่อบริษัทขนส่ง</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-truck"  ></i></span>
                        <select class="form-control" id="idtransport" name="idtransport" required >
                            <option selected value="">กรุณาเลือกบริษัทขนส่ง</option>
                            <?php
                            require_once '../transport/function/func_transport.php';
                            $getTransports = getTransports();
                            foreach ($getTransports as $value) {
                                $val_idtransport = $value['idtransport'];
                                $val_name_transport = $value['name_transport'];
                                ?>
                                <option value="<?php echo $val_idtransport; ?>"><?php echo $val_name_transport; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="volume">เล่มที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเล่มที่ " name="volume" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="number">เลขที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเลขที่" name="number" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <input type="checkbox" onchange="chkPrice_transport()" id="check_price" value="" />
                    <label for="price_transport">ค่าส่งสินค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar" ></i></span>
                        <input type="text" onchange="chkPrice_transport()" class="form-control" id="price_transport" placeholder="กรุณากรอกค่าส่งสินค้า" name ="price_transport" disabled/>
                        <span class="input-group-addon">.00</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class = "col-md-1 col-sm-1 "></div>
            <div class = "col-md-10 col-sm-10 ">
                <!-- ตารางรายการสินค้า -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <label>ตารางรายการสินค้า</label>
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
                                    
                                    //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
                                    $getShipmentsByID = getProduct_order_shipmentByID($idfactory);
                                    $i = 0;
                                    foreach ($getShipmentsByID as $value) {
                                        $i++;
                                        $val_idproduct_order = $value['idproduct_order'];
                                        $val_date_order_p = $value['date_order_p'];
                                        $val_name_shop = $value['name_shop'];
                                        $val_name_product = $value['name_product'];
                                        $val_price_unit = $value['price_unit'];
                                        $val_amount_product_order = $value['amount_product_order'];
                                        $val_name_unit = $value['name_unit'];
//                                            
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" name="check_shipment[]" id="check_shipment" value="<?php echo $val_idproduct_order; ?>" ></td>
                                            <td><?php echo $val_date_order_p; ?></td>
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
</div>
<div class="modal-footer">
    <p id="alertPass"></p>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" name="sumbit" class="btn btn-primary">Save changes</button>
</div>
</form>
<script>
    $(document).ready(function () {
        var check_price = $("#check_price:checked").length > 0;
        var price_transport = $("#price_transport").val();
        if (check_price) {
            $("#price_transport").prop('disabled', false);
        }
        else {
            $("#price_transport").prop('disabled', true);
        }
    });

    function chkPrice_transport() {
        var check_price = $("#check_price:checked").length > 0;
        var price_transport = $("#price_transport").val();
        if (check_price) {
            $("#price_transport").prop('disabled', false);
        }
        else {
            $("#price_transport").prop('disabled', true);
        }
    }
</script>