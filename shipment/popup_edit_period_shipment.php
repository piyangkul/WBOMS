<?php
require_once 'function/func_shipment.php';
?>

<?php
if (isset($_GET['idshipment_period'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $idNextshipment = $_GET['idNextshipment']; //ใช้ไม่ได้
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $val_date_end = $getShipment_period['date_end'];

    $Nextid = getNextid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
    $val_next_idshipment_period = $Nextid['idshipment_period'];
    $val_next_date_end = $Nextid['date_end'];
    //echo $val_next_idshipment_period;
}
?>
<?php
$date1 = str_replace('-', '/', $val_date_start);
$tomorrow = date('Y-m-d', strtotime($date1 . "+1 days"));
//echo $tomorrow;
$date2 = str_replace('-', '/', $val_next_date_end);
$yesterday = date('Y-m-d', strtotime($date2 . "-2 days"));
?>
<form class="form" action="action/action_editPeriod_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&Nextid=<?php echo $val_next_idshipment_period; ?>" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขรอบการส่งสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
<!--                <div class="alert alert-success" role="alert">
                    ถ้ามีรอบในเดือนถัดไป เช็คค่าว่ามีรอบเดือนถัดไป 1.ส่งidรอบ$idshipment_period+1 1.ดึงค่ารอบเดือนถัดไป 2.เช็คค่าที่ดึง 3.ถ้ามีรอบ ให้ส่งค่าไปกับform ต้องเขียนตอนรับค่า 
                </div>-->

                <?php // echo $idNextshipment; ?>
                <?php
//                if ($idNextshipment == 4) {//ค่าที่+1มา = ค่าที่ดึงมาจากsql คือมีค่าก่อนหน้า
//                    //ให้+1ในรอบถัดไป โดยการดึงค่ารอบเก่า แล้วแก้ไข+1
//                } else {//ไม่มีรอบก่อนหน้า
//                    
//                }
                ?>
                <div class="form-group col-xs-12">
                    <label for="date_start">วันที่เริ่มต้น</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" name="date_start" value="<?php echo $val_date_start; ?>" readonly/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_end">วันที่สิ้นสุด </label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" name="date_end" min="<?php echo date("$tomorrow"); ?>" max="<?php echo $yesterday; ?>" value="<?php echo $val_date_end; ?>" required/>
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
