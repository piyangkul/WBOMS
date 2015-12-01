<?php require_once 'function/func_addorder.php'; ?>
<form class="form" action="action/action_addShop.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="factoryName">ชื่อโรงงาน</label>
                    <select class="form-control" id="shopName" name="shopName" required >
                        <option selected value="">Choose</option>
                        <?php
                        require_once '/function/func_addorder.php';
                        $getFactory = getFactory();
                        foreach ($getFactory as $value) {
                            $val_idfactory = $value['idfactory'];
                            $val_name_factory = $value['name_factory'];
                            ?>
                            <option value="<?php echo $val_idfactory; ?>"><?php echo $val_name_factory; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-xs-12">
                    <label for="tel_shop">สินค้า</label>
                    <select class="form-control" id="factoryName" name="productName" required ></select>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_product"> หน่วย</label> &nbsp;
                    <div class="btn-group">
                        <select id="aa" class="form-control" onchange="dd();">
                            <option>กรุณาเลือกหน่วยขาย</option>
                            <option value="cc">มัด(2กล่อง)</option>
                            <option>กล่อง(12แพ็ค)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="amount_product">จำนวน</label>
                    <input type="text" class="form-control" id="name_product" placeholder="กรอกจำนวนสินค้า">
                </div>
                <div class="form-group col-xs-12">
                    <label for="disabled_price_unit">ราคาเปิดต่อหน่วย //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                    <input type="text" class="form-control" id="disabled_price_unit" placeholder="560" disabled>
                </div>
                <div class="form-group col-xs-12">
                    <label for="disabled_cost_discounts_percent"> ต้นทุนลดเป็น% (%ที่โรงงานลดให้เรา) </label>
                    <input type="text" class="form-control" id="disabled_cost_discounts_percent" placeholder="10" disabled>
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName2"> ดังนั้นราคาต้นทุน //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="504" disabled>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <label>ส่วนต่างราคาขาย//ระบบจะดึงส่วนต่างราคาขายที่ให้แต่ละร้านค้า(สินค้าเชื่อมร้านค้า) </label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive ">
                                    <form class="form">
                                        <label class="radio">
                                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ขายลดเปอร์เซ็นต์//8% = 44.8
                                            <input type="text" class="form-control" placeholder="กรอก%ขายลด" id="userName" name="username" value="" /> 
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ขายเพิ่มสุทธิ
                                            <input type="text" class="form-control" placeholder="กรอกราคาขายเพิ่มสุทธิ" id="userName" name="username" value="" /> 
                                        </label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName2"> ดังนั้นราคาขาย//ระบบคำนวนอัตโนมัติ(ราคาเปิด-ส่วนต่างราคาขาย=560-44.8) </label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="515.20">
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

