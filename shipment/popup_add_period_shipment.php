<form class="form" action="action/action_addPeriod_shipment.php" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มรอบการส่งสินค้า</h4>
    </div>
    <!--<div class="alert alert-danger" role="alert">แก้ กำหนดวันที่เริ่มต้น </div>-->
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <?php
                //ดึงข้อมูลจากตาราง
                require_once 'function/func_shipment.php';
                $getNextStartShipment_Period = getNextStartShipment_Period();
                foreach ($getNextStartShipment_Period as $value) {
                    $val_NextStartPeriod = $value['NextStartPeriod'];
                }
                ?>
                <div class="form-group col-xs-12">
                    <label for="date_start">วันที่เริ่มต้น //ระบบกำหนดให้เลย</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                        <input type="date" class="form-control" name="date_start" readonly value="<?php echo date("$val_NextStartPeriod"); ?>" >
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_end">วันที่สิ้นสุด </label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" name="date_end" min="<?php echo date("$val_NextStartPeriod"); ?>" required/>
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