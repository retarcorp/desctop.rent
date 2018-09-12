<?php

namespace Classes\Utils;
use Classes\Utils\DataHolder;

class Sms{

    const API_LOGIN = "192311668";
	const API_PASSWORD = "6NNR2wGu";
	
	const API_STREAMTELECOM_LOGIN = "DesktopRent"; //\\
	const API_STREAMTELECOM_PASSWORD = "20VM18Capital";//\\
	const TEST_LOGIN = "DesktopRent"; //\\
	
	// stream-telecom sms 
	public static function send(string $phone,string $message) {//\\
		$curlQuery = curl_init();
		curl_setopt($curlQuery, CURLOPT_URL, "http://gateway.api.sc/rest/Session/session.php");
		curl_setopt($curlQuery, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlQuery, CURLOPT_POST, true);
		curl_setopt($curlQuery, CURLOPT_POSTFIELDS, "login=".self::API_STREAMTELECOM_LOGIN."&password=".self::API_STREAMTELECOM_PASSWORD);
		$APIkey =  @json_decode(curl_exec($curlQuery), true); 

		$curlSms = curl_init(); 
		curl_setopt($curlSms, CURLOPT_URL, "http://gateway.api.sc/rest/Send/SendSms/");
		curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlSms, CURLOPT_POST, true);
		curl_setopt($curlSms, CURLOPT_POSTFIELDS, "sessionId=".$APIkey."&sourceAddress=".self::TEST_LOGIN."&destinationAddress=".$phone."&data=".$message);
		$result = @json_decode(curl_exec($curlSms), true);
		return $result;
	}
	
	public function generateSmsCode(){
        return rand(100000,999999);
    }

	/**
	 *  @author Denis Latushkin
	 *  @param \string phone Phone number to send an sms
	 *  @param \string message Text to be sent via sms, max=69 symbols
	 */
	public static function sendBelarus(string $phone,string $message) {
		$curl = curl_init(); 
	
		curl_setopt($curl, CURLOPT_URL, 'http://api.rocketsms.by/json/send');	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 
            "username=".self::API_LOGIN."&password=".self::API_PASSWORD."&phone=" . $phone . "&text=" . $message);
		
		$result = @json_decode(curl_exec($curl), true);
		
		if ($result && isset($result['id'])) {
			return  $result['id'];
		} elseif ($result && isset($result['error'])) {
            #print_r($result);
			return false;
		} else {
			return false;
		}
	}

	const LOGIN_CODE = 1;
	const JOINED_USER = 2;
	
	public static function getMessage($type, $data){
		switch($type){
			case self::LOGIN_CODE:
				return self::getLoginCodeMessage($data);
			
			case self::JOINED_USER:
			    return self::getJoinedUserMessage($data);
		}
	}
	
	private static function getJoinedUserMessage(DataHolder $data){
	    return "Сотрудник {$data->surname} {$data->name} {$data->patronymic}, телефон {$data->phone} запрашивает разрешение на присоединение к команде.";
	}

	private static function getLoginCodeMessage($data){
		return "Код для доступа на Desktop.rent: $data";
	}
	
}