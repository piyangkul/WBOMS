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
                    <select class="form-control" id="factoryName" name="factoryName" onchange ="ChangeProduct()" required >
                        <option selected value="Choose">Choose</option>
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
                   <!-- <p id="idFactory2"></p>-->
                </div>

                <div class="form-group col-xs-12">
                    <label for="product_name">สินค้า</label> <font size="1" color ="red">*กรุณาเลือกโรงงานก่อน</font>
                    <select class="form-control" id="productName" name="productName" onchange = "ChangeUnit()" required disabled >
                        <option selected value="Choose">Choose</option>
                        <?php
                        $getProduct = getProduct();
                        foreach ($getProduct as $value) {
                            $val_idproduct = $value['idproduct'];
                            //$val_idfactory = $value['idfactory'];
                            $val_name_product = $value['name_product'];
                            ?>2
                            <option value="<?php echo $val_idproduct; ?>"><?php echo $val_name_product; ?></option>
                        <?php } ?>
                    </select>

                </div>
                <div class="form-group col-xs-12">
                    <label for="name_product"> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>

                    <select class="form-control" id="idUnit" name="idUnit" onchange = "" required disabled >
                        <option>กรุณาเลือกหน่วยขาย</option>
                        <?php
                        $getUnit = getUnit();
                
                        foreach ($getUnit as $value) {
                            $val_idunit = $value['idunit'];
                            $val_name_unit = $value['name_unit'];
                            $val_price_unit = $value['price_unit'];
                            $val_type_unit = $value['type_unit'];
                            $val_idunitsub = $val_idunit + 1;
                            ?>
                            <option value="<?php echo $val_idunit; ?>"><?php echo $val_name_unit; ?></option><?php
                        }
                        ?>

                    </select>
                    
                </div>
                <div class="form-group col-xs-12">
                    <label for="amount_product">จำนวน</label>
                    <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" onkeyup="updateAmount()">
                </div>
                <div class="form-group col-xs-12">
                    <label for="disabled_price_unit">ราคาเปิดต่อหน่วย //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                    <input type="text" class="form-control" id="total_price" readonly="true">
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

                                    <label class="radio">
                                        <input type="radio" name="inlineRadioOptions"> ขายลดเปอร์เซ็นต์//8% = 44.8
                                        <input type="text" class="form-control" placeholder="กรอก%ขายลด"  id="DifferencePer" value="" onkeyup="updateTotal()"/>
                                        
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="inlineRadioOptions" id="DifferenceBath" value="option1"> ขายเพิ่มสุทธิ
                                        <input type="text" class="form-control" placeholder="กรอกราคาขายเพิ่มสุทธิ" id="userName" name="username" value="" /> 
                                    </label>

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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" value="addProduct" onclick="addProduct();" class="btn btn-primary">Save changes</button>
    </div>


</form>
<script>
    function addProduct() {
        var idUnit = $("#idUnit").val();
        var AmountProduct = $("#AmountProduct").val();
        var DifferencePer = $("#DiffrencePer").val();
        var DifferenceBath = $("#DiffrenceBath").val();

        var p = "&idUnit=" + idUnit + "&AmountProduct=" + AmountProduct + "&DiffrencePer=" + DifferencePer + "&DiffrenceBath=" + DifferenceBath + "&type=" + type;
//        alert(p);
        $.get("action_addProduct.php?p=addProduct" + p, function (data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            if (data == "1") {
//                $("#alert").html("บันทึกแล้ว")
                $("#idUnit").val("");
                $("#AmountProduct").val("");
                $("#DifrrencePer").val("");
                $("#DifrrenceBath").val("");
                showUnit();
            }
            else {
                $("#idUnit").val("");
                $("#AmountProduct").val("");
                $("#DifrrencePer").val("");
                $("#DifrrenceBath").val("");
                showUnit();

            }
        });
    }
    function ChangeProduct() {
        var x = document.getElementById("factoryName").value;
        //document.getElementById("idFactory2").innerHTML = "You selected: " + x;
        if (x === "Choose") {
            document.getElementById("productName").disabled = true;
        }
        else {
            document.getElementById("productName").disabled = false;
        }

    }
    function ChangeUnit() {
        var z = document.getElementById("productName").value;
        if (z === "Choose") {
            document.getElementById("idUnit").disabled = true;
        }
        else {
            document.getElementById("idUnit").disabled = false;
        }
    }
</script>
