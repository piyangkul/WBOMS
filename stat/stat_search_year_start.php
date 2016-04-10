<?php
require_once 'function/func_stat.php';
//if (isset($_GET['year_start'])) {
    $get_year_start = $_GET['get_year_start'];
    //echo "<script type='text/javascript'>alert('$get_year_start');</script>";
//}
?>
<option value="">เลือกปีเริ่มต้น</option>
<?php
$getYear_start = getYear_start();
foreach ($getYear_start as $value) {
    $val_A_D_start = $value['A_D_start'];
    $val_B_E_start = $value['B_E_start'];
    ?>
    <option value="<?php echo $val_A_D_start; ?>" <?php if ($val_A_D_start == $get_year_start) { ?> selected="selected" <?php } ?> > <?php echo "ปี: $val_B_E_start ( ค.ศ. $val_A_D_start )"; ?></option>
<?php } ?>
<!--<option value="<?php //echo $val_idfactory;  ?>"><?php //echo "[$val_code_factory] $val_name_product - $val_name_factory";  ?></option>-->