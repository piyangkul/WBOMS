<?php
require_once 'function/func_stat.php';
$year_start = $_GET['year_start'];
$month_start = $_GET['month_start'];
$get_year_end = $_GET['get_year_end'];
//echo "<script type='text/javascript'>alert('$get_year_end');</script>";
?>
<option value="">เลือกปีสิ้นสุด</option>
<?php
if ($month_start != 12) {
    $getYear_end = getYear_end($year_start);
    foreach ($getYear_end as $value) {
        $val_A_D_end = $value['A_D_end'];
        $val_B_E_end = $value['B_E_end'];
        ?>
        <option value="<?php echo $val_A_D_end; ?>" <?php if ($val_A_D_end == $get_year_end) { ?> selected <?php } ?> ><?php echo "ปี: $val_B_E_end ( ค.ศ. $val_A_D_end )"; ?></option>
    <?php }
    ?>

    <?php
} else {
    $getYear_end = getYear_end_December($year_start);
    foreach ($getYear_end as $value) {
        $val_A_D_end = $value['A_D_end'];
        $val_B_E_end = $value['B_E_end'];
        ?>
        <option value="<?php echo $val_A_D_end; ?>" <?php if ($val_A_D_end == $get_year_end) { ?> selected <?php } ?> ><?php echo "ปี: $val_B_E_end ( ค.ศ. $val_A_D_end )"; ?></option>
    <?php }
    ?>

<?php } ?>
