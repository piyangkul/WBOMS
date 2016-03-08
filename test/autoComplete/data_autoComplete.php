<?php require_once '../../interface_add_order/function/func_addorder.php'; ?>
<script>
    var data = JSON.stringify(<?php echo getShop2(); ?>);//ดึงค่า
    var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
//            alert(Obj);
    var Arr = new Array();
    var JSON_shop = {};
    //var JSON_name_shop = new Array();
    //pushข้อมูลลงArray
    for (var i = 0; i < Obj.length; i++) {
        JSON_shop["tel"] = Obj[i].tel_shop;
        JSON_shop["name"] = Obj[i].name_shop;
        Arr.push(JSON_shop);
//                Arr.push(Obj[i].tel_shop);
//                Arr.push(Obj[i].name_shop);
//                JSON_tel_shop["tel"] = Obj[i].tel_shop;
//                JSON_name_shop["name"] = Obj[i].name_shop;
//                JSON_name_shop["" + Obj[i].name_shop + "'"] = Obj[i].idshop;
//                alert(shopId["'" + Obj[i].tel_shop + "'"]);
        console.log(JSON.stringify(JSON_shop));
//                console.log(JSON_name_shop);
    }
    console.log(JSON.stringify(Arr));
    var a = JSON.stringify(Arr);
    //return a;
 
</script>
<?php
echo "<script>document.writeln(a);</script>";
?>