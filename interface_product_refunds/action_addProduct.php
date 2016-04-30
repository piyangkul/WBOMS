<?php
require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();

//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $price = $_GET['price'];
    $total_price = $_GET['total_price'];
    $diff = $_GET['diff'];
    $price_factory = $_GET['price_factory'];
    $type_factory = $_GET['type_factory'];

    if (isset($_SESSION["countProductR"])) {
        $_SESSION["countProductR"] ++;
    } else
        $_SESSION["countProductR"] = 1;
    $_SESSION["productR"][$_SESSION["countProductR"]]["idUnit"] = $idUnit;
    $_SESSION["productR"][$_SESSION["countProductR"]]["productName"] = $productName;
    $_SESSION["productR"][$_SESSION["countProductR"]]["factoryName"] = $factoryName;
    $_SESSION["productR"][$_SESSION["countProductR"]]["AmountProduct"] = $AmountProduct;
    $_SESSION["productR"][$_SESSION["countProductR"]]["price"] = $price;
    $_SESSION["productR"][$_SESSION["countProductR"]]["total_price"] = $total_price;
    $_SESSION["productR"][$_SESSION["countProductR"]]["diff"] = $diff;
    $_SESSION["productR"][$_SESSION["countProductR"]]["price_factory"] = $price_factory;
    $_SESSION["productR"][$_SESSION["countProductR"]]["type_factory"] = $type_factory;

    echo "1";
}

else if ($_GET['p'] == "editProduct") {
    $product_refunds = $_GET['idproduct_refunds'];
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $price = $_GET['price'];
    $total_price = $_GET['total_price'];
    $price_factory = $_GET['price_factory'];
    $diff = $_GET['diff'];
    $type_factory = $_GET['typefactory'];


    $_SESSION["productR"][$product_refunds]['idUnit'] = $idUnit;
    $_SESSION["productR"][$product_refunds]["productName"] = $productName;
    $_SESSION["productR"][$product_refunds]["factoryName"] = $factoryName;
    $_SESSION["productR"][$product_refunds]["AmountProduct"] = $AmountProduct;
    $_SESSION["productR"][$product_refunds]["price"] = $price;
    $_SESSION["productR"][$product_refunds]["total_price"] = $total_price;
    $_SESSION["productR"][$product_refunds]["diff"] = $diff;
    $_SESSION["productR"][$product_refunds]["price_factory"] = $price_factory;
    $_SESSION["productR"][$product_refunds]["type_factory"] = $type_factory;

    echo "1";
} /* else if ($_GET['p'] == "chkUnitAdd") {

  //    echo $_SESSION["countUnit"];
  if (isset($_SESSION["countUnit"])) {
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
    if (isset($_SESSION["countProductR"])) {
        unset($_SESSION["countProductR"]);
        unset($_SESSION["productR"]);
        echo 1;
    } else {
        echo -1;
    }
} else if ($_GET['p'] == "resetInfo") {
    unset($_SESSION["countProductR"]);
    unset($_SESSION["productR"]);
    unset($_SESSION["idshopP"]);
    echo 1;
} else if ($_GET['p'] == "showUnit") {
    $sum = 0;
    ?>
    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
        <thead>
            <tr>
                <th class="text-center">ลำดับ</th>
                <th class="text-center">ชื่อสินค้า</th>
                <th class="text-center">ชื่อโรงงาน</th>
                <th class="text-center">จำนวน</th>
                <th class="text-center">ราคาเปิดต่อหน่วย</th>
                <th class="text-center">ส่วนลด</th>
                <th class="text-center">ราคาคืนต่อหน่วย</th>
                <th class="text-center">ราคาคืนทั้งหมด</th>
                <th class="text-center">การกระทำ</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION["countProductR"])) {

                for ($i = 1; $i <= $_SESSION["countProductR"]; $i++) {
                    $sum += $_SESSION["productR"][$i]["total_price"];
                    //$j = $_SESSION["unit"][$i]["under_unit"];
                    $idUnitS = $_SESSION["productR"][$i]["idUnit"];
                    $idFactoryS = $_SESSION["productR"][$i]["factoryName"];
                    $idProductS = $_SESSION["productR"][$i]["productName"];
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

                        <td><?php echo $_SESSION["productR"][$i]["AmountProduct"] . " "; ?>
                            <?php
                            $getUnit = getUnit2($idUnitS);
                            //print_r($getUnit);;
                            foreach ($getUnit as $value) {
                                $val_name_unit = $value['name_unit'];
                                echo $val_name_unit;
                            }
                            ?></td>
                        <td class="text-right"><?= number_format($_SESSION["productR"][$i]["price_factory"], 2); ?></td>

                        <?php if ($_SESSION["productR"][$i]["type_factory"] === "PERCENT") { ?>
                            <td><?= number_format($_SESSION["productR"][$i]["diff"], 2) . "%" ?></td>
                        <?php } else { ?>
                            <td><?= number_format($_SESSION["productR"][$i]["diff"], 2) . " ฿"; ?></td>
                        <?php }
                        ?>
                        <td class="text-right"><?php echo number_format($_SESSION["productR"][$i]["price"], 2); ?></td>
                        <td class="text-right"><?php echo number_format($_SESSION["productR"][$i]["total_price"], 2); ?></td>
                        <td>
                            <a href="popup_addproduct_refunds_edit.php?idproduct_refunds=<?= $i; ?>&idunit=<?php echo $idUnitS; ?>&amount=<?= $_SESSION["productR"][$i]["AmountProduct"]; ?>&price=<?= $_SESSION["productR"][$i]["price"]; ?>&total_price=<?= $_SESSION["productR"][$i]["total_price"]; ?>&price_factory=<?= $_SESSION["productR"][$i]["price_factory"]; ?>&diff=<?= $_SESSION["productR"][$i]["diff"]; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a class = "btn btn-danger" data-toggle = "modal" data-toggle = "tooltip" title = "ลบ" id="deleteProduct<?= $i; ?>" name="deleteProduct<?= $i; ?>" onclick="if (confirm('คุณต้องการลบหน่วยสินค้าหรือไม่')) {
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
        <input type="text" class="form-control" id="totalss" name="totalss" placeholder=" " value="<?= number_format($sum, 2); ?>" readonly="true">
    </div>
    <?php
}
?>
<script>
    function delProduct(str) {
        var idunit = str;
        var p = "&idproduct_order=" + idunit;
//alert(p);
        $.get("action_addProductD.php?p=delProduct" + p, function (data, status) {
//alert("Data: " + data + "\nStatus: " + status);
            if (data != "-1") {
                alert("ลบสินค้าตัวนี้แล้ว");
                showUnit();
            }
            else {
                alert("ไม่สามารถลบหน่วยได้");

            }
        });
    }
</script>