<?php
require_once dirname(__FILE__) . '/../function/func_stat_shop_bill.php';
?>
<?php $year_pay = $_GET['idyear']; ?>

<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
    <thead>
        <tr>
            <th rowspan="2"><div align="center">รหัสร้านค้า</div></th>
<th rowspan="2"><div align="center">ร้านค้า</div></th>
<th colspan="3"><div align="center">เก็บครบ</div></th>
<th colspan="3"><div align="center">เก็บไม่ครบ</div></th>
<th rowspan="2"><div align="center">เก็บไม่ได้</div></th>
</tr>
<tr>
    <th><div align="center">เงินสด</div></th>
<th><div align="center">เช็คจ่ายตรงเวลา</div></th>
<th><div align="center">เช็คจ่ายเกินเวลา</div></th>
<th><div align="center">เงินสด</div></th>
<th><div align="center">เช็คจ่ายตรงเวลา</div></th>
<th><div align="center">เช็คจ่ายเกินเวลา</div></th>
</tr>
</thead>
<tbody>
    <?php
    //ดึงข้อมูลจากตาราง   
    $getPayNameShop = getPayNameShop($year_pay);
    $i = 0;
    $status_pay_get = "get";
    $status_pay_lack = "lack";
    $status_pay_unget = "unget";
    foreach ($getPayNameShop as $value) {
        $i++;
        $val_idshop = $value['idshop'];
        $val_shop_code = $value['shop_code'];
        $val_name_shop = $value['name_shop'];

        $getStatus_pay_GET = getStatus_pay_GET($year_pay, $status_pay_get, $val_idshop);
        $val_get_cash = $getStatus_pay_GET['get_cash'];
        $val_get_on = $getStatus_pay_GET['get_on'];
        $val_get_over = $getStatus_pay_GET['get_over'];
        if ($val_get_cash == NULL) {
            $val_get_cash = 0;
        }
        if ($val_get_on == NULL) {
            $val_get_on = 0;
        }
        if ($val_get_over == NULL) {
            $val_get_over = 0;
        }

        $getStatus_pay_LACK = getStatus_pay_LACK($year_pay, $status_pay_lack, $val_idshop);
        $val_lack_cash = $getStatus_pay_LACK['lack_cash'];
        $val_lack_on = $getStatus_pay_LACK['lack_on'];
        $val_lack_over = $getStatus_pay_LACK['lack_over'];
        if ($val_lack_cash == NULL) {
            $val_lack_cash = 0;
        }
        if ($val_lack_on == NULL) {
            $val_lack_on = 0;
        }
        if ($val_lack_over == NULL) {
            $val_lack_over = 0;
        }

        $getStatus_pay_UNGET = getStatus_pay_UNGET($year_pay, $status_pay_unget, $val_idshop);
        $val_unget = $getStatus_pay_UNGET['unget'];
        if ($val_unget == NULL) {
            $val_unget = 0;
        }
        ?>       
        <tr>
            <td><?php echo $val_shop_code; ?></td>
            <td><?php echo $val_name_shop; ?></td>
            <td><?php echo "<a href='popup_get_cash.php?year_pay=$year_pay&idshop=$val_idshop' data-toggle='modal' data-target='#myModal-lg'> " . $val_get_cash . " </a>"; ?></td>
            <td><?php echo $val_get_on; ?></td>

            <td><?php echo $val_get_over; ?></td>

            <!-- เก็บไม่ครบ เงินสด -->
            <?php if ($val_lack_cash == 0) { ?>
                <td><?php echo $val_lack_cash; ?></td>
            <?php } else { ?>
                <td><?php echo "<a href='popup_lack_cash.php?year_pay=$year_pay&idshop=$val_idshop&status_pay=$status_pay_lack' id='openBtn' data-toggle='modal' data-target='#myModal-lg'> " . $val_lack_cash . " </a>"; ?></td>
            <?php } ?>

            <!-- เก็บไม่ครบ จ่ายเงินตรงเวลา -->
            <?php if ($val_lack_on == 0) { ?>
                <td><?php echo $val_lack_on; ?></td>
            <?php } else { ?>
                <td><?php echo "<a href='popup_lack_on.php?year_pay=$year_pay&idshop=$val_idshop&status_pay=$status_pay_lack' id='openBtn' data-toggle='modal' data-target='#myModal-lg'> " . $val_lack_on . " </a>"; ?></td>
            <?php } ?>

            <!-- เก็บไม่ครบ จ่ายเงินเกินเวลา -->
            <?php if ($val_lack_over == 0) { ?>
                <td><?php echo $val_lack_over; ?></td>
            <?php } else { ?>
                <td><?php echo "<a href='popup_lack_over.php?year_pay=$year_pay&idshop=$val_idshop&status_pay=$status_pay_lack' id='openBtn' data-toggle='modal' data-target='#myModal-lg'> " . $val_lack_over . " </a>"; ?></td>
            <?php } ?>

            <!-- เก็บไม่ได้ -->
            <?php if ($val_unget == 0) { ?>
                <td><?php echo $val_unget; ?></td>
            <?php } else { ?>
                <td><?php echo "<a href='popup_unget.php?year_pay=$year_pay&idshop=$val_idshop&status_pay=$status_pay_unget' id='openBtn' data-toggle='modal' data-target='#myModal-lg'> " . $val_unget . " </a>"; ?></td>
            <?php } ?>

        </tr>
    <?php } ?>

</tbody>
</table>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>
<script>
    $(document.body).on('hidden.bs.modal', function () {
        $('#myModal-lg').removeData('bs.modal');
    });
</script>
<div class="modal fade" id="myModal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content -->
        </div>
    </div>
</div>
