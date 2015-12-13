<?php
// start action
echo "<pre>";
print_r($_POST);
echo $_POST['test'][0];
echo "<pre>";
$x = $_POST['test'];

get($idproduct_order, $x);

//foreach ($x as $key => $value) {
//    echo "KEY=" . $key . " Value=" . $value . "<br>";
//}
// end action
// 
// start function


function get($idproduct_order, $ddd) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `product_order` SET `status_checktransport`= 'check' WHERE `idproduct_order` = :idproduct_order";

    $SQLPrepare = $conn->prepare($SQLCommand);
    foreach ($ddd as $key => $value) {
        $SQLPrepare->execute(
                array(
                    ":idproduct_order" => $value
                )
        );
    }
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// end function
?>

<!--start form-->
<form action="" method="POST">
    <input type="checkbox" name="test[1]" value="ddd1">
    <input type="checkbox" name="test[4]" value="ddd2">
    <input type="checkbox" name="test[6]" value="ddd3">
    <input type="checkbox" name="test[8]" value="ddd4">
    <input type="checkbox" name="testdd" value="ddd66">
    <button type="submit">test</button>
</form>
<!--end form-->