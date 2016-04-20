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
    $_SESSION["unit"][$_SESSION["countUnit"]]["price"] = $price;
    $_SESSION["unit"][$_SESSION["countUnit"]]["type"] = $type;

    echo "1";
}
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
} else if ($_GET['p'] == "showUnit") {
    ?>
    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
        <thead>
            <tr>
                <th>หน่วยใหญ่</th>
                <th>จำนวนต่อหน่วยใหญ่</th>
                <th>หน่วย</th>
                <th>ราคาหน่วย</th>
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
                            <td>-</td>
                            <td>1</td>
                            <td><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></td>
                            <td><?= $_SESSION["unit"][$i]["price"]; ?></td>
                            <td>
                <!--                                <a href="popup_add_product_edit_unit.php?idUnit=<?php echo $i; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>-->
                            </td>
                        </tr>
                        <?php
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?php echo $_SESSION["unit"][$i-1]["NameUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["AmountPerUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></td>
                        <td><?= number_format($_SESSION["unit"][$i]["price"],2); ?></td>
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