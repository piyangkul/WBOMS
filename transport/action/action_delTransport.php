<?php

require_once dirname(__FILE__) . '/../function/func_transport.php';

$idtransport = $_GET['idtransport'];

$checkDelTransport = delTransport($idtransport);
if ($checkDelTransport) {
   header("location: ../transport.php?action=delCompleted");
} else {
   header("location: ../transport.php?action=delError");
}