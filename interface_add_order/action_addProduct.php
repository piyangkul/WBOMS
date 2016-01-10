<?php
session_start();
//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idUnit = $_GET['idUnit'];
    $AmountProduct = $_GET['AmountProduct'];
    $DifferencePer = $_GET['DifferencePer'];
    $DifferenceBath = $_GET['DifferenceBath'];
    $type = $_GET['type'];

    if (isset($_SESSION["countUnit"])) {
        $_SESSION["countUnit"] ++;
    } else
        $_SESSION["countUnit"] = 1;
    $_SESSION["unit"][$_SESSION["countUnit"]]["idUnit"] = $idUnit;
    $_SESSION["unit"][$_SESSION["countUnit"]]["AmountProduct"] = $AmountProduct;
    $_SESSION["unit"][$_SESSION["countUnit"]]["DifferencePer"] = $DifferencePer;
    $_SESSION["unit"][$_SESSION["countUnit"]]["DifferenceBath"] = $DifferenceBath;
    $_SESSION["unit"][$_SESSION["countUnit"]]["type"] = $type;

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
            if (isset($_SESSION["countUnit"])) {
                for ($i = 1; $i <= $_SESSION["countUnit"]; $i++) {
                    $j = $_SESSION["unit"][$i]["under_unit"];
                    if ($j == "") {
                        ?>
                        <tr>
                            <td><?php $i ?></td>
                            <td>-</td>
                            <td>-</td>
                            <td><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></td>
                            <td><?php echo $_SESSION["unit"][$i]["AmountProduct"]; ?></td>
                            <td>-</td>
                            <td>-</td>
                            <td><?php echo $_SESSION["unit"][$i]["DifferencePer"]; ?></td>
                            <td><?php echo $_SESSION["unit"][$i]["DifferenceBath"]; ?></td>
                            <td>-</td>
                            <td>
                                <a href="popup_add_product_order_edit.php?idUnit=<?php echo $i; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </td>
                        </tr>
                        <?php
                        continue;
                    }
                    ?>
                    <tr>
                        <td>1</td>
                        <td><?php echo $_SESSION["unit"][$j]["NameUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["AmountPerUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></td>
                        <td>
                            <a href="popup_add_product_edit_unit.php?idUnit=<?php echo $i; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
    </table>
    <?php
}
?>