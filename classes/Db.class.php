<?php
class DB {

	//Attributs
	static private $connection = null;
	static private $host = 'localhost';
	static private $dbname = 'dbnf17p001';
	static private $user = 'mewen';
	static private $password = 'Jinjir29';
	static private $isConnected = false;

	private function DB (){
	}

	public static function connect(){
		if(!self::$isConnected) {
			$request = 'host='.self::$host.' dbname='.self::$dbname.' user='.self::$user.' password='.self::$password.' connect_timeout=5';
			self::$connection = pg_connect($request) or die('La connection à la BD a échoué');
			self::$isConnected = true;
		}
		return self::$connection;
	}

	public static function close(){
		if(self::$isConnected) {
			pg_close(self::$connection);
			self::$isConnected = false;
		}
	}
};