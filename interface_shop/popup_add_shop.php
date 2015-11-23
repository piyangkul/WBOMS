<?php require_once 'function/func_shop.php'; ?>
<form class="form" action="action/action_addShop.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มร้านค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_shop">ชื่อร้านค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรอกชื่อร้านค้า" name ="name_shop" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="tel_shop">เบอร์โทรศัพท์</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" maxlength="10" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" name="tel_shop" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="address_shop">ที่อยู่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรอกที่อยู่" name = "address_shop" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="province">จังหวัด</label>
                    <div class="btn-group">
                        <select id="aaa" name ="idprovince" class="form-control">
                            <?php
                            $getProvince = getProvince();
                            foreach ($getProvince as $value) {
                                $val_idprovince = $value["idprovince"];
                                $val_name_province = $value["name_province"];
                                echo "<option name ='idprovince' value = $val_idprovince>$val_name_province</option>";
                            }  
                            ?>
                            
                        </select>
                    </div>
                </div>

                <div class="form-group col-xs-12">
                    <label for="detail_shop">รายละเอียด</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <textarea rows="4" cols="50" id="detail_factory" name="detail_shop" class="form-control" placeholder="กรอกรายละเอียดอื่นๆ" value="" required=""/></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <p id="alertPass"></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" value="addShop" class="btn btn-primary">Save changes</button>
    </div>
</form>

