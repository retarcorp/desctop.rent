<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/Classes/autoload.php";
use Classes\Models\Finance\Transaction;
use Classes\Models\Finance\Order;
use Classes\Models\Finance\BankActionsWorker;
use Classes\Models\Finance\Operations;
use Classes\Exceptions\DesktopRentException;

try{
    $baw = new BankActionsWorker();
    $orderId = $_GET['orderId'];
    $order = $baw->getOrderByBankOrderId($orderId);
    $data = Operations::getOrderStatusByBankOrderId($orderId);
    $order->addError($data['orderStatus'], $data['actionCodeDescription']);
}catch(DesktopRentException $e){
    print_r($e->getMessage());
}

?>


<h1>O, there was a mistake!!!</h1>