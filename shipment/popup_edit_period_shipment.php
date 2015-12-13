<?php
require_once 'function/func_shipment.php';
?>

<?php
if (isset($_GET['idshipment_period'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $val_date_end = $getShipment_period['date_end'];
}
?>
<form class="form" action="action/action_editPeriod_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขรอบการส่งสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_start">วันที่เริ่มต้น //ระบบกำหนดให้เลย//ยังไม่ได้ทำ</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" name="date_start" value="<?php echo $val_date_start ;?>" required/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_end">วันที่สิ้นสุด </label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" name="date_end" value="<?php echo $val_date_end ;?>" required/>
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
