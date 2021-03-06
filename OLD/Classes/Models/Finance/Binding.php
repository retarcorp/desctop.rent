<?php

namespace Classes\Models\Finance;

use Classes\Models\Finance\Operations;

class Binding extends Operations {
    
    public static function payByBinding(string $order, string $id, string $cvc){
        return parent::execQuery('paymentOrderBinding.do', [
            'mdOrder' => $order,
            'bindingId' => $id,
            'cvc' => $cvc,
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
    }
    
    public static function unBindCard(string $id){
        return parent::execQuery('unBindCard.do', [
            'bindingId' => $id
        ]);
    }
    
    public static function bindCard(string $id){
        return parent::execQuery('bindCard.do', [
            'bindingId' => $id
        ]);
    }
    
    public static function changeBindingExpirations(string $id, int $year, int $month){
        return parent::execQuery('extendBinding.do', [
            'bindingId' => $id,
            'newExpiry' => $year . $month
        ]);
    }
    
    public static function getBindingsByClientId(int $client){
        return parent::execQuery('getBindings.do', [
            'clientId' => $client
        ]);
    }
    
    public static function getBindingsByCard(string $card){
        return parent::execQuery('getBindingsByCardOrId.do', [
            'pan' => $card
        ]);
    }
    
    public static function getBindingsByBindingId(string $bid){
        return parent::execQuery('getBindingsByCardOrId.do', [
            'bindingId' => $bid
        ]);
    }
    
}