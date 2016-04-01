<?php
require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();

//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idorder = $_GET['idorder'];
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

    /*if (isset($_SESSION["editcountProduct"])) {
        $_SESSION["editcountProduct"] ++;
    } else
        $_SESSION["editcountProduct"] = 1;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["idorder"] = $idorder;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["idUnit"] = $idUnit;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["productName"] = $productName;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["factoryName"] = $factoryName;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["AmountProduct"] = $AmountProduct;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["difference"] = $difference;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["DifferencePer"] = $DifferencePer;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["DifferenceBath"] = $DifferenceBath;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["price"] = $price;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["total_price"] = $total_price;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["total"] = $total;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["type"] = $type;*/
    if ($type === "PERCENT") {
        $idproduct = addProductOrder($idUnit, $idorder, $AmountProduct, $DifferencePer, $type, $price);
    }
    if ($type === "BATH") {
        $idproduct = addProductOrder($idUnit, $idorder, $products[$i]['AmountProduct'], $DifferenceBath,$type, $price);
    }
    echo "1";
} /*else if ($_GET['p'] == "editProduct") {
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

    $_SESSION["editproduct"]["$product_order"]["idUnit"] = $idUnit;
    $_SESSION["editproduct"]["$product_order"]["productName"] = $productName;
    $_SESSION["editproduct"]["$product_order"]["factoryName"] = $factoryName;
    $_SESSION["editproduct"]["$product_order"]["AmountProduct"] = $AmountProduct;
    $_SESSION["editproduct"]["$product_order"]["difference"] = $difference;
    $_SESSION["editproduct"]["$product_order"]["DifferencePer"] = $DifferencePer;
    $_SESSION["editproduct"]["$product_order"]["DifferenceBath"] = $DifferenceBath;
    $_SESSION["editproduct"]["$product_order"]["price"] = $total / $AmountProduct;
    $_SESSION["editproduct"]["$product_order"]["total_price"] = $total_price;
    $_SESSION["editproduct"]["$product_order"]["total"] = $total;
    $_SESSION["editproduct"]["$product_order"]["type"] = $type;

    echo "1";
}/* else if ($_GET['p'] == "chkUnitAdd") {

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
  } else if ($_GET['p'] == "resetUnit") {
  if (isset($_SESSION["countUnit"])) {
  unset($_SESSION["countUnit"]);
  unset($_SESSION["unit"]);
  echo 1;
  } else {
  echo -1;
  }
  } */ else if ($_GET['p'] == "showUnit") {
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
            if (isset($_SESSION["editcountProduct"])) {
                for ($i = 1; $i <= $_SESSION["editcountProduct"]; $i++) {
                    //$j = $_SESSION["unit"][$i]["under_unit"];
                    $idUnitS = $_SESSION["editproduct"][$i]["idUnit"];
                    $idFactoryS = $_SESSION["editproduct"][$i]["factoryName"];
                    $idProductS = $_SESSION["editproduct"][$i]["productName"];
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
                        <td><?php echo $_SESSION["editproduct"][$i]["AmountProduct"]; ?></td>
                        <td class ="text-right"><?php echo number_format($_SESSION["editproduct"][$i]["total_price"], 2); ?></td>
                        <td><?php echo $_SESSION["editproduct"][$i]["difference"]; ?></td>
                        <td><?php echo $_SESSION["editproduct"][$i]["DifferencePer"]; ?></td>
                        <td><?php echo $_SESSION["editproduct"][$i]["DifferenceBath"]; ?></td>
                        <td class ="text-right"><?php echo number_format($_SESSION["editproduct"][$i]["total"], 2); ?></td>
                        <td>
                            <a href="editproduct_editorder.php?idorder=<?=
                            $_SESSION["editproduct"][$i]["idorder"];
                            ;
                            ?>&idproduct_order=<?= $i; ?>&idunit=<?php echo $idUnitS; ?>&amount=<?= $_SESSION["editproduct"][$i]["AmountProduct"]; ?>&DifferencePer=<?= $_SESSION["editproduct"][$i]["DifferencePer"]; ?>&DifferenceBath=<?= $_SESSION["editproduct"][$i]["DifferenceBath"]; ?>&type=<?= $_SESSION["editproduct"][$i]["type"]; ?>" class="btn btn-warning " data-toggle="tooltip" title="แก้ไข">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a class = "btn btn-danger" data-toggle = "modal" data-toggle = "tooltip" title = "ลบ" id="deleteProduct<?= $i; ?>" name="deleteProduct<?= $i; ?>" onclick="delProduct(<?= $i; ?>);">
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
    <?php
}
?>