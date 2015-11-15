<?php
require_once 'function/func_factory.php';
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
﻿<form class="form" action="action/action_editFactory.php?idfactory=<?php echo $idfactory; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขโรงงาน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_factory">ชื่อโรงงาน</label>
                    <input type="text" class="form-control" id="name_factory" name="name_factory" value="<?php echo $val_name_factory;?>">
                </div>
                <div class="form-group col-xs-12">
                    <label for="tel_factory">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="tel_factory" name="tel_factory" value="<?php echo $val_tel_factory;?>">
                </div>
                <div class="form-group col-xs-12">
                    <label for="address_factory">ที่อยู่</label>
                    <textarea rows="4" cols="50" class="form-control" id="address_factory" name="address_factory"><?php echo $val_address_factory; ?></textarea>
                </div>
                <div class="form-group col-xs-12">
                    <label for="contact_factory">ผู้ติดต่อ</label>
                    <input type="text" class="form-control" id="contact_factory" name="contact_factory" value="<?php echo $val_contact_factory;?>" >
                </div>
                <div class="form-group col-xs-12">
                    <label for="difference_amount_factory">ส่วนลดต้นทุนมาตราฐานของโรงงานเป็น%</label>
                    <input type="text" class="form-control" id="difference_amount_factory" name="difference_amount_factory" value="<?php echo $val_difference_amount;?>" >
                </div>
                <div class="form-group col-xs-12">
                    <label for="detail_factory">รายละเอียดอื่นๆ</label>
                    <textarea rows="4" cols="50" class="form-control" id="detail_factory" name="detail_factory"><?php echo $val_detail_factory;?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>