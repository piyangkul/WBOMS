<?php

require_once dirname(__FILE__) . '/../function/func_factory.php';

$idfactory = $_GET['idfactory'];

$checkDelFactory = delFactory($idfactory);
if ($checkDelFactory) {
   header("location: ../factory.php?action=delCompleted");
} else {
   header("location: ../factory.php?action=delError");
}