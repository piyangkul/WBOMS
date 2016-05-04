<?php
require_once 'function/func_shipment.php';
$idshipment_period = $_GET['idshipment_period'];
$getShipment_period = getShipment_periodByID($idshipment_period);
$val_date_start = $getShipment_period['date_start'];
$change_date_start = date("d-m-Y", strtotime($val_date_start));
$val_date_end = $getShipment_period['date_end'];
$change_date_end = date("d-m-Y", strtotime($val_date_end));

$idfactory = $_GET['idfactory'];
$getFactory = getFactoryByID($idfactory);
$val_name_factory = $getFactory['name_factory'];

$status_shipment_factory = $_GET['status_shipment'];
$price = $_GET['price']; //ใช้ไม่ได้
?>
<script>
    var idtransport;
    var data = JSON.stringify(<?php echo getTransport(); ?>);//ดึงค่า
    var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
    //alert(Obj);
    var Arr = new Array();
    var JSON_transportCode = new Array();
    var JSON_transportName = new Array();
    //pushข้อมูลลงArray
    for (var i = 0; i < Obj.length; i++) {
        //Arr.push(Obj[i].code_transport);
        Arr.push(Obj[i].name_transport + " (" + Obj[i].code_transport + ")");
        JSON_transportCode["'" + Obj[i].code_transport + "'"] = Obj[i].idtransport;
        JSON_transportName["'" + Obj[i].name_transport + "'"] = Obj[i].idtransport;
        console.log(JSON_transportCode);
        console.log(JSON_transportName);
    }
    $(function () {
        $("#idtransport").autocomplete({
            source: Arr
        });
    });

    function getFactoryId(e) {
        if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {
            var input = document.getElementById("idtransport").value;
            //alert(input);
            firstParen = input.lastIndexOf("(");
            secondParen = input.lastIndexOf(")");
            input = input.substr(firstParen + 1, secondParen - firstParen - 1);
            //alert(input+ firstParen +","+ secondParen);
            if (JSON_transportCode["'" + input + "'"] != null) {
                idtransport = JSON_transportCode["'" + input + "'"];
            }
            else {
                idtransport = JSON_transportName["'" + input + "'"];
            }
            console.log(idtransport);
            //$("#test").text(idtransport);
            document.getElementById("id").value = idtransport;
        }
        return false;
    }
</script>
<form class="form" action="action/action_addShipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลการส่งสินค้า</h4>
    </div>
    <input type="hidden" id="idfactory" value="<?php echo $idfactory; ?>">
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_transport">วันที่ส่งสินค้า</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"  ></i></span>
                        <input type="date" class="form-control" min="<?php echo date("$val_date_start"); ?>" max="<?php echo date("$val_date_end"); ?>" name="date_transport" id="date_transport" onchange="show_product_order()" required/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport">รหัสหรือชื่อบริษัทขนส่ง</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-truck" ></i></span>
                        <input type="text" class="form-control" id="idtransport" autocomplete=on name="idtransport_show" placeholder="กรอกรหัสหรือชื่อบริษัทขนส่ง" onblur ="getFactoryId(event)" onkeypress="getFactoryId(event)" required >
                        <input type="hidden" id="id" name="idtransport" required>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="volume">เล่มที่</label><label class="text-danger">*กรณีไม่มี ใส่00</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเล่มที่ " name="volume" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' required />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="number">เลขที่</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเลขที่" name="number" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' required />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="price_transport">ค่าส่งสินค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar" ></i></span>
                        <input type="text" class="form-control" id="price_transport" name ="price_transport" value="0" onkeypress='return event.charCode >= 48 && event.charCode <= 57;' />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class = "col-md-1 col-sm-1 "></div>
            <div class = "col-md-10 col-sm-10 ">
                <!-- ตารางรายการสินค้า -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <label>ตารางรายการสินค้าที่สั่ง</label>
                    </div>
                    <div class="table-responsive" id="show_product_order">
                        <!-- action_product_order_show -->
                    </div>
                </div>
                <!--End ตารางรายการสินค้า -->
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="btn_save" disabled name="sumbit" class="btn btn-primary">Save changes</button>
    </div>
</form>
<script>
    show_product_order();
    function show_product_order() {
        var idfactory = $("#idfactory").val();
        var date_transport = $("#date_transport").val();
        $.get('action/action_product_order_show.php?idfactory=' + idfactory + '&date_transport=' + date_transport, function (data, status) {//+"&id="+
            $("#show_product_order").html(data);
        });
    }
    var cc = 0;
    function chkCount(id) {
        if ($("#check_shipment_" + id).prop("checked")) {
            cc++;
        }
        else {
            cc--;
        }
        if (cc <= 0) {
            $("#btn_save").prop("disabled", true);
        }
        else {
            $("#btn_save").prop("disabled", false);
        }
    }


</script>
<!--<button type="submit" id="btn_save" disabled name="sumbit" class="btn btn-primary" onclick="return confirm('กรุณาตรวจสอบความถูกต้องข้อมูลการส่งสินค้าเนื่องจากจะไม่สามารถแก้ไขข้อมูลการส่งได้');">Save changes</button>-->
<!--<script>
<button type="submit" name="sumbit" class="btn btn-primary" onclick="chkTransport()">Save changes</button>
function chkTransport() {
    var test = $("#idtransport").val();
    var date_transport = $("#date_transport").val();
    var check_shipment = $("#check_shipment").val();
    if (test != "" && date_transport != "" && check_shipment != "") {

        if (confirm('กรุณาตรวจสอบความถูกต้องข้อมูลการส่งสินค้าเนื่องจากจะไม่สามารถแก้ไขข้อมูลการส่งได้')) {
            alert('Yes');

        } else {
            alert('cancel');
            return false;
        }
    }
}
</script>-->
<!--<div class="alert alert-danger" role="alert">แก้ 1.required checkbox 2.กดปุ่มยกเลิกไม่ได้ </div>-->