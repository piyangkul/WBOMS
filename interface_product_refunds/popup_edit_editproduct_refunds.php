<?php require_once 'function/func_addorder.php'; ?>
<?php
session_start();
$idproduct_refunds = $_GET['idproduct_refunds'];
$idorder_product_refunds = $_GET['idorder_product_refunds'];
//echo $idorder_product_refunds;
$getEdit = get_edit_product_refunds($idproduct_refunds);
$idunit = $getEdit['idunit'];
$amount = $getEdit['amount_product_refunds'];
$price = $getEdit['price_product_refunds'];
$total = $price * $amount;
$getUnit = getUnit3($idunit);
$idProduct = $getUnit['idproduct'];
$nameUnit = $getUnit['name_unit'];
$nameFactory = $getUnit['name_factory'];
$nameProduct = $getUnit['name_product'];
$idFactory = $getUnit['idfactory'];
$total_price_all = 0;
$idshop = $_GET['idshop'];
$getProductRefunds = getProductRefunds_total($idorder_product_refunds, $idproduct_refunds);
foreach ($getProductRefunds as $value) {
    $val_price = $value['price_product_refunds'];
    $val_amount = $value['amount_product_refunds'];
    $total_price_all += $val_price * $val_amount;
}
$getHisdiff = hisDiff($idProduct, $idshop);
$diff = $getHisdiff['price_difference'];
//$getTotal =
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
    <h4 class="modal-title" id="myModalLabel">แก้ไขสินค้า</h4>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
            </div>
            <div class="form-group col-xs-12">
                <label for="name_product">ชื่อสินค้า</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="กรุณาระบุชื่อสินค้า" value ="<?= $nameProduct ?>" disabled=""></input>
                <input type="hidden" id="idproduct" name="idproduct" value="<?= $idProduct; ?>">
                <h id="idFactory2"></h>
                <input type="hidden" class="form-control" id="factoryName" name="factoryName" placeholder="กรุณาระบุชื่อสินค้า" value ="<?= $nameFactory ?>" disabled></input>
                <input type="hidden" id="idfactory" name="idfactory" value ="<?= $idFactory; ?>">
                <input type="hidden" class="form-control" id="typefactory" name="typefactory">
                <input type="hidden" class="form-control" id="idshop" name="idshop" value="<?= $idshop; ?>">
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;">
                <label for="name_product"> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>
                <select class="form-control" id="idUnit" name="idUnit" onchange="LoadData(this.value)" required>
                    <option selected value="<?= $idunit ?>"><?= $nameUnit ?></option>   
                    <?php
                    $getUnit = edit_unit($idProduct, $idunit);
                    foreach ($getUnit as $value) {
                        $val_idunit = $value['idunit'];
                        $val_name_unit = $value['name_unit'];
                        ?>
                        <option value="<?= $val_idunit; ?>"><?= $val_name_unit; ?></option><?php
                    }
                    ?>     
                </select>                
                <div id="tee"></div>
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;">
                <label for="amount_product">จำนวน</label>
                <input type="hidden" class="form-control" id="diff" readonly="true" value="<?= $diff; ?>">
                <input type="hidden" class="form-control" id="price_factory" readonly="true">
                <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" value ="<?= $amount; ?>" onkeyup="updateAmount()">
            </div>
            <div class="form-group col-xs-12">
                <label for="disabled_price_unit">ราคาเปิดต่อหน่วย //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>

                <input type="text" class="form-control" id="price" readonly="true" value="<?= number_format($price, 2); ?>">
            </div>
            <div class="form-group col-xs-12">
                <label for="disabled_price_unit">ราคาเปิดทั้งหมด //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                <input type="text" class="form-control" id="total_price" readonly="true" value ="<?= number_format($total, 2); ?>">
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <p id="alertPass"></p>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="editProduct();" data-dismiss="modal">Save changes</button>
</div>

<script>

    function editProduct() {
        var idorder = <?= $idorder_product_refunds; ?>;
        var idUnit = $("#idUnit").val();
        var productName = $("#idproduct").val();
        var factoryName = $("#idfactory").val();
        var AmountProduct = $("#AmountProduct").val();
        var price = $("#price").val().replace(",", "");
        var total_price = $("#total_price").val().replace(",", "");
        var idproduct_refunds = <?= $idproduct_refunds ?>;
        var x = parseFloat(<?= $total_price_all; ?>);
        var total_price_all = x + (AmountProduct * price);
        document.getElementById("total_price_all").value = total_price_all;
        //alert(total_price_all);
        var p = "&idproduct_refunds=" + idproduct_refunds + "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&AmountProduct=" + AmountProduct + "&price=" + price + "&total_price=" + total_price + "&total_price_all=" + total_price_all + "&idorder=" + idorder;
        //alert(p);
        $.get("action_editProductE.php?p=editProduct" + p, function (data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
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
        document.getElementById("amount<?= $idproduct_refunds; ?>").innerHTML = AmountProduct;
        document.getElementById("price_table<?= $idproduct_refunds; ?>").innerHTML = price;
        document.getElementById("total_table<?= $idproduct_refunds; ?>").innerHTML = total_price;
        window.location.href = 'edit_product_refunds.php?idorder=' + idorder;
    }

</script>
