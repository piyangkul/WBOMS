
<?php require_once '../history_pay_factory/function/func_history_pay_factory.php'; ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>jQuery UI Autocomplete - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
        <script>
            var idfactory;
            var data = JSON.stringify(<?php echo getFactory(); ?>);//ดึงค่า
            var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
            //alert(Obj);
            var factoryName = new Array();
            var factoryId = new Array();
            //pushข้อมูลลงArray
            for (var i = 0; i < Obj.length; i++) {
                factoryName.push(Obj[i].name_factory);
                factoryId["'" + Obj[i].name_factory + "'"] = Obj[i].idfactory;
            }
            $(function () {
                $("#code_order").autocomplete({
                    source: factoryName
                });
            });

            function getFactoryId(e) {//ใช้กับ<input type="text" id="code_order" autocomplete=on name="code_order" onkeypress="getShopId(event)"  >
                //alert(e);
                //alert(e.keyCode);
                if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {//$('#myText').live("keypress", function(e) {
                    //alert("go");
                    var factory = document.getElementById("code_order").value;
                    idfactory = factoryId["'" + factory + "'"];
                    $("#test").text(idfactory);
                    show_pay_factory_table(); 
                }
                return false;
            }
        </script>
    </head>
    <body>

        <div class="ui-widget">
            <label for="code_order" >code_order: </label>
            <input type="text" id="code_order" autocomplete=on name="code_order" onblur ="getFactoryId(event)" onkeypress="getFactoryId(event)">
            <!--<input type="button" value="" />-->
            <!--<a href="#" class="btn btn-warning " data-toggle="modal" data-target="#myModal" title="แก้ไข" id="test"></a>-->
        </div>
        <div class="row">
            <div class="col-md-1"></div>                        
            <div class="col-md-10 ">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <label>ข้อมูลการจ่ายเงินโรงงานรายเดือน-ปี</label>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" id="show_pay_factory_table">
                            <!--show_pay_factory_table--> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <script>
        show_pay_factory_table(); 
        function show_pay_factory_table() {
            //var idfactory = $("#test").val();
            $.get("../history_pay_factory/action/action_pay_factory_show.php?idfactory=" + idfactory, function (data, status) {
                $("#show_pay_factory_table").html(data);
            });
        }
    </script>
</html>