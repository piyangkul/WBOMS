<?php
require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();
$z = 1;
//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idorder = $_GET['idorder'];
    $idUnit = $_GET['idUnit'];
    $productName = $_GET['productName'];
    $factoryName = $_GET['factoryName'];
    $AmountProduct = $_GET['AmountProduct'];
    $price = $_GET['price'];
    $total_price = $_GET['total_price'];
    $total_price_all = $_GET['total_price_all'];




    if (isset($_SESSION["editcountProductR"])) {
        $_SESSION["editcountProductR"] ++;
    } else
        $_SESSION["editcountProductR"] = 1;
    $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["idUnit"] = $idUnit;
    $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["productName"] = $productName;
    $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["factoryName"] = $factoryName;
    $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["AmountProduct"] = $AmountProduct;
    $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["price"] = $price;
    $_SESSION["editproductR"][$_SESSION["editcountProductR"]]["total_price"] = $total_price;

    $idproduct = addProductRefunds($idorder, $idUnit, $AmountProduct, $price);
    $Edit = editTotal_order($idorder, $total_price_all);
/*
    for ($i = 1; $i <= $_SESSION["editcountProductR"]; $i++) {
        $sum += $_SESSION["editproductR"][$i]["total_price"];
        //$j = $_SESSION["unit"][$i]["under_unit"];
        $idUnitS = $_SESSION["editproductR"][$i]["idUnit"];
        $idFactoryS = $_SESSION["editproductR"][$i]["factoryName"];
        $idProductS = $_SESSION["editproductR"][$i]["productName"];
        //echo $s;
        //$getUnit = getUnit2($s);
        //$val_name_unit = $getUnit('name_unit');
        ?>

        <tr>
            <td><?php echo $z ?></td>
            <td><?php
                $getProduct = getProduct2($productName);
                foreach ($getProduct as $value) {
                    $val_name_product = $value['name_product'];
                    echo $val_name_product;
                }
                ?></td>
            <td><?php
                $getFactory = getFactory2($factoryName);
                foreach ($getFactory as $value) {
                    $val_name_factory = $value['name_factory'];
                    echo $val_name_factory;
                }
                ?></td>
            <td><?php
                $getUnit = getUnit2($idUnit);
                //print_r($getUnit);;
                foreach ($getUnit as $value) {
                    $val_name_unit = $value['name_unit'];
                    echo $val_name_unit;
                }
                ?></td>
            <td><?php echo $AmountProduct; ?></td>
            <td class="text-right"><?php echo number_format($price, 2); ?></td>
            <td class="text-right"><?php echo $total_price; ?></td>
            <td>
                <a href="popup_edit_editproduct_refunds.php?idproduct_refunds=<?= $i; ?>&idunit=<?php echo $idUnit; ?>&amount=<?= $AmountProduct; ?>&price=<?= $price; ?>&total_price=<?= $total_price; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
            </td>
        </tr>
        <?php
        continue;
    }
*/

    $z++;
    echo "1";
}

/* else if ($_GET['p'] == "editProduct") {
  $product_refunds = $_GET['idproduct_refunds'];
  $idUnit = $_GET['idUnit'];
  $productName = $_GET['productName'];
  $factoryName = $_GET['factoryName'];
  $AmountProduct = $_GET['AmountProduct'];
  $price = $_GET['price'];
  $total_price = $_GET['total_price'];

  $_SESSION["editproductR"][$product_refunds]['idUnit'] = $idUnit;
  $_SESSION["editproductR"][$product_refunds]["productName"] = $productName;
  $_SESSION["editproductR"][$product_refunds]["factoryName"] = $factoryName;
  $_SESSION["editproductR"][$product_refunds]["AmountProduct"] = $AmountProduct;
  $_SESSION["editproductR"][$product_refunds]["price"] = $price;
  $_SESSION["editproductR"][$product_refunds]["total_price"] = $total_price;

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
  } else if ($_GET['p'] == "resetUnit") {
  if (isset($_SESSION["countUnit"])) {
  unset($_SESSION["countUnit"]);
  unset($_SESSION["unit"]);
  echo 1;
  } else {
  echo -1;
  }
  } */ else if ($_GET['p'] == "showUnit") {
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
                <th>ราคาเปิดต่อสินค้า</th>
                <th>ราคาเปิดทั้งหมด</th>
                <th>การกระทำ</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION["editcountProductR"])) {

                for ($i = 1; $i <= $_SESSION["editcountProductR"]; $i++) {
                    $sum += $_SESSION["editproductR"][$i]["total_price"];
                    //$j = $_SESSION["unit"][$i]["under_unit"];
                    $idUnitS = $_SESSION["editproductR"][$i]["idUnit"];
                    $idFactoryS = $_SESSION["editproductR"][$i]["factoryName"];
                    $idProductS = $_SESSION["editproductR"][$i]["productName"];
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
                        <td><?php echo $_SESSION["editproductR"][$i]["AmountProduct"]; ?></td>
                        <td class="text-right"><?php echo number_format($_SESSION["editproductR"][$i]["price"], 2); ?></td>
                        <td class="text-right"><?php echo $_SESSION["editproductR"][$i]["total_price"]; ?></td>
                        <td>
                            <a href="popup_edit_editproduct_refunds.php?idproduct_refunds=<?= $i; ?>&idunit=<?php echo $idUnitS; ?>&amount=<?= $_SESSION["editproductR"][$i]["AmountProduct"]; ?>&price=<?= $_SESSION["editproductR"][$i]["price"]; ?>&total_price=<?= $_SESSION["editproductR"][$i]["total_price"]; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                    </tr>
                    <?php
                    continue;
                }
            }
            ?>
    </table>
    <!--<div class="col-md-6"></div>
    <div class="col-md-4">
        <label for="disabled_no">ราคาขายรวมต่อบิล</label>
        <input type="text" class="form-control" id="totalss" name="totalss" placeholder=" " value="" readonly="true">
    </div>-->
    <?php
}
?>