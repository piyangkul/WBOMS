<!--<form class="form" action="add_product.php" method="POST">-->
<?php require_once 'function/func_product.php'; ?>
<?php
session_start();
$val_idproduct = $_GET['idproduct'];
echo $val_idproduct;
$price_unit = 0;
$val_idunit;
$val_name_unit;
$val_price = 0;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">เพิ่มหน่วยสินค้า</h4>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
                <!--<p id="alert"></p>-->
            </div>
            <div class="form-group col-xs-12">
                <label for="NameUnit">ชื่อหน่วยสินค้ารอง</label>
                <input type="text" class="form-control" name="NameUnit" id="NameUnit" placeholder="ใส่หน่วยสินค้า เช่น(กล่อง)" >
                <input type="text" class="form-control" name="idProduct" id="idProduct" value=" <?= $val_idproduct ?>">
            </div>
            <div class="form-group col-xs-12">
                <label for="AmountPerUnit">จำนวนต่อหน่วยรอง</label>
                <input type="text" class="form-control" name="AmountPerUnit" onkeyup="calPrice();" id="AmountPerUnit" placeholder="ใส่จำนวนต่อหน่วยรอง เช่น(2)" >
            </div>
            <div class="form-group col-xs-12">
                <label for="under_unit">หน่วยใหญ่ที่จะเปรียบเทียบ</label>
            </div>
            <div class="form-group col-xs-12">
                <select class="form-control" name="under_unit" id="under_unit" onchange="calPriceS();">
                    <?php
                    $getUnitAdd = getUnitAdd($val_idproduct);
                    foreach ($getUnitAdd as $value) {
                        $val_nameunit = $value['name_unit'];
                        $val_idunit = $value['idunit'];
                        $val_price = $value['price_unit'];
                        ?> 
                    <?php } ?>
                    <option value="<?php echo $val_idunit; ?>"><?php echo $val_nameunit; ?></option>
                </select>
            </div>

            <div class="form-group col-xs-12">
                <label for="price">ราคาต่อหน่วยสินค้า</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="0" value="<?= $val_price; ?>" readonly>
                <input type="hidden" id="ajaxprice" value="<?= $val_price; ?>">
            </div>
            <div class="form-group col-xs-12">
                <div class="col-md-12 col-sm-12 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <label>ประเภทหน่วยสินค้า</label>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive ">
                                <label class="radio-inline">
                                    <input type="radio" name="type" id="type" value="primary"> ขาย
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type" id="type" value="second"> ไม่ขาย
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="addUnit();" data-dismiss="modal">Save</button>
    <!--<button type="button" onclick="addUnit();" class="btn btn-primary">Save changes</button>-->
</div>
<!--</form>-->

<script>
    function addUnit() {
        var idproduct = $("#idProduct").val();
       // alert(idproduct);
        var NameUnit = $("#NameUnit").val();
        var AmountPerUnit = $("#AmountPerUnit").val();
        var under_unit = $("#under_unit").val();
        var price = $("#price").val();
        var type = $("input:radio[name=type]:checked").val();

        var p = "&NameUnit=" + NameUnit + "&AmountPerUnit=" + AmountPerUnit + "&idUnitBig=" + under_unit + "&price=" + price + "&type=" + type + "&idproduct=" + idproduct;
//        alert(p);
        $.get("action_editUnitA.php?p=addUnit" + p, function (data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            if (data == "1") {
//                $("#alert").html("บันทึกแล้ว")
                $("#NameUnit").val("");
                $("#AmountPerUnit").val("");
                $("#under_unit").val("");
            }
            else {
                $("#NameUnit").val("");
                $("#AmountPerUnit").val("");
                $("#under_unit").val("");
            }
        });

        window.location.href = 'edit_product.php?idproduct=' + idproduct;
    }
    /*chkUnitAdd();
     function chkUnitAdd() { // Check to add the first time 
     $.get("action_addUnit.php?p=chkUnitAdd", function (data, status) {
     //            alert(data);
     if (data == '1') {
     $("#price").prop("readonly", true);
     $("#under_unit").prop("disabled", false);
     }
     else {
     $("#price").prop("readonly", false);
     $("#under_unit").prop("disabled", true);
     $("#AmountPerUnit").val(1);
     $("#AmountPerUnit").prop("readonly", true);
     }
     });
     }*/

    /* function calPriceS() {
     var str = document.getElementById("under_unit").value;
     //var amount = document.getElementById("AmountProduct").value;
     
     $.ajax({type: "GET",
     url: "action/ajax_price_unit.php",
     async: false,
     data: "q=" + str,
     dataType: 'html',
     success: function (response)
     {
     $("#ajaxprice").val(response);
     }
     });
     
     }*/
    function calPrice() {
        var amount = document.getElementById("AmountPerUnit").value;
        var price = document.getElementById("ajaxprice").value;
        var total = price / amount;
        document.getElementById("price").value = total;
    }
</script>