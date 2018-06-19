<?php



namespace Classes\Models\Users;

use Classes\Utils\Sql;



class ProfileData {
    
    const TABLE_NAME = "profile_data";
    static $fields = [
            0 => "Название компании" // companyName
            ,1 => "Регион" // region
            ,2 => "Название банка" //bankname
            ,3 => "КПП" //kpp
            ,4 => "БИК" //bik
            ,5 => "Расчетный счет" //paymentAccount
        ];
        
    private $data = [];
    public function __construct(int $uid){
        $this->uid = $uid;
        # @TODO get from database profile data object and fill fields,  instert the data to the form
        $sql = Sql::getInstance(); 
        $rows = $sql->getAssocArray("SELECT * FROM ".self::TABLE_NAME." WHERE uid=$uid");
        foreach ($rows as $i => $iter) {
            $this->data[$i] = $rows[$i]["value"];
        }

		/*foreach ($rows as $row) {
			// $this->{$row['item']} = $row['value'];
			if ($row['item'] == 'companyName') {
				$this->companyName = $row['value'];
			}
			if ($row['item'] == 'region') {
				$this->region = $row['value'];
			}
			if ($row['item'] == 'bankName') {
				$this->bankName = $row['value'];
			}
			if ($row['item'] == 'kpp') {
				$this->kpp = $row['value'];
			}
			if ($row['item'] == 'bik') {
				$this->bik = $row['value'];
			}
			if ($row['item'] == 'paymentAccount') {
				$this->paymentAccount = $row['value'];
			}
		}*/
        /*$this->companyName = $r['companyName'];
        $this->region = $r['region'];
        $this->bankName = $r['bankName'];
        $this->kpp = $r['kpp'];
        $this->bik = $r['bik'];
        $this->paymentAccount = $r['paymentAccount'];*/
    }
    function getData() {
        return $this->data;
    }
    /*public function update(transfer uid here?){ 
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