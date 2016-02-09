<?php require_once 'function/func_addorder.php'; ?>
<?php
session_start();
?>
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
                <select class="form-control" id="factoryName" name="factoryName" onchange ="LoadFactory(this.value)" required >
                    <option selected value="Choose">Choose</option>
                    <?php
                    $getFactory = getFactory();
                    foreach ($getFactory as $value) {
                        $val_idfactory = $value['idfactory'];
                        $val_name_factory = $value['name_factory'];
                        ?>
                        <option value="<?php echo $val_idfactory; ?>"><?php echo $val_name_factory; ?></option>
                    <?php } ?>

                </select>
                <h id="idFactory2"></h>
            </div>

            <div class="form-group col-xs-12">
                <label for="product_name">สินค้า</label> <font size="1" color ="red">*กรุณาเลือกโรงงานก่อน</font>
                <select class="form-control" id="productName" name="productName" onchange ="LoadProduct(this.value)" required>
                    <option selected value="Choose">Choose</option>   
                </select>

            </div>
            <div class="form-group col-xs-12">
                <label for="name_product"> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>

                <select class="form-control" id="idUnit" name="idUnit" onchange="LoadData(this.value)" required>
                    <option>กรุณาเลือกหน่วยขาย</option>


                </select>

                <div id="tee"></div>
            </div>
            <div class="form-group col-xs-12">
                <label for="amount_product">จำนวน</label>
                <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" onkeyup="updateAmount()">
            </div>
            <div class="form-group col-xs-12">
                <label for="disabled_price_unit">ราคาเปิดต่อหน่วย //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                <input type="text" class="form-control" id="total_price" readonly="true" onkeyup="cal_difference()">
            </div>
            <div class="form-group col-xs-12">
                <label for="disabled_cost_discounts_percent"> ต้นทุนลดเป็น% (%ที่โรงงานลดให้เรา) </label>
                <input type="text" class="form-control" id="difference" readonly="true" onkeyup="cal_difference()">
            </div>
            <div class="form-group col-xs-12">
                <label for="exampleInputName2"> ดังนั้นราคาต้นทุน //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                <input type="text" class="form-control" id="cal_difference" readonly="true" >
            </div>
            <div class="form-group col-xs-12">
                <div class="col-md-12 col-sm-12 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <label>ส่วนต่างราคาขาย//ระบบจะดึงส่วนต่างราคาขายที่ให้แต่ละร้านค้า(สินค้าเชื่อมร้านค้า) </label>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive ">

                                <label class="radio">
                                    <input type="radio" name="inlineRadioOptions"> ขายลดเปอร์เซ็นต์//8% = 44.8
                                    <input type="text" class="form-control" placeholder="กรอก%ขายลด"  id="DifferencePer" value="" onkeyup="updateTotalPer()"/>

                                </label>
                                <label class="radio">
                                    <input type="radio" name="inlineRadioOptions"> ขายเพิ่มสุทธิ
                                    <input type="text" class="form-control" placeholder="กรอกราคาขายเพิ่มสุทธิ" id="DifferenceBath" value="" onkeyup="updateTotalBath()"/> 
                                </label>
                                <h id="type"></h>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12">
                <label for="exampleInputName2"> ดังนั้นราคาขาย//ระบบคำนวนอัตโนมัติ(ราคาเปิด-ส่วนต่างราคาขาย=560-44.8) </label>
                <input  type="text" class="form-control" id="total" readonly="true" value="">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <p id="alertPass"></p>
    <button type="button" class="btn btn-default" onclick="addProduct();" data-dismiss="modal">Save</button>
</div>

<script>

    function addProduct() {
        var idUnit = $("#idUnit").val();
        var productName = $("#productName").val();
        var factoryName = $("#factoryName").val();
        var AmountProduct = $("#AmountProduct").val();
        var difference = $("#difference").val();
        var DifferencePer = $("#DifferencePer").val();
        var DifferenceBath = $("#DifferenceBath").val();
        var total_price = $("#total_price").val();
        var total = $("#total").val();
        var type = $("#type").val();
        //alert(idUnit);
        //alert(AmountProduct);
        //alert(DifferencePer);
        //alert(DifferenceBath);
        var p = "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&difference=" + difference + "&AmountProduct=" + AmountProduct + "&DifferencePer=" + DifferencePer + "&DifferenceBath=" + DifferenceBath + "&total_price=" + total_price + "&total=" + total + "&type=" + type;
        alert(p);
        $.get("action_addProduct.php?p=addProduct" + p, function (data, status) {
            alert("Data: " + data + "\nStatus: " + status);
            if (data == "1") {
                $("#alert").html("บันทึกแล้ว")
                $("#idUnit").val("");
                $("#productName").val("");
                $("#factoryName").val("");
                $("#difference").val("");
                $("#AmountProduct").val("");
                $("#DifferencePer").val("");
                $("#DifferenceBath").val("");
                $("#total_price").val("");
                $("#total").val("");
                $("#type").val("");
                showUnit();
            }
            else {
                $("#idUnit").val("");
                $("#productName").val("");
                $("#factoryName").val("");
                $("#difference").val("");
                $("#AmountProduct").val("");
                $("#DifferencePer").val("");
                $("#DifferenceBath").val("");
                $("#total_price").val("");
                $("#total").val("");
                $("#type").val("");
                showUnit();

            }
        });
    }

</script>
