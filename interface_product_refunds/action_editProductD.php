<?php
require_once dirname(__FILE__) . '/function/func_addorder.php';
session_start();

//session_destroy();
if ($_GET['p'] == "addProduct") {
    $idproduct_refunds = $_GET['idproduct_refunds'];
    $price_product_refunds = $_GET['price_product_refunds'];
    $idorder_ww = $_GET['idorder'];
    echo $idorder_ww;
    $getOrder = Gettotal_Order_Del($idorder_ww);
    $total_price_product_refunds = $getOrder['total_price_product_refunds'] - $price_product_refunds;
    echo $total_price_product_refunds;
    $idproductD = deleteProduct_Refunds($idproduct_refunds);
    $Edit = editTotal_order($idorder_ww, $total_price_product_refunds);
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
            if (isset($_SESSION["editcountProductD"])) {
                for ($i = 1; $i <= $_SESSION["editcountProductD"]; $i++) {
                    $idproduct_order = $_SESSION["editproductD"][$i]["idproduct_order"];
                    $getproduct = getProductOrder_del($idproduct_order);
                    $val_name_unit = $getproduct['name_unit'];
                    $val_name_factory = $getproduct['name_factory'];
                    $val_name_product = $getproduct['name_product'];
                    $val_amount_product_order = $getproduct['amount_product_order'];
                    $val_difference_product_order = $getproduct['difference_product_order'];
                    $val_type_product_order = $getproduct['type_product_order'];
                    $val_difference_amount_factory = $getproduct['difference_amount_factory'];
                    $val_price_unit = $getproduct['price_unit'];
                    $total_open = $val_price_unit * $val_amount_product_order;
                    $total_percent = $total_open - ($total_open * ($val_difference_product_order / 100));
                    $val_status_checktransport = $getproduct['status_checktransport'];
                    $total_bath = $total_open - ($val_difference_product_order * $val_amount_product_order);
                    ?>

                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $val_name_product; ?></td>
                        <td><?= $val_name_factory; ?></td>
                        <td><?= $val_name_unit; ?></td> 
                        <td><?= $val_amount_product_order; ?></td>
                        <td><?= $total_open; ?> </td>
                        <td><?= $val_difference_amount_factory; ?></td>
                        <?php if ($val_type_product_order === 'PERCENT') { ?>
                            <td><?= $val_difference_product_order; ?></td>
                            <td>-</td>
                            <td><?= $total_percent; ?></td>
                        <?php }
                        ?>
                        <?php if ($val_type_product_order === 'BATH') {
                            ?>
                            <td>-</td>
                            <td><?= $val_difference_product_order; ?></td>                                                                  
                            <td><?= $total_bath; ?></td> 
                            <?php
                        }

                        if ($val_status_checktransport === 'check') {
                            ?> <td>
                                <b><font color="green">สินค้าถูกจัดส่งแล้ว</font></b>
                            </td>
                            <?php
                        } else {
                            ?>
                            <td>
                                <!--Button trigger modal -->
                                <a href = "popup_editproduct_editorder.php?idproduct_order=<?php echo $val_idproduct_order; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                    <span class = "glyphicon glyphicon-edit"></span>
                                </a>
                                <a class = "btn btn-danger" data-toggle = "modal" data-target = "#myModal3" data-toggle = "tooltip" title = "ลบ" id="deleteProduct" name="deleteProduct" onclick="delProduct(<?= $val_idproduct_order ?>);">
                                    <span class = "glyphicon glyphicon-trash"></span>
                                </a>                                                                   
                            </td>
                            <?php
                        }
                        ?>    
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