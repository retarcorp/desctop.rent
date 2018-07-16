<?php



namespace Classes\Models\Users;

use Classes\Utils\Sql;



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
        ];
        
    public $data = [];
    public function __construct(int $uid){
        $this->uid = $uid;
        # @TODO get from database profile data object and fill fields,  intert the data to the form
        $sql = Sql::getInstance(); 
        $rows = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE uid=$uid");
        foreach ($rows as $i => $iter) {
            $this->data[intval($i)] = $rows[$i]["value"];
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

    public function update(){
        $sql = Sql::getInstance();
        $sql->query("DELETE FROM ".self::TABLE_NAME." WHERE uid=".$this->uid);
        
        foreach(self::$fields as $i=>$name){
            
            $value = isset($this->data[$i]) ? str_replace(["'",'"','\\'],"",$this->data[$i]) : self::VAL_UNDEFINED;
            $sql->query("INSERT INTO ".self::TABLE_NAME." VALUES (default, {$this->uid}, $i, '$value')");
        }
    }

    /*public function update(){ 
        # @TODO update in db all the fields for

        $sql = Sql::getInstance(); 
        $sql->query("UPDATE {self::TABLE_NAME} SET value=(
            CASE item
                WHEN 'companyName' THEN '{mysqli_real_escape_string($sql->resource(), $this->companyName)}' --спросить real_escape_string
                WHEN 'region' THEN '{mysqli_real_escape_string($sql->resource(), $this->region)}'
                WHEN 'bankName' THEN '{mysqli_real_escape_string($sql->resource(),$this->bankName)}'
                WHEN 'kpp' THEN '{mysqli_real_escape_string($this->kpp)}'
                WHEN 'bik' THEN '{mysqli_real_escape_string($this->bik)}'
                WHEN 'paymentAccount' THEN '{mysqli_real_escape_string($this->paymentAccount)}'
            END
        )
         WHERE uid='{$this->uid}'); 
    }*/

}