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
if ($_GET['p'] == "chkUnitAdd") {

//    echo $_SESSION["countUnit"];
    if (isset($_SESSION["countUnit"])) {
        echo 1;
    } else
        echo 0;
}
if ($_GET['p'] == "getPriceUnit") {
    $id = $_GET['id'];
//    echo "$id ";
    echo $_SESSION["unit"][$id]["price"];
}
if ($_GET['p'] == "getBigestUnit") {
    if (isset($_SESSION["countUnit"])) {
        echo $_SESSION["unit"][1]["NameUnit"];
    } else {
        echo "-1";
    }
}
if ($_GET['p'] == "getBigestPrice") {
    if (isset($_SESSION["countUnit"])) {
        echo $_SESSION["unit"][1]["price"];
    } else {
        echo "-1";
    }
}
if ($_GET['p'] == "showUnit") {
    ?>
    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
        <thead>
            <tr>
                <th>จำนวนต่อหน่วยใหญ่</th>
                <th>หน่วยใหญ่</th>
                <th>จำนวนต่อหน่วยรอง</th>
                <th>หน่วยรอง</th>
                <th>การกระทำ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION["countUnit"])) {
                for ($i = 1; $i <= $_SESSION["countUnit"]; $i++) {
                    $j = $_SESSION["unit"][$i]["under_unit"];
                    if ($j == "") {
                        continue;
                    }
                    ?>
                    <tr>
                        <td>1</td>
                        <td><?php echo $_SESSION["unit"][$j]["NameUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["AmountPerUnit"]; ?></td>
                        <td><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></td>
                        <td>
                            <a href="popup_edit_product_unit.php" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a href="popup_delete_product_unit.php" class="btn btn-danger " data-toggle="modal" data-target="#myModal3" data-toggle="tooltip" title="ลบ">
                                <span class="glyphicon glyphicon-trash"></span>
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