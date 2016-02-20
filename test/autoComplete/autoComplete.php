<?php require_once '../../interface_add_order/function/func_addorder.php'; ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>jQuery UI Autocomplete - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script>
            $(function () {
                var availableTags = [
                    "ActionScript",
                    "AppleScript",
                    "Asp",
                    "BASIC",
                    "C",
                    "C++",
                    "Clojure",
                    "COBOL",
                    "ColdFusion",
                    "Erlang",
                    "Fortran",
                    "Groovy",
                    "Haskell",
                    "Java",
                    "JavaScript",
                    "Lisp",
                    "Perl",
                    "PHP",
                    "Python",
                    "Ruby",
                    "Scala",
                    "Scheme"
                ];
                $("#tags").autocomplete({
                    source: availableTags
                });
            });


            var data = JSON.stringify(<?php echo getShop2(); ?>);//ดึงค่า
            var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
            //alert(Obj);
            var shopName = new Array();
            var shopId = new Array();
            //pushข้อมูลลงArray
            for (var i = 0; i < Obj.length; i++) {
                shopName.push(Obj[i].name_shop);
                shopId["'" + Obj[i].name_shop + "'"] = Obj[i].idshop;
            }
            $(function () {
                $("#code_order").autocomplete({
                    source: shopName
                });
            });
//            function getShopId() {
//                var shop = document.getElementById("code_order").value;
//                idshop = shopId["'" + shop + "'"];
//                //alert(idshop);
//                $("#test").text(idshop);//ใช้กับ<a href="#" id="test">text</a>
//               // $("#test").val(idshop);//ใช้กับ<input type="button" value="" id="test"/>
//            }
            function getShopId(e) {//ใช้กับ<input type="text" id="code_order" autocomplete=on name="code_order" onkeypress="getShopId(event)"  >
                //alert(e);
                //alert(e.keyCode);
                if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {//$('#myText').live("keypress", function(e) {
                    //alert("go");
                    var shop = document.getElementById("code_order").value;
                    idshop = shopId["'" + shop + "'"];
                    $("#test").text(idshop);
                }
                return false;
            }
//            $('#code_order').live("keypress", function(e) {
//                if (e.keyCode === 13) {
//                    var shop = document.getElementById("code_order").value;
//                    idshop = shopId["'" + shop + "'"];
//                    $("#test").text(idshop);
//                    
//                }
//                return false;
//            });

        </script>
    </head>
    <body>

        <div class="ui-widget">
            <label for="tags">Tags: </label>
            <input id="tags">
            <label for="code_order" >code_order: </label>
            <input type="text" id="code_order" autocomplete=on name="code_order" onblur ="getShopId(event)" onkeypress="getShopId(event)">
            <!--<input type="text" id="code_order" autocomplete=on name="code_order"   >-->
            <p id="aa"></p>
            <input type="button" value="" />
            <a href="#" class="btn btn-warning " data-toggle="modal" data-target="#myModal" title="แก้ไข" id="test"></a>
        </div>


    </body>
</html>