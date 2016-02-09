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
    $total_price = $_GET['total_price'];
    $total = $_GET['total'];
    $type = $_GET['type'];

    if (isset($_SESSION["editcountProduct"])) {
        $_SESSION["editcountProduct"] ++;
    } else
        $_SESSION["editcountProduct"] = 1;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["idUnit"] = $idUnit;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["productName"] = $productName;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["factoryName"] = $factoryName;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["AmountProduct"] = $AmountProduct;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["difference"] = $difference;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["DifferencePer"] = $DifferencePer;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["DifferenceBath"] = $DifferenceBath;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["total_price"] = $total_price;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["total"] = $total;
    $_SESSION["editproduct"][$_SESSION["editcountProduct"]]["type"] = $type;

    echo "1";
}
/*
  else if ($_GET['p'] == "editUnit") {
  $idUnit = $_GET['idUnit'];
  $NameUnit = $_GET['NameUnit'];
  $AmountPerUnit = $_GET['AmountPerUnit'];
  $under_unit = $_GET['under_unit'];
  $price = $_GET['price'];
  $type = $_GET['type'];

  $_SESSION["unit"][$idUnit]["NameUnit"] = $NameUnit;
  $_SESSION["unit"][$idUnit]["AmountPerUnit"] = $AmountPerUnit;
  $_SESSION["unit"][$idUnit]["under_unit"] = $under_unit;
  $_SESSION["unit"][$idUnit]["price"] = $price;
  $_SESSION["unit"][$idUnit]["type"] = $type;

  echo "1";
  } else if ($_GET['p'] == "chkUnitAdd") {

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
  } */else if ($_GET['p'] == "showUnit") {
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
                        <td><?php echo $_SESSION["editproduct"][$i]["total_price"]; ?></td>
                        <td><?php echo $_SESSION["editproduct"][$i]["difference"]; ?></td>
                        <td><?php echo $_SESSION["editproduct"][$i]["DifferencePer"]; ?></td>
                        <td><?php echo $_SESSION["editproduct"][$i]["DifferenceBath"]; ?></td>
                        <td><?php echo $_SESSION["editproduct"][$i]["total"]; ?></td>
                        <td>
                            <a href="popup_editproduct_order_edit.php?idUnit=<?php echo $i; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
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
    <?php
}
?>