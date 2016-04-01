<?php
require_once 'function/func_stat.php';
//require_once '../docket/function/func_docket.php';
?>
<?php
$idshipment_period = $_GET['idshipment_period'];
?>
<form class="form" action="" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ตารางข้อมูลการจ่ายเงินโรงงานแยกตามรอบ </h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>

                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example"> 
                    <thead>
                        <tr>
                            <th><div align="center">ลำดับ</div></th>
                    <th><div align="center">รหัสโรงงาน</div></th>
                    <th><div align="center">ชื่อโรงงาน</div></th>
                    <th><div align="center">ยอดเงินที่เรียกเก็บ</div></th>
                    <th><div align="center">ยอดเงินสินค้าคืน</div></th>
                    <th><div align="center">ยอดเงินจ่ายสุทธิ(รายจ่าย)</div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getOutcomeBYidshipment = getOutcomeBYidshipment($idshipment_period);
                        $i = 0;
                        $sum_outcome = 0;
                        foreach ($getOutcomeBYidshipment as $value) {
                            $i++;
                            $idfactory = $value['factory_idfactory'];
                            $code_factory = $value['code_factory'];
                            $val_name_factory = $value['name_factory'];
                            $val_price_pay_factory = $value['price_pay_factory']; //ยอดเรียกเก็บ
                            $val_price_product_refund_factory = $value['price_product_refund_factory']; //ยอดสินค้าคืน
                            $val_outcome = $value['outcome'];
                            $sum_outcome = $sum_outcome + $val_outcome;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $code_factory; ?></td>
                                <td><?php echo $val_name_factory; ?></td>
                                <td class="text-right"><!-- ยอดเงินที่เรียกเก็บ -->
                                    <?php echo number_format($val_price_pay_factory, 2); ?>
                                </td>
                                <td class="text-right"><!-- ยอดเงินสินค้าคืน-->
                                    <?php echo number_format($val_price_product_refund_factory, 2); ?>
                                </td>
                                <td class="text-right"><!-- รายจ่าย -->
                                    <?php echo number_format($val_outcome, 2); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="text-danger" align="right">รายจ่ายรวม &nbsp;&nbsp; <b><?php echo number_format($sum_outcome, 2); ?></b> &nbsp;&nbsp; บาท </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
<!--<div class="alert alert-danger" role="alert">ยังไม่ได้แก้ sql </div>-->