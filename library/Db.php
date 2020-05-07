<?php

class Db extends Zend_Db
{
	protected $db;
	
	public function __construct()
	{
		$config = new Zend_Config(array('database' => array('adapter' => 'MYSQLI', 'params' => array('host' => '127.0.0.1', 'dbname' => 'kupujemn_buy', 'username' => 'root', 'password' => ''))));
		$this->db = Zend_Db::factory($config->database);
		
		$stmt = new Zend_Db_Statement_Mysqli($this->db, "set names UTF8");
        $stmt->execute();
	}
	
	public function getDb()
	{
		return $this->db;
	}
}
		
?>