<?php

namespace Classes\Utils;

// @deprecated

use Classes\Utils\Log;
use Classes\Exceptions\NonExistingItemException;

class Sql{
 
    private  $hostname;
	private  $username;
	private  $password;
	private  $mainDB;
	private  $DBsource;
	
	private $lastQuery;
	private $lastError;
	
    private static $link;
    
    const DB_HOSTNAME = "localhost";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "retarcorp-dev-2018";
    const DB_DATABASE = "desktop.rent";
    
	public function __construct(){
	
		if(self::$link == NULL){
		
			$this->hostname= self::DB_HOSTNAME;
			$this->username= self::DB_USERNAME;
			$this->password= self::DB_PASSWORD;
			$this->mainDB = self::DB_DATABASE;
			$this->DBSource = mysqli_connect($this->hostname, $this->username, $this->password,$this->mainDB);
			self::$link = $this->DBSource;
		}else{
		    $this->DBSource = self::$link;
		}
		
	}

	private static $self = null;
	public static function getInstance(){
		if(!self::$self){
			self::$self = new Sql();
		}
		return self::$self;
	}
	
	public function resource(){
		return $this->DBSource;
	}

	public function query($q){
		# print_r($q."\n");
	    $res = mysqli_query($this->resource(), $q);
	    
	    $this->lastQuery=$q;
	    $this->lastError = NULL;
	    if(mysqli_error($this->resource())){
	        $this->lastError = "Error executing query '$q': ".mysqli_error($this->resource());
		}
		//print_r($this->lastError."\n");
	    
		return $res;
	}
	
	public function execPrepared($query, $params){
	    $query = explode("?",$query);
	    if(count($query)-count($params)!=1){
	        $this->lastError = "Amount of params is not equal to amount of placeholders.";
	        return FALSE;
	    }
	    $q = $query[0];
	    foreach($params as $i=>$p){
	        $p = mysqli_real_escape_string($this->DBSource, $p);
	        $q.=$p.$query[$i+1];
	    }
	    return $this->query($q);
	}
	
	public function getLastError(){
	    return $this->lastError;
	}

    public function getRow($q){
        $data = $this->getAssocArray($q);
        return empty($data) ? [] : $data[0];
    }

	public function getAssocArray($Q){
		$res = $this->query($Q);
		$result = array();
		while($T = mysqli_fetch_assoc($res)) array_push($result, $T);
		return $result;
	}
	
	
	public function getArray($Q){
		$res = $this->query($Q);
		$result = array();
		while($T = mysqli_fetch_array($res)) array_push($result, $T);
		return $result;
	}

	public function getInsertId(){
		return mysqli_insert_id($this->resource());
	}
	
	public function getLastItem(string $table){
	    $q = "SELECT * FROM $table
	        ORDER BY id DESC
	        LIMIT 1";
	    $data = $this->getAssocArray($q);
	    
	    if( empty($data) ){
	        throw new NonExistingItemException("Table $table is empty");
	    }
	    
	    return $data[0];
	}
	
	public function logError(string $place){
	    if( $e = mysqli_error($this->resource()) ){
	        Log::error("In $place caught SQL-error: $e");
	    }
	}
	
	public function deleteFrom(string $table, array $params = []){
	    $q = "DELETE FROM $table";
	    $where = array_map(function($col){
	        return " $col = '?' ";
	    }, array_keys($params));
	    
	    $q .= $where ? " WHERE " . implode(" AND ", $where) : '';
	    
	    $this->execPrepared($q, array_values($params));
	}
	
	public function insertTo(string $table, array $values, array $columns = []){
	    $columns = empty($columns) ? '' : "(" . implode(', ', $columns) . ")";
	    
	    $placeHolders = array_fill(0, count($values), "'?'");
	    $placeHolders = implode(', ', $placeHolders);
	    
	    $q = "INSERT INTO $table $columns VALUES($placeHolders)";
	    $this->execPrepared($q, $values);
	}
	
	public function update(string $table, array $cols_values, array $where = []){
	    $columns = array_keys($cols_values);
	    $set = array_map(function($col){
	        return " $col = '?' ";
	    }, $columns);
	    
	    $data = implode(', ', $set);
	    
	    $q = "UPDATE $table SET $data";
	    
	    if( !empty($where) ){
	        $condition = array_map(function($col){
	            return " $col = '?' ";
	        }, array_keys($where));
	        $condition = implode(' AND ', $condition);
	        $q .= " WHERE $condition";
	    }
	    
	    $params = array_merge( array_values($cols_values), array_values($where) );
	    $this->execPrepared($q, $params);
	}
	
	public function getRowsAmountIn(string $table, string $where = ''){
        $q = "SELECT COUNT(*) amount FROM $table";
        $q .= $where ? " WHERE $where " : '';
        
        $data = $this->getRow($q);
        
        return intval($data['amount']);
	}

}