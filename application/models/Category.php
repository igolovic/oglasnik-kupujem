<?php

require_once("Db.php");

class Default_Model_Category
{
    protected $_id;
    protected $_name;
    protected $_description;
	protected $_adCount;
	
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
	
    public function getDescription()
    {
        return $this->_description;
    }	
	
	public function setDescription($description)
	{
		$this->_description = $description;
	}
	
    public function getAdCount()
    {
        return $this->_adCount;
    }		

    public function setAdCount($adCount)
    {
        $this->_adCount = $adCount;
    }
	
	public function getCategoryById($id)
	{
		$d = new Db;
		
		$result = $d->getDb()->fetchRow("select 
		name, 
		description, 
		(select count(id) 
		from buy_ad where category_id = " . $id . " and status = 1) as ad_count 
		
		from buy_category where id = " . $id . ";");
		
		$this->_name = $result["name"];
		$this->_description = $result["description"];
		$this->_adCount = $result["ad_count"];		
	}
	
    public function fetchAllOrdered()
    {
		$d = new Db;
		
		$result = $d->getDb()->fetchAll("select id, name, description, (select count(id) from buy_ad where category_id = buy_category.id and status = 1) as ad_count from buy_category order by name");
		
		$entries = array();
        foreach ($result as $row) {
            $entry = new Default_Model_Category();
            $entry->setId($row["id"]);
			$entry->setName($row["name"]);
            $entry->setDescription($row["description"]);
            $entry->setAdCount($row["ad_count"]);			
			$entries[] = $entry;
        }		
		
        return $entries;
    }
}