<?php require_once 'function/func_addorder.php'; ?>
<?php
session_start();
$idproduct_refunds = $_GET['idproduct_refunds'];
$idunit = $_GET['idunit'];
$amount = $_GET['amount'];
$price = $_GET['price'];
$total = $_GET['total_price'];
$diff = $_GET['diff'];
$price_factory = $_GET['price_factory'];
$getUnit = getUnit3($idunit);
$idProduct = $getUnit['idproduct'];
$nameUnit = $getUnit['name_unit'];
$nameFactory = $getUnit['name_factory'];
$nameProduct = $getUnit['name_product'];
$idFactory = $getUnit['idfactory'];
$type_factory = $getUnit['type_factory'];
echo $type_factory;
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
                <label>ชื่อสินค้า</label>
                <div class="input-group ui-front">
                    <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                    <input type="text" class="form-control" id="name_product" name="name_product" placeholder="กรุณาระบุชื่อสินค้า" onblur="getProductID()" autocomplete= "on" value="<?= $nameProduct; ?>" disabled></input>
                    <input type="hidden" id="idproduct" name="idproduct" value="<?= $idProduct; ?>">
                    <input type="hidden" class="form-control" id="name_factory" name="name_factory" placeholder="กรุณาระบุชื่อสินค้า" value="<?= $nameFactory; ?>" disabled>
                    <input type="hidden" id="idfactory" name="idfactory" value="<?= $idFactory ?>">
                    <input type="hidden" class="form-control" id="typefactory" name="typefactory" value="<?= $type_factory; ?>">
                    <input type="hidden" class="form-control" id="idshop" name="idshop" value="<?= $_SESSION['idshop']; ?>">
                    <input type="hidden" id="idFactory2">
                </div>
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;"> 
                <label> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>
                <select class="form-control" id="idUnit" name="idUnit" onchange="LoadData(this.value)" required>
                    <option value="<?= $idunit ?>"><?= $nameUnit; ?></option>
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
                <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" value ="<?= $amount; ?>" onkeyup="updateAmount()">
            </div>
            <!--<div class="form-group col-xs-12">
                <label>ส่วนลดปัจจุบัน</label>
                
            </div>
            <div class="form-group col-xs-12">
                <label>ราคาเปิดต่อหน่วย</label>

            </div>-->
            <div class="form-group col-xs-12">
                <label>ราคาคืนต่อหน่วย</label>
                <input type="hidden" class="form-control" id="price_factory" readonly="true" value="<?= number_format($price_factory, 2); ?>">
                <input type="hidden" class="form-control" id="diff" readonly="true" value="<?= $diff ?>">

                <input type="text" class="form-control" id="price" readonly="true" value="<?= number_format($price, 2); ?>" onkeyup="updateAmount()">
            </div>
            <div class="form-group col-xs-12">
                <label>ราคาคืนทั้งหมด</label>
                <input type="text" class="form-control" id="total_price" readonly="true" onkeyup="updateAmount()" value ="<?= number_format($total, 2); ?>">
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
        var idUnit = $("#idUnit").val();
        var productName = $("#idproduct").val();
        var factoryName = $("#idfactory").val();
        var AmountProduct = $("#AmountProduct").val();
        var price = $("#price").val().replace(',', '');
        var total_price = $("#total_price").val().replace(',', '');
        var diff = $("#diff").val()
        var price_factory = $("#price_factory").val().replace(',', '');
        var type_factoty = $("#typefactory").val();
        var idproduct_refunds = <?= $idproduct_refunds ?>;
        //alert(idUnit);
        //alert(AmountProduct);
        //alert(DifferencePer);
        //alert(DifferenceBath);
        var p = "&idproduct_refunds=" + idproduct_refunds + "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&AmountProduct=" + AmountProduct + "&price=" + price + "&total_price=" + total_price + "&typefactory=" + type_factoty + "&price_factory=" + price_factory + "&diff=" + diff;
        //alert(p);
        $.get("action_addProduct.php?p=editProduct" + p, function (data, status) {
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
    }

</script>
