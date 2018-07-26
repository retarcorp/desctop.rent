<?php

namespace Classes\Controllers;

use Classes\Models\Users\UsersFactory;
use Classes\Models\Users\User;
use Classes\Models\Finance\Transaction;
use Classes\Utils\Safety;

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
            return $transaction->toArray();
        }, $transactions);
    }
    
}