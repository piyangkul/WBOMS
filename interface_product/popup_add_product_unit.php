<!--<form class="form" action="add_product.php" method="POST">-->
<?php
session_start();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">หน่วยสินค้า</h4>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
                <!--<p id="alert"></p>-->
            </div>
            <?php if (isset($_SESSION['countUnit'])) { ?>
                <div class="form-group col-xs-12">
                    <label for="under_unit">หน่วยใหญ่ที่จะเปรียบเทียบ</label>
                    <select class="form-control" name="under_unit" id="under_unit" onchange="calPrice();" readonly>
                        <option value="<?php echo $_SESSION["countUnit"]; ?>"><?php echo $_SESSION["unit"][$_SESSION["countUnit"]]["NameUnit"]; ?></option>
                    </select>
                </div>
            <?php } else { ?>
                <div class="form-group col-xs-12">
                    <label for="under_unit">หน่วยใหญ่ที่จะเปรียบเทียบ</label>
                    <select class="form-control" name="under_unit" id="under_unit" onchange="calPrice();" >
                        <option value="">ไม่มีหน่วยสินค้าเปรียบเทียบ</option>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group col-xs-12">
                <label for="AmountPerUnit">จำนวนต่อหน่วยใหญ่</label>
                <input type="text" class="form-control" name="AmountPerUnit" onkeyup="calPrice();" id="AmountPerUnit" placeholder="ใส่จำนวนต่อหน่วยรอง เช่น(2)" >
            </div>
            <div class="form-group col-xs-12">
                <label for="NameUnit">ชื่อหน่วยสินค้า</label>
                <input type="text" class="form-control" name="NameUnit" id="NameUnit" placeholder="ใส่หน่วยสินค้า เช่น(กล่อง)" >
            </div>
            <?php if (isset($_SESSION['countUnit'])) { ?>
                <div class="form-group col-xs-12">
                    <label for="price">ราคาต่อหน่วยสินค้า</label>
                    <input type="hidden" class="form-control" id="priceS" name="priceS" value="<?= $_SESSION["unit"][$_SESSION["countUnit"]]["price"] ?>" readonly>
                    <input type="text" class="form-control" id="price" name="price" placeholder="0" value="<?= number_format($_SESSION["unit"][$_SESSION["countUnit"]]["price"], 2); ?>" readonly>

                </div>
            <?php } else { ?>
                <div class="form-group col-xs-12">
                    <label for="price">ราคาต่อหน่วยสินค้า</label>
                    <input type="hidden" class="form-control" id="priceS" name="priceS" value="" readonly>
                    <input type="text" class="form-control" id="price" name="price" placeholder="0" value="" readonly>

                </div>
            <?php } ?>
            <div class="form-group col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <label>ประเภทหน่วยสินค้า</label>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive ">
                            <label class="radio-inline">
                                <input type="radio" name="type" id="type" value="primary" checked required> ขาย
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
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="addUnit();" data-dismiss="modal">Save changes</button>
    <!--<button type="button" onclick="addUnit();" class="btn btn-primary">Save changes</button>-->
</div>
<!--</form>-->

<script>
    function addUnit() {
        if (document.getElementById('NameUnit').value.length > 0 && document.getElementById('AmountPerUnit').value.length > 0 && document.getElementById('price').value.length > 0){
            var NameUnit = $("#NameUnit").val();
            var AmountPerUnit = $("#AmountPerUnit").val();
            var under_unit = $("#under_unit").val();
            var price = $("#price").val();
            var type = $("input:radio[name=type]:checked").val();

            var p = "&NameUnit=" + NameUnit + "&AmountPerUnit=" + AmountPerUnit + "&under_unit=" + under_unit + "&price=" + price + "&type=" + type;
//        alert(p);
            $.get("action_addUnit.php?p=addUnit" + p, function (data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                if (data == "1") {
//                $("#alert").html("บันทึกแล้ว")
                    $("#NameUnit").val("");
                    $("#AmountPerUnit").val("");
                    $("#under_unit").val("");
                    showUnit();
                    getBigestUnit();
                    getBigestPrice();
                }
                else {
                    $("#NameUnit").val("");
                    $("#AmountPerUnit").val("");
                    $("#under_unit").val("");
                    showUnit();
                    getBigestUnit();
                    getBigestPrice();
                }
            });
        }else{
            alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        }
    }
    chkUnitAdd();
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
    }

    function calPrice() {
        var subUnitAmount = $("#AmountPerUnit").val();
        var priceS = $("#priceS").val().replace(",", "");
        document.getElementById('price').value = (priceS / subUnitAmount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

    }
</script>