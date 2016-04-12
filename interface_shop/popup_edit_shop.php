<?php
require_once 'function/func_shop.php';

if (isset($_GET['idshop'])) {
    $idshop = $_GET['idshop'];
    $getShop = getShopByID($idshop);
    $val_name_shop = $getShop['name_shop'];
    $val_tel_shop = $getShop['tel_shop'];
    $val_address_shop = $getShop['address_shop'];
    $val_name_province = $getShop['name_province'];
//    $val_name_region = $getShop['name_region'];
    $val_detail_shop = $getShop['detail_shop'];

    $val_idprovince_s = $getShop['idprovince'];
    $val_name_province_s = $getShop['name_province'];
    $val_name_code_s = $getShop['code_province'];
    $val_name_region_s = $getShop['name_region'];
    ?>
    <form class="form"action="action/action_editShop.php?idshop=<?php echo $idshop; ?>" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">แก้ไขร้านค้า</h4>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="form-group col-xs-12">
                    <div class="form-group col-xs-12">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="name_shop">ชื่อร้านค้า</label><label class="text-danger">*</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                            <input type="text" class="form-control" placeholder="กรอกชื่อร้านค้า" name ="name_shop" required="" value = "<?php echo $val_name_shop; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="tel_shop">เบอร์โทรศัพท์</label><label class="text-danger">*</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                            <input type="text" maxlength="10" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" name="tel_shop" required="" value = "<?php echo $val_tel_shop; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="address_shop">ที่อยู่</label><label class="text-danger">*</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                            <input type="text" class="form-control" placeholder="กรอกที่อยู่" name = "address_shop" required="" value = "<?php echo $val_address_shop; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="province">จังหวัด</label><label class="text-danger">*</label>
                        <div class="btn-group">
                            <select id="aaa" name ="idprovince" class="form-control" required >
                                <?php
                                echo"<option name ='idprovince' value = $val_idprovince_s >$val_name_province_s:$val_name_code_s [$val_name_region_s] </option>";
                                $i = 0;
                                $getProvince = getProvince();
                                foreach ($getProvince as $value) {
                                    $i++;
                                    $val_idprovince = $value["idprovince"];
                                    $val_name_region = $value["name_region"];
                                    $val_name_province = $value["name_province"];
                                    $val_code_province = $value["code_province"];
                                    if ($val_idprovince != $val_idprovince_s) {
                                        echo "<option name ='idprovince' value = $val_idprovince> $val_name_province:$val_code_province [$val_name_region] </option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group col-xs-12">
                        <label for="detail_shop">รายละเอียด</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                            <textarea rows="4" cols="50" id="detail_factory" name="detail_shop" class="form-control" placeholder="กรอกรายละเอียดอื่นๆ" ><?php echo $val_detail_shop; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id="submit"class="btn btn-primary">Save changes</button>
        </div>
    </form>

<?php } ?>