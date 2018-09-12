<?php

namespace Classes\Controllers;

use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\User;
use Classes\Models\Finance\Transaction;
use Classes\Utils\Safety;
use Classes\Models\Finance\Operations;
use Classes\Models\Finance\Binding;
use Classes\Models\Finance\BankActionsWorker;

class FinanceController{
    
    # @http GET /user/transactions/
    public function getUserTransactions(){
        Safety::declareProtectedZone();
        
        $uf = new UsersFactory();
        $user = $uf->getCurrentUser();
        
        $amount = isset($_GET['amount']) ? intval($_GET['amount']) : 0;
        $step = isset($_GET['step']) ? intval($_GET['step']) : 0;
        
        $transactions = $user->getTransactions($amount, $step);
        
        return array_map(function($transaction){
            $transaction->setPropsFromDB();
            return $transaction->toArray();
        }, $transactions);
    }
    
    # @http POST /order/
    public function createOrder(){
        Safety::declareProtectedZone();
        
        if( !isset($_POST['sum']) || !isset($_POST['id']) ){
            return 'Проверьте введенные данные';
        }
        
        $sum = floatval($_POST['sum']);
        $id = intval($_POST['id']);
        $expiration = isset($_POST['expiration']) ? $_POST['expiration'] : '';
        $response = Operations::registerOrder($sum * 100, $id, $expiration); // price without dots
        
        if( isset($response['errorCode']) ){
            return $response['errorMessage'];
        }
        
        $orderId = $response['orderId'];
        $bankRedirect = $response['formUrl'];
        
        $baw = new BankActionsWorker();
        $uf = new UsersFactory();
        $user = $uf->getCurrentUser();
        
        $order = $baw->createOrder($user, $orderId, $bankRedirect);
        $transaction = $baw->createTransaction($order, $sum, Transaction::PAYMENT_BY_SBERBANK);
        
        header("Location: $bankRedirect");
    }
    
    # @http POST /order/bind/
    public function createBindOrder(){
        $order = $_POST['order'];
        $id = $_POST['id'];
        $cvc = $_POST['cvc'];
        $response = Binding::payByBinding($order, $id, $cvc);
        return $response;
    }
    
    # @http GET /order/status/
    public function getOrderStatus(){
        Safety::declareProtectedZone();
        
        if( isset($_GET['id']) ){
            $id = intval($_GET['id']);
            $response = Operations::getOrderStatus(['orderNumber' => $id]);
        }elseif( isset($_GET['orderId']) ){
            $orderId = $_GET['orderId'];
            $response = Operations::getOrderStatus(['orderId' => $orderId]);
        }else{
            return 'Проверьте введенные данные';
        }
        
        if( $response['errorCode'] ){
            return $response['errorMessage'];
        }
        
        print_r($response);
    }
    
    # @http GET /order/pay/
    public function pay(){
        Safety::declareProtectedZone();
        
        $redirect = $_GET['redirect'];
        header("Location: $redirect");
    }
    
}