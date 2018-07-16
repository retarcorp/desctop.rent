<?php



namespace Classes\Models\Users;

use Classes\Utils\Sql;
use Classes\Models\Users\User;


class ProfileData {
    
    const TABLE_NAME = "profile_data";
    const VAL_UNDEFINED = "";
    
    static $fields = [
            0 => "Название компании" // companyName
            ,1 => "Регион" // region
            ,2 => "Название банка" //bankname
            ,3 => "КПП" //kpp
            ,4 => "БИК" //bik
            ,5 => "Расчетный счет" //paymentAccount
            ,6 => 'Фамилия' // surname
            ,7 => 'Имя' // name
            ,8 => 'Отчество' //lastname
            //,9 => 'Признак ЮЛ/ФЛ'
    ];

    static $legalEntityFields = [ 
            0 => "Название компании" // companyName
            ,1 => "Регион" // region
            ,2 => "Название банка" //bankname
            ,3 => "КПП" //kpp
            ,4 => "БИК" //bik
            ,5 => "Расчетный счет" //paymentAccount
        ];
        
    static $fieldsForIndividualFace = [ //\
            6 => 'Фамилия' // surname
            ,7 => 'Имя' // name
            ,8 => 'Отчество' //lastname
        ];
      
    /*static $fields = [
            0 => "Название компании" // companyName
            ,1 => "Регион" // region
            ,2 => "Название банка" //bankname
            ,3 => "КПП" //kpp
            ,4 => "БИК" //bik
            ,5 => "Расчетный счет" //paymentAccount
    ];*/ // origin
    
    public $data = [];
    private $user;
    public function __construct(int $uid){
        $this->uid = $uid;
        $this->user = new User($uid);
        # @TODO get from database profile data object and fill fields,  intert the data to the form
        $sql = Sql::getInstance(); 
        $rows = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE uid=$uid");
        foreach ($rows as $i => $iter) {
            $this->data[intval($iter['item'])] = $iter["value"];
        }
    }
    function getData() {
        return $this->data;
    }

    public function getValueFor($index){
        if(isset($this->data[$index])){
            return $this->data[$index];
        }
    }
    
    public function isIndividualFace() {
        $userFeature = $this->user->feature;
        return $userFeature == User::INDIVIDUAL_FACE;
    }
    
    public function update(){
        $sql = Sql::getInstance();
        $sql->query("DELETE FROM ".self::TABLE_NAME." WHERE uid=".$this->uid);
        
        $myFields = $this->isIndividualFace() ?  self::$fieldsForIndividualFace : self::$legalEntityFields ; // тут нужно будет проверять feature из users
        foreach($myFields as $i=>$val){
            $value = isset($this->data[$i]) ? str_replace(["'",'"','\\'],"",$this->data[$i]) : self::VAL_UNDEFINED;
            $sql->query("INSERT INTO ".self::TABLE_NAME." VALUES (default, {$this->uid}, $i, '$value')");
        }
    } // 11111
    
    /*public function update(){
        $sql = Sql::getInstance();
        $sql->query("DELETE FROM ".self::TABLE_NAME." WHERE uid=".$this->uid);
        foreach($fields as $i){
            $value = isset($this->data[$i]) ? str_replace(["'",'"','\\'],"",$this->data[$i]) : self::VAL_UNDEFINED;
            $sql->query("INSERT INTO ".self::TABLE_NAME." VALUES (default, {$this->uid}, $i, '$value')");
        }
    }*/ //origin method

}