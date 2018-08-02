<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/Classes/autoload.php";
use Classes\Models\Finance\Transaction;
use Classes\Models\Finance\Order;
use Classes\Models\Finance\BankActionsWorker;
use Classes\Exceptions\DesktopRentException;

try{
    
    $baw = new BankActionsWorker();
    $orderId = $_GET['orderId'];
    $order = $baw->getOrderByBankOrderId($orderId);
    $transaction = $baw->getTransactionForOrder($order);
    $transaction->setPaid();
}catch(DesktopRentException $e){
    print_r($e->getMessage());
}

?>

<h1>SUCCESS!!!</h1>