<?php
// start action
echo "<pre>";
print_r($_POST);
echo $_POST['test'][0];
echo "<pre>";

foreach ($_POST['test'] as $key => $value) {
    echo "KEY=" . $key . " Value=" . $value . "<br>";
}
// end action
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