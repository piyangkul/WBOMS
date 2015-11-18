<?php
require_once 'function/func_shipment.php';
?>
<?php
if (isset($_GET['idfactory'])) {
    $idfactory = $_GET['idfactory'];
    $getFactorys = getFactoryByID($idfactory);
    $val_name_factory = $getFactorys['name_factory'];
    $val_tel_factory = $getFactorys['tel_factory'];
    $val_address_factory = $getFactorys['address_factory'];
    $val_contact_factory = $getFactorys['contact_factory'];
    $val_difference_amount = $getFactorys['difference_amount_factory'];
    $val_detail_factory = $getFactorys['detail_factory'];
}
?>
﻿<form class="form" action="action/action_edit_amount_product_order.php?idfactory=<?php echo $idfactory; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขจำนวนสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_product">ชื่อสินค้า</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                        <input type="text" class="form-control" id="name_product" name="name_product" value="<?php echo $val_name_factory; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="amount_product_order">จำนวน</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"></i></span>
                        <input type="text" class="form-control" id="amount_product_order" name="amount_product_order" value="<?php echo $val_tel_factory; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_unit">หน่วยสินค้า</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"></i></span>
                        <input type="text" class="form-control" id="name_unit" name="name_unit" value="<?php echo $val_contact_factory; ?>" >
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