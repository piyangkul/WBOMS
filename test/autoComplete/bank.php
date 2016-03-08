<?php
require_once '../../shipment/function/func_shipment.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>jQuery UI Autocomplete - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script>
            var data = JSON.stringify(<?php echo getBank(); ?>);//ดึงค่า
            var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
            //alert(Obj);
            var Arr = new Array();
            //pushข้อมูลลงArray
            for (var i = 0; i < Obj.length; i++) {
                Arr.push(Obj[i].cheque_name_bank);
                Arr.push(Obj[i].cheque_branch_bank);
            }
            $(function () {
                $("#cheque_name_bank").autocomplete({
                    source: Arr
                });
            });
            $(function () {
                $("#cheque_branch_bank").autocomplete({
                    source: Arr
                });
            });
        </script>
    </head>
    <body>

        <div class="ui-widget">
            <!--            <label for="tags">Tags: </label>
                        <input id="tags">-->
            <label for="code_order" >code_order: </label>
<!--            <input type="text" id="code_order" autocomplete=on name="code_order" onblur ="getShopId(event)" onkeypress="getShopId(event)">
            <a href="#" class="btn btn-warning " data-toggle="modal" data-target="#myModal" title="แก้ไข" id="test"></a>-->
             <input type="text" class="form-control" autocomplete=on id="cheque_name_bank" name="cheque_name_bank">
             <input type="text" class="form-control" autocomplete=on id="cheque_branch_bank" name="cheque_name_bank">
        </div>

    </body>
</html>