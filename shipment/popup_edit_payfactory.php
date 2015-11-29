<?php
require_once 'function/func_shipment.php';
?>
<?php
if (isset($_GET['idproduct_order'])) {
    $idproduct_order = $_GET['idproduct_order'];
    $getProduct_order = getProduct_orderByID($idproduct_order);
    $val_name_product = $getProduct_order['name_product'];
    $val_amount_product_order = $getProduct_order['amount_product_order'];
    $val_name_factory = $getProduct_order['name_factory'];
    $val_monthly = $getProduct_order['monthly'];
    $val_price_pay_factory = $getProduct_order['price_pay_factory'];
} 
?>
﻿<form class="form" action="action/action_addPayfactory.php?idproduct_order=<?php echo $idproduct_order; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">การจ่ายเงินโรงาน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                    <center><h4>โรงงาน <?php echo $val_name_factory; ?> &nbsp;&nbsp; ประจำเดือน <?php echo $val_monthly; ?></h4></center>
                </div>
                <div class="form-group col-xs-12">
                    <center><h4>ยอดเงินที่โรงงานเรียกเก็บ <?php echo $val_price_pay_factory; ?> </h4></center>
                </div>

                <div class = "row">
                    <div class = "col-md-1 col-sm-1 "></div>
                    <div class = "col-md-10 col-sm-10 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>รายการสินค้าคืน</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th><div align="center">ลำดับ</div></th>
                                        <th><div align="center">ชื่อสินค้า</div></th>
                                        <th><div align="center">ราคาเปิดต่อหน่วย</div></th>
                                        <th><div align="center">จำนวน</div></th>
                                        <th><div align="center">ราคา</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
//                        $getMembers = getMembers();
//                        $i = 0;
//                        foreach ($getMembers as $value) {
//                            $i++;
//                            $val_idmember = $value['idmember'];
//                            $val_name = $value['name'];
//                            $val_lastname = $value['lastname'];
//                            $val_username = $value['username'];
//                            
                                            ?>
                                                <!--<tr>-->
                    <!--                                <td><?php echo $i; ?></td>
                                                    <td><?php echo $val_name; ?></td>
                                                    <td><?php echo $val_lastname; ?></td>
                                                    <td><?php echo $val_username; ?></td>
                                                    <td><?php ?></td>
                                                    <td><?php ?></td>
                                                    <td><?php ?></td>-->
                                            <!--</tr>-->
                                            <?php // }  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <center><h4>ยอดเงินสินค้าคืนรวม  </h4></center>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    
                    <center><h4>สรุปยอดเงินที่จ่ายโรงงาน  </h4></center>
                </div>
                
                <div class = "col-md-1 col-sm-1 "></div>
                <div class="form-group col-xs-10">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>ประเภทการจ่ายเงิน </label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive ">
                                    <div class="form-group input-group">
                                    <div class="radio-inline">
                                        <label><!--bug -->
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" >เงินสด
                                        </label>
                                    </div>
                                    </div>
                                    <div class="form-group input-group">
                                    <div class="radio-inline">
                                        <label>
                                            <input type="radio" onchange="chkDate_pay_factory()"  name="check_credit" id="check_credit" value="option1" >เช็ค
                                            <input type="date" onchange="chkDate_pay_factory()" class="form-control" placeholder="กรอกวันที่เช็ค" id="date_pay_factory" name="date_pay_factory" value="" /> 
                                        </label>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
<script>
    $(document).ready(function () {
        var check_credit = $("#check_credit:checked").length > 0;
        var date_pay_factory = $("#date_pay_factory").val();
        if (check_credit) {
            $("#date_pay_factory").prop('disabled', false);
        }
        else {
            $("#date_pay_factory").prop('disabled', true);
        }
    });

    function chkDate_pay_factory() {
        var check_credit = $("#check_credit:checked").length > 0;
        var date_pay_factory = $("#date_pay_factory").val();
        if (check_credit) {
            $("#date_pay_factory").prop('disabled', false);
        }
        else {
            $("#date_pay_factory").prop('disabled', true);
        }
    }
</script>