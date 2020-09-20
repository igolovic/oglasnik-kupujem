<?php

require_once("Db.php");

class Default_Model_County
{
    protected $_id;
    protected $_name;
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setId($id)
	{
		$this->_id = $id;
	}
	
    public function getName()
    {
        return $this->_name;
    }	
	
	public function setName($name)
	{
		$this->_name = $name;
	}
	
    public function getCounties()
    {
		$d = new Db;
		
		$result = $d->getDb()->fetchAll("select id, name from buy_county order by id");
		
		$entries = array();
        foreach ($result as $row) {
            $entry = new Default_Model_County();
            $entry->setId($row["id"]);
			$entry->setName($row["name"]);
			$entries[] = $entry;
        }		
		
        return $entries;
    }
}