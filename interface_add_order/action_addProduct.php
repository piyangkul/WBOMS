<?php
require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();

//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $difference = $_GET['difference'];
    $DifferencePer = $_GET['DifferencePer'];
    $DifferenceBath = $_GET['DifferenceBath'];
    $price = $_GET['price'];
    $total_price = $_GET['total_price'];
    $total = $_GET['total'];
    $type = $_GET['type'];

    if (isset($_SESSION["countProduct"])) {
        $_SESSION["countProduct"] ++;
    } else
        $_SESSION["countProduct"] = 1;
    $_SESSION["product"][$_SESSION["countProduct"]]["idUnit"] = $idUnit;
    $_SESSION["product"][$_SESSION["countProduct"]]["productName"] = $productName;
    $_SESSION["product"][$_SESSION["countProduct"]]["factoryName"] = $factoryName;
    $_SESSION["product"][$_SESSION["countProduct"]]["AmountProduct"] = $AmountProduct;
    $_SESSION["product"][$_SESSION["countProduct"]]["difference"] = $difference;
    $_SESSION["product"][$_SESSION["countProduct"]]["DifferencePer"] = $DifferencePer;
    $_SESSION["product"][$_SESSION["countProduct"]]["DifferenceBath"] = $DifferenceBath;
    $_SESSION["product"][$_SESSION["countProduct"]]["price"] = $total / $AmountProduct;
    $_SESSION["product"][$_SESSION["countProduct"]]["total_price"] = $total_price;
    $_SESSION["product"][$_SESSION["countProduct"]]["total"] = $total;
    $_SESSION["product"][$_SESSION["countProduct"]]["type"] = $type;
    echo "1";
}

else if ($_GET['p'] == "editProduct") {
    $product_order = $_GET['idproduct_order'];
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $difference = $_GET['difference'];
    $DifferencePer = $_GET['DifferencePer'];
    $DifferenceBath = $_GET['DifferenceBath'];
    $price = $_GET['price'];
    $total_price = $_GET['total_price'];
    $total = $_GET['total'];
    $type = $_GET['type'];

    $_SESSION["product"]["$product_order"]["idUnit"] = $idUnit;
    $_SESSION["product"]["$product_order"]["productName"] = $productName;
    $_SESSION["product"]["$product_order"]["factoryName"] = $factoryName;
    $_SESSION["product"]["$product_order"]["AmountProduct"] = $AmountProduct;
    $_SESSION["product"]["$product_order"]["difference"] = $difference;
    $_SESSION["product"]["$product_order"]["DifferencePer"] = $DifferencePer;
    $_SESSION["product"]["$product_order"]["DifferenceBath"] = $DifferenceBath;
    $_SESSION["product"]["$product_order"]["price"] = $total / $AmountProduct;
    $_SESSION["product"]["$product_order"]["total_price"] = $total_price;
    $_SESSION["product"]["$product_order"]["total"] = $total;
    $_SESSION["product"]["$product_order"]["type"] = $type;

    echo "1";
} else if ($_GET['p'] == "delProduct") {
    $product_order = $_GET['idproduct_order'];
    if (isset($_SESSION["countProduct"]["$product_order"])) {
        unset($_SESSION["countProduct"]["$product_order"]["total"]);
        echo 1;
    }
    echo 1;
}
//    echo $_SESSION["countUnit"];
/* if (isset($_SESSION["countUnit"])) {
  echo 1;
  } else
  echo 0;
  }
  else if ($_GET['p'] == "getPriceUnit") {
  $id = $_GET['id'];
  //    echo "$id ";
  echo $_SESSION["unit"][$id]["price"];
  } else if ($_GET['p'] == "getBigestUnit") {
  if (isset($_SESSION["countUnit"])) {
  echo $_SESSION["unit"][1]["NameUnit"];
  } else {
  echo "-1";
  }
  } else if ($_GET['p'] == "getBigestPrice") {
  if (isset($_SESSION["countUnit"])) {
  echo $_SESSION["unit"][1]["price"];
  } else {
  echo "-1";
  }
  } */ else if ($_GET['p'] == "resetUnit") {
    if (isset($_SESSION["countProduct"])) {
        unset($_SESSION["countProduct"]);
        unset($_SESSION["product"]);
        echo 1;
    } else {
        echo -1;
    }
} else if ($_GET['p'] == "showUnit") {
    $sum = 0;
    ?>
    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อสินค้า</th>
                <th>ชื่อโรงงาน</th>
                <th>หน่วย</th>
                <th>จำนวน</th>
                <th>ราคาเปิด</th>
                <th>ต้นทุนลด%</th>
                <th>ขายลด%</th>
                <th>ขายเพิ่มสุทธิ</th>
                <th>ราคาขาย</th>
                <th>การกระทำ</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION["countProduct"])) {

                for ($i = 1; $i <= $_SESSION["countProduct"]; $i++) {
                    $sum += $_SESSION["product"][$i]["total"] * $_SESSION["product"][$i]["AmountProduct"];
                    //$j = $_SESSION["unit"][$i]["under_unit"];
                    $idUnitS = $_SESSION["product"][$i]["idUnit"];
                    $idFactoryS = $_SESSION["product"][$i]["factoryName"];
                    $idProductS = $_SESSION["product"][$i]["productName"];
                    //echo $s;
                    //$getUnit = getUnit2($s);
                    //$val_name_unit = $getUnit('name_unit');
                    ?>

                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php
                            $getProduct = getProduct2($idProductS);
                            foreach ($getProduct as $value) {
                                $val_name_product = $value['name_product'];
                                echo $val_name_product;
                            }
                            ?></td>
                        <td><?php
                            $getFactory = getFactory2($idFactoryS);
                            foreach ($getFactory as $value) {
                                $val_name_factory = $value['name_factory'];
                                echo $val_name_factory;
                            }
                            ?></td>
                        <td><?php
                            $getUnit = getUnit2($idUnitS);
                            //print_r($getUnit);;
                            foreach ($getUnit as $value) {
                                $val_name_unit = $value['name_unit'];
                                echo $val_name_unit;
                            }
                            ?></td>
                        <td><?php echo $_SESSION["product"][$i]["AmountProduct"]; ?></td>
                        <td  class ="text-right"><?php echo number_format($_SESSION["product"][$i]["total_price"],2); ?></td>
                        <td><?php echo $_SESSION["product"][$i]["difference"]; ?></td>
                        <td><?php echo $_SESSION["product"][$i]["DifferencePer"]; ?></td>
                        <td><?php echo $_SESSION["product"][$i]["DifferenceBath"]; ?></td>
                        <td class ="text-right"><?php echo number_format($_SESSION["product"][$i]["total"] * $_SESSION["product"][$i]["AmountProduct"], 2); ?></td>
                        <td>
                            <a href="editproduct_addorder.php?idproduct_order=<?= $i ?>&idunit=<?php echo $idUnitS; ?>&amount=<?= $_SESSION["product"][$i]["AmountProduct"]; ?>&DifferencePer=<?= $_SESSION["product"][$i]["DifferencePer"]; ?>&DifferenceBath=<?= $_SESSION["product"][$i]["DifferenceBath"]; ?>&type=<?= $_SESSION["product"][$i]["type"]; ?>" class="btn btn-warning " data-toggle="tooltip" title="แก้ไข">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a class = "btn btn-danger" data-toggle = "modal" data-toggle = "tooltip" title = "ลบ" id="deleteProduct<?= $i; ?>" name="deleteProduct<?= $i; ?>" onclick="if (confirm('คุณต้องการลบหน่วยสินค้าทั้งหมดหรือไม่')) {
                                                    delProduct(<?= $i; ?>);
                                                }">
                                <span class = "glyphicon glyphicon-trash"></span>
                            </a>     
                        </td>
                    </tr>
                    <?php
                    continue;
                }
            }
            ?>
    </table>
    <div class="col-md-6"></div>
    <div class="col-md-4">
        <label for="disabled_no">ราคาขายรวมต่อบิล</label>
        <input type="text" class="form-control" id="disabled_no" placeholder=" " value="<?= $sum ?>" readonly="true">
    </div>
    <script>
        function delProduct(str) {
            var idunit = str;
            var p = "&idproduct_order=" + idunit;
            $.get("action_addProduct.php?p=delProduct" + p, function (data, status) {
                if (data != "-1") {
                    showUnit();
                    alert("ลบหน่วยทั้งหมดแล้ว");
                }
                else {
                    alert("ไม่สามารถลบหน่วยได้");

                }
            });
        }
    </script>
    <?php
}
?>