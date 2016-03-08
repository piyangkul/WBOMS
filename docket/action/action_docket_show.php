<?php
require_once dirname(__FILE__) . '/../function/func_docket.php';
?>
<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example"> 
    <thead>
        <tr>
            <th><div align="center">วันที่เริ่มรอบ</div></th>
<th><div align="center">วันที่สิ้นสุดรอบ</div></th>
<th><div align="center">วันที่จ่ายเงิน</div></th>
<th><div align="center">ยอดสั่งซื้อ</div></th>
<th><div align="center">ยอดหนี้และสินค้าคืน</div></th>
<th><div align="center">ยอดจ่ายเงินสุทธิ</div></th>
<th><div align="center">สถานะการเก็บเงิน</div></th><!--เก็บได้ เก็บไม่ได้-->
<th><div align="center">การกระทำ</div></th>
</tr>
</thead>
<tbody>
    <?php
    $idshop = $_GET['idshop'];
    $getPayByID = getPayByID($idshop);
//    echo "<pre>";
//    print_r($getPayByID);
//    echo "</pre>";
    $i = 0;
    foreach ($getPayByID as $value) {
        $i++;
        $val_idshipment_period = $value['idshipment_period'];
        $val_date_start = $value['date_start'];
        $val_date_end = $value['date_end'];
        $val_date_pay = $value['date_pay'];
        $val_price_order_total = $value['price_order_total']; //ยอดสั่งซื้อ
        $val_debt = $value['debt']; //ยอดหนี้+สินค้าคืน(รอบที่แล้ว)
        $val_price_pay = $value['price_pay']; //ยอดจ่ายเงินสุทธิ        
        $val_status_pay = $value['status_pay']; //สถานะการเก็บเงินเก็บได้ เก็บไม่ได้
        if ($val_status_pay == "get") {
            $val_status_pay = "จ่ายแล้ว";
        } else {
            $val_status_pay = "ยังไม่ได้จ่าย";
        }
        ?>
        <tr>
            <td><?php echo $val_date_start; ?></td>
            <td><?php echo $val_date_end; ?></td>
            <td><?php echo $val_date_pay; ?></td>
            <td class="text-right"><!-- ยอดสั่งซื้อ -->
                <?php echo "<a href='popup_order_docket.php?idshipment_period=$val_idshipment_period&idshop=$idshop' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_price_order_total, 2) . " </a>"; ?>
            </td>
            <td class="text-right"><!-- ยอดหนี้+สินค้าคืน(รอบที่แล้ว)-->
                <?php echo "<a href='#.php?idshipment_period=$val_idshipment_period&idshop=$idshop' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_debt, 2) . " </a>"; ?>
            </td>
            <td class="text-right"><!-- ยอดจ่ายเงินสุทธิ -->
                <?php echo number_format($val_price_pay, 2) ; ?>
            </td>
            <td><?php echo $val_status_pay; ?></td>
            <td><!-- ดูใบปะหน้า -->
                <a href="docket_paper.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idshop=<?php echo $idshop; ?>" class="btn btn-success" data-toggle="tooltip" title="ดูใบปะหน้า">
                    <span class="fa fa-file-text-o"></span>
                </a>
            </td>
        </tr>
    <?php } ?>
</tbody>
</table>
<script>
    $(document.body).on('hidden.bs.modal', function () {
        $('#myModal-lg').removeData('bs.modal');
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
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