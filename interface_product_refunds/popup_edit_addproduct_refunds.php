<?php require_once 'function/func_addorder.php'; ?>
<?php
session_start();
$idorder = $_GET['idorder'];
$idshop = $_GET['idshop'];
?>
<script>
    var Product = JSON.stringify(<?php echo getProduct4(); ?>);
    var ProductP = JSON.parse(Product);
    var productName = new Array();
    var productId = new Array();
    var factoryName = new Array();
    var factoryId = new Array();
    var factoryDiff = new Array();
    for (var i = 0; i < ProductP.length; i++) {
        productName.push(ProductP[i].name_product);
        productId["'" + ProductP[i].name_product + "'"] = ProductP[i].idproduct;
        factoryName["'" + ProductP[i].name_product + "'"] = ProductP[i].name_factory;
        factoryId["'" + ProductP[i].name_product + "'"] = ProductP[i].idfactory;
        factoryDiff["'" + ProductP[i].name_product + "'"] = ProductP[i].difference_amount_factory;
    }
    $(function () {
        $("#name_product").autocomplete({
            source: productName
        });
    });
    function getProductID() {
        var name_shop = document.getElementById("name_product").value;
        document.getElementById("name_factory").value = factoryName["'" + name_shop + "'"];
        document.getElementById("idproduct").value = productId["'" + name_shop + "'"];
        document.getElementById("idfactory").value = factoryId["'" + name_shop + "'"];
        //document.getElementById("difference").value = factoryDiff["'" + name_shop + "'"];
        var id = productId["'" + name_shop + "'"];
        $.ajax({type: "GET",
            url: "action/action_ajax_product.php",
            async: false,
            data: "q=" + id,
            dataType: 'html',
            success: function (response)
            {
                $("#idUnit").html(response);
                //alert(response);
            }
        });

        var iddiff = productId["'" + name_shop + "'"];
        var idshop = document.getElementById('idshop').value;
        $.ajax({type: "GET",
            url: "action/action_ajax_hisdiff.php",
            async: false,
            data: "q=" + iddiff + "&idshop=" + idshop,
            dataType: 'html',
            success: function (www)
            {
                $("#diff").val(www);
                //alert(response);
            }
        });
    }
</script>
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
                <label for="name_product">ชื่อสินค้า</label>
                <div class="input-group ui-front">
                    <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                    <input type="text" class="form-control" id="name_product" name="name_product" placeholder="กรุณาระบุชื่อสินค้า" onblur="getProductID()" autocomplete= "on" ></input>
                    <input type="hidden" id="idproduct" name="idproduct"></input>
                    <input type="hidden" class="form-control" id="name_factory" name="name_factory" disabled>
                    <input type="hidden" class="form-control" id="idfactory" name="idfactory">
                    <input type="hidden" class="form-control" id="typefactory" name="typefactory">
                    <input type="hidden" class="form-control" id="idshop" name="idshop" value="<?= $idshop; ?>">
                    <input type="hidden" id="idFactory2">

                </div>
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;">
                <label for="name_product"> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>
                <select class="form-control" id="idUnit" name="idUnit" onchange="LoadData(this.value)" required>
                    <option>กรุณาเลือกหน่วยขาย</option>
                </select>
                <div id="tee"></div>
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;">
                <label for="amount_product">จำนวน</label>
                <input type="hidden" class="form-control" id="diff" readonly="true">
                <input type="hidden" class="form-control" id="price_factory" readonly="true">
                <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" onkeyup="updateAmount()">
            </div>
            <div class="form-group col-xs-12">
                <label for="disabled_price_unit">ราคาเปิดต่อหน่วย //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                <input type="text" class="form-control" id="price" readonly="true">
            </div>
            <div class="form-group col-xs-12">
                <label for="disabled_price_unit">ราคาเปิดทั้งหมด //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                <input type="text" class="form-control" id="total_price" readonly="true">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <p id="alertPass"></p>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-default" onclick="addProduct();" data-dismiss="modal">Save</button>
</div>

<script>

    function addProduct() {
        var idorder = <?= $idorder; ?>;
        var idUnit = $("#idUnit").val();
        var productName = $("#idproduct").val();
        var factoryName = $("#idfactory").val();
        var AmountProduct = $("#AmountProduct").val();
        var price = $("#price").val();
        var total_price = $("#total_price").val();
        var x = parseFloat(document.getElementById('total_price_all').value);
        var total_price_all = x + (AmountProduct * price);
        document.getElementById("total_price_all").value = total_price_all;
        //alert(idUnit);
        //alert(AmountProduct);
        //alert(DifferencePer);
        //alert(DifferenceBath);
        var p = "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&AmountProduct=" + AmountProduct + "&price=" + price + "&total_price=" + total_price + "&total_price_all=" + total_price_all + "&idorder=" + idorder;
        alert(p);
        $.get("action_editProduct.php?p=addProduct" + p, function (data, status) {
            alert("Data: " + data + "\nStatus: " + status);
            if (data == "1") {
                $("#alert").html("บันทึกแล้ว");
                $("#idUnit").val("");
                $("#productName").val("");
                $("#factoryName").val("");
                $("#AmountProduct").val("");
                $("#price").val("");
                $("#total_price").val("");
                showUnit();
            }
            else {
                $("#idUnit").val("");
                $("#productName").val("");
                $("#factoryName").val("");
                $("#AmountProduct").val("");
                $("#price").val("");
                $("#total_price").val("");
                showUnit();
            }
        });
        window.location.href = 'edit_product_refunds.php?idorder=' + idorder;
    }

</script>
