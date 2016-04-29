<?php
session_start();
//session_destroy();
if ($_GET['p'] == "addUnit") {
    $NameUnit = $_GET['NameUnit'];
    $AmountPerUnit = $_GET['AmountPerUnit'];
    $under_unit = $_GET['under_unit'];
    $price = $_GET['price'];
    $type = $_GET['type'];

    if (isset($_SESSION["countUnit"])) {
        $_SESSION["countUnit"] ++;
    } else
        $_SESSION["countUnit"] = 1;
    $_SESSION["unit"][$_SESSION["countUnit"]]["NameUnit"] = $NameUnit;
    $_SESSION["unit"][$_SESSION["countUnit"]]["AmountPerUnit"] = $AmountPerUnit;
    $_SESSION["unit"][$_SESSION["countUnit"]]["under_unit"] = $under_unit;
    $_SESSION["unit"][$_SESSION["countUnit"]]["price"] = str_replace(",", "", $price);
    $_SESSION["unit"][$_SESSION["countUnit"]]["type"] = $type;

    echo "1";
}
else if ($_GET['p'] == "editUnit") {
    $idUnit = $_GET['idUnit'];
    $NameUnit = $_GET['NameUnit'];
    $AmountPerUnit = $_GET['AmountPerUnit'];
    $price = $_GET['price'];
    $type = $_GET['type'];

    $_SESSION["unit"][$idUnit]["NameUnit"] = $NameUnit;
    $_SESSION["unit"][$idUnit]["AmountPerUnit"] = $AmountPerUnit;
    $_SESSION["unit"][$idUnit]["price"] = str_replace(",", "", $price);
    $_SESSION["unit"][$idUnit]["type"] = $type;

    for ($i = $idUnit; $i < $_SESSION["countUnit"]; $i++) {
        $_SESSION["unit"][$i + 1]["price"] = $_SESSION["unit"][$i]["price"] / $_SESSION["unit"][$i + 1]["AmountPerUnit"];
    }
    echo "1";
} else if ($_GET['p'] == "chkUnitAdd") {
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
        echo number_format($_SESSION["unit"][1]["price"], 2);
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
} else if ($_GET['p'] == "showUnit") {
    ?>
    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
        <thead>
            <tr>
                <th class="text-center">หน่วยใหญ่</th>
                <th class="text-center">จำนวนต่อหน่วยใหญ่</th>
                <th class="text-center">หน่วย</th>
                <th class="text-center">ราคาหน่วย</th>
                <th class="text-center">การกระทำ</th>
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
                            <td>-</td>
                            <td>1</td>
                            <td><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></td>
                            <td class="text-right"><?= number_format($_SESSION["unit"][$i]["price"], 2); ?></td>
                            <td>
                                <a href="popup_add_product_edit_Bigunit.php?idUnit=<?php echo $i; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <?php if ($i == $_SESSION["countUnit"]) { ?>
                                    <a class = "btn btn-danger" data-toggle = "modal" data-toggle = "tooltip" title = "ลบ" id="deleteProduct" name="deleteProduct" onclick="if (confirm('คุณต้องการลบหน่วยสินค้าหรือไม่')) {
                                                                    delProduct(<?= $i; ?>);
                                                                }">
                                        <span class = "glyphicon glyphicon-trash"></span>
                                    </a>     
                                <?php } ?>
                            </td>

                        </tr>
                        <?php
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?php echo $_SESSION["unit"][$i - 1]["NameUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["AmountPerUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></td>
                        <td class="text-right"><?= number_format($_SESSION["unit"][$i]["price"], 2); ?></td>
                        <td>
                            <a href="popup_add_product_edit_unit.php?idUnit=<?php echo $i; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <?php if ($i == $_SESSION["countUnit"]) { ?>
                                <a class = "btn btn-danger" data-toggle = "modal" data-toggle = "tooltip" title = "ลบ" id="deleteProduct" name="deleteProduct" onclick="if (confirm('คุณต้องการลบหน่วยสินค้าหรือไม่')) {
                                                            delProduct(<?= $i; ?>);
                                                        }">
                                    <span class = "glyphicon glyphicon-trash"></span>
                                </a>     
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
    </table>
    <script>
        function delProduct(str) {
            var idunit = str;
            var p = "&idunit=" + idunit;
            $.get("action_addUnitD.php?p=delUnit" + p, function (data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                if (data !== "-1") {
                    alert("ลบหน่วยสินค้าตัวนี้แล้ว");
                    showUnit();
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