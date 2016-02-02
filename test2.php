<?php
//Example: 
$var_arr = array(array("idshipment_period" => 1, "date_start" => 00), array("idshipment_period" => 2, "date_start" => 00));
//$var_arr_asc_by_indxA = subval_sort($var_arr, "idshipment_period", "ASC");
//print_r($var_arr_asc_by_indxA);
$var_arr_des_by_indxB = subval_sort($var_arr, "date_start", "DES");
print_r($var_arr_des_by_indxB);
?>
<br>
<?php
//ดึงข้อมูลจากตาราง
require_once 'shipment/function/func_shipment.php';
$getShipment_period = getShipment_period();
//$val_idshipment_period1 = $getShipment_period['idshipment_period'];
//print_r($getShipment_period);
?>
<br>
<?php
//$var_arr_asc_by_indxA = subval_sort($getShipment_period, "idshipment_period", "ASC");
$var_arr_des_by_indxB = subval_sort($getShipment_period, "date_start", "DES");
print_r($var_arr_des_by_indxB);

    foreach ($var_arr_des_by_indxB as $value) {
        $val_idshipment_period = $value['idshipment_period'];
        $val_date_start = $value['date_start'];
        $change_date_start = date("d-m-Y", strtotime($val_date_start));
        $val_date_end = $value['date_end'];
        $change_date_end = date("d-m-Y", strtotime($val_date_end));
        ?>
        <tr>
            <td><?php echo $val_idshipment_period; ?></td>
            <td><?php echo $change_date_start; ?></td>
            <td><?php echo $change_date_end; ?></td>
            <td>
                <a href="shipment2.php?idshipment_period=<?php echo $val_idshipment_period; ?>" class="btn btn-success" title="รายละเอียด">
                    <span class="glyphicon glyphicon-list-alt"></span>
                </a>
                <?php
                $getCountCheckByIDshipment_period = getCountCheckByIDshipment_period($val_idshipment_period);
                foreach ($getCountCheckByIDshipment_period as $value) {
                    $val_idorder_transoprt = $value['idorder_transport'];
                }
                ?>
                <?php if ($val_idorder_transoprt == NULL) { ?>
                    <a href="popup_edit_period_shipment.php?idshipment_period=<?php echo $val_idshipment_period; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" title="แก้ไข">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="action/action_delPeriod_shipment.php?idshipment_period=<?php echo $val_idshipment_period; ?>" onclick="if (!confirm('คุณต้องการลบรอบการส่งสินค้าหรือไม่')) {
                                            return false;
                                        }" class="btn btn-danger " title="ลบ">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>


<?php
function subval_sort($a, $subkey, $sort_by) {
    foreach ($a as $k => $v) {
        $b[$k] = strtolower($v[$subkey]);
    }

    if ($sort_by == "ASC")
        asort($b);
    else if ($sort_by == "DES")
        arsort($b);
    else
        return false;

    foreach ($b as $key => $val) {
        $c[] = $a[$key];
    }
    return $c;
}
?>