<?php

require_once("Db.php");

class Default_Model_Ad
{
    protected $_id;
    protected $_title;
    protected $_text;
    protected $_userId;
    protected $_startDate;
    protected $_duration;
    protected $_status;
    protected $_categoryId;
    protected $_categoryName;
    protected $_countyArray;	
    
    public function __construct()
    {
	    $_countyArray = array();
    }
	
    public function getId()
    {
        return $this->_id;
    }
	
    public function setId($id)
    {
	    $this->_id = $id;
    }
    
    public function getTitle()
    {
	    return $this->_title;
    }
    
    public function setTitle($title)
    {
	    $this->_title = $title;
    }
    
    public function getText()
    {
	    return $this->_text;
    }
    
    public function setText($text)
    {
	    $this->_text = $text;
    }
	    
    public function getUserId()
    {
	    return $this->_userId;
    }
    
    public function setUserId($userId)
    {
	    $this->_userId = $userId;
    }

    public function getStartDateCro()
    {
	    $local = strtotime($this->_startDate);
	    $local = strftime("%d. %B %Y. - %H:%M:%S", $local);
	    $local = iconv('ISO-8859-2', 'UTF-8', $local);	
	    return $local;
    }
    
    public function getStartDate()
    {
	    return $this->_startDate;
    }
    
    public function setStartDate($startDate)
    {
	    $this->_startDate = $startDate;
    }
    
    public function getDuration()
    {
	    return $this->_duration;
    }
    
    public function setDuration($duration)
    {
	    $this->_duration = $duration;
    }
    
    public function getEndDateCro()
    {
	    $endTimestamp = strtotime($this->getStartDate()) + 60*60*24*$this->getDuration();
	    
	    $local = strftime("%d. %B %Y. - %H:%M:%S", $endTimestamp);
	    $local = iconv('ISO-8859-2', 'UTF-8', $local);	
	    return $local;
    }
    
    public function getStatus()
    {
	    return $this->_status;
    }
    
    public function setStatus($status)
    {
	    $this->_status = $status;
    }
    
    public function getCategoryId()
    {
	    return $this->_categoryId;
    }
    
    public function setCategoryId($categoryId)
    {
	    $this->_categoryId = $categoryId;
    }
    
    public function getCategoryName()
    {
	    return $this->_categoryName;
    }
    
    public function setCategoryName($categoryName)
    {
	    $this->_categoryName = $categoryName;
    }
    
    public function getCountyArray()
    {
	    return $this->_countyArray;
    }
    
    public function setCountyArray($countyArray)
    {
	    $this->_countyArray = $countyArray;
    }
    
    public function prolong($id)
    {
	    $d = new Db;
	    
	    $sql = "update buy_ad set duration = duration + 14, status = 1 where id = " . $id . ";";
	    
	    $d = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
	    
	    $d->execute();
    }
	
    public function getAdsByCategory($categoryId)
    {
	    $d = new Db;
	    
	    $sql = "select 
	    a.id,
	    a.title,
	    a.text,
	    a.user_id,
	    a.start_date,
	    a.duration,
	    a.status,
	    c.name as category
	    
	    from buy_ad as a 
	    inner join buy_user as u on u.id = a.user_id
	    inner join buy_category as c on c.id = a.category_id
	    where a.category_id = " . $categoryId . " and a.status = 1;";		
	    
	    $result = $d->getDb()->fetchAll($sql);
	    
	    $entries = array();
	    foreach ($result as $row) {
		$entry = new Default_Model_Ad();
		$entry->setId($row["id"]);
			    $entry->setTitle($row["title"]);
		$entry->setText(substr($row["text"],0,100) . "...");
			    $entry->setCategoryName($row["category"]);	
		$entry->setStartDate($row["start_date"]);
			    $entries[] = $entry;
	    }
	    
	    return $entries;
    }
    
    public function search($searchArray)
    {
	    $d = new Db;

	    $searchStringQuoted = array();
	    foreach($searchArray as $word)
	    {
		    $searchStringQuoted[] = "'%" . $word . "%'";
	    }
	    
	    $searchStringTitle = implode(" or a.title like ", $searchStringQuoted);
	    $searchStringText = implode(" or a.text like ", $searchStringQuoted);
	    
	    $searchString = "a.title like " . $searchStringTitle . " or a.text like " . $searchStringText;
	    
	    $sql = "select 
	    a.id,
	    a.title,
	    a.text,
	    a.start_date,
	    c.name as category
	    
	    from buy_ad as a 
	    inner join buy_category as c on c.id = a.category_id
	    where (" . $searchString . ") and a.status = 1;";		
	    
	    $result = $d->getDb()->fetchAll($sql);
	    
	    $entries = array();
    foreach ($result as $row) {
	$entry = new Default_Model_Ad();
	$entry->setId($row["id"]);
		    $entry->setTitle($row["title"]);
	$entry->setText($row["text"]);
		    $entry->setCategoryName($row["category"]);		
	$entry->setStartDate($row["start_date"]);
		    $entries[] = $entry;
    }
    return $entries;
    }

    public function updateAd($adId, $title, $text, $duration, $allCounties, $countyArray, $adCategory, $userName)
    {
	    $d = new Db;
	    $userId = $d->getDb()->fetchOne("select id from buy_user where username = '" . $userName . "';");
	    
	    $sql = "update buy_ad set 
	    
	    title = '" . trim($title) . "',
	    text = '" . trim($text) . "',
	    status = 1,
	    category_id = " . $adCategory . "
	    where id = " . $adId . " and user_id = " . $userId . ";";

	    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
	    $stmt->execute();
    
	    $sql = "select user_id from buy_ad where user_id = " . $userId . " and id = " . $adId . ";";	
	    $result = $d->getDb()->fetchOne($sql);
	    if($result)
	    {
		    $sql = "delete from buy_ad_county where ad_id = " . $adId . ";";
		    
		    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
		    $stmt->execute();
		    
		    if($allCounties)
		    {
				$stmt = new Zend_Db_Statement_Mysqli($d->getDb(), "insert into buy_ad_county(ad_id, county_id) values(" . $adId . ", -1);");
			    $stmt->execute();	
		    }
		    else
		    {
			    foreach($countyArray as $countyId)
			    {
				    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), "insert into buy_ad_county(ad_id, county_id) values(" . $adId . ", " . $countyId . ");");
				    $stmt->execute();
			    }
		    }
	    }	
    }

    public function deleteAd($userName, $adId)
    {
	    $d = new Db;
	    
	    $userId = $d->getDb()->fetchOne("select id from buy_user where username = '" . trim($userName) . "';");

	    $sql = "select user_id from buy_ad where user_id = " . $userId . " and id = " . $adId . ";";	
	    $result = $d->getDb()->fetchOne($sql);
	    if($result)
	    {
		    $sql = "delete from buy_ad_county where ad_id = " . $adId . ";";
		    
		    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
		    $stmt->execute();
	    }
	    
	    $sql = "delete from buy_ad where id = " . $adId . " and user_id = " . $userId . ";";

	    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
    $stmt->execute();
    }
    
    public function fetchAd($adId)
    {
	    $d = new Db;

	    $sql = "select 
	    a.id,
	    a.title,
	    a.text,
	    a.user_id,
	    a.start_date,
	    a.duration,
	    a.status,
	    c.name as category
	    
	    from buy_ad as a 
	    inner join buy_user as u on u.id = a.user_id
	    inner join buy_category as c on c.id = a.category_id
	    where a.id = " . $adId . ";";

	    $row = $d->getDb()->fetchRow($sql);
	    
	    $this->_id = $row["id"];
	    $this->_title = $row["title"];
	    $this->_text = nl2br($row["text"]);
	    $this->_userId = $row["user_id"];
	    $this->_startDate = $row["start_date"];
	    $this->_duration = $row["duration"];
	    $this->_status = $row["status"];
	    $this->_categoryName = $row["category"];
	    
	    
	    $sql = "select 		ac.ad_id,
	    					ac.county_id,
	    					c.name 
				from 		buy_ad_county as ac 
				inner join 	buy_county as c 
				on			c.id = ac.county_id
	    		where 		ac.ad_id = " . $this->_id . ";";
		
		$this->_countyArray = array();
	    $counties = $d->getDb()->fetchAll($sql);
	    foreach($counties as $county)
	    {
		    $this->_countyArray[] = $county["name"];
	    }
    }

    public function fetchUserAds($userId)
    {
	    $d = new Db;
	    $userId = $d->getDb()->fetchOne("select id from buy_user where username = '" . $userId . "';");

	    $sql = "select 
	    a.id,
	    a.title,
	    a.text,
	    a.user_id,
	    u.name,
	    a.start_date,
	    a.duration,
	    a.status,
	    c.name as category
	    
	    from buy_ad as a 
	    inner join buy_user as u on u.id = a.user_id
	    inner join buy_category as c on c.id = a.category_id
	    where u.id = " . $userId . "
		    
	    order by a.start_date desc";

	    $result = $d->getDb()->fetchAll($sql);
	    
	    $entries   = array();
	    foreach ($result as $row) {
		    $entry = new Default_Model_Ad();
		    $entry->setId($row["id"]);
		    $entry->setTitle($row["title"]);
		    $entry->setText($row["text"]);
		    $entry->setCategoryName($row["category"]);
		    $entry->setStartDate($row["start_date"]);
		    $entry->setstatus($row["status"]);
		    $entries[] = $entry;
	    }
	    
    return $entries;		
    }
    
    public function insertAd($title, $text, $duration, $allCounties, $countyArray, $adCategory, $userName)
    {
	    $d = new Db;
	    $userId = $d->getDb()->fetchOne("select id from buy_user where username = '" . $userName . "';");
	    
	    $sql = "insert into buy_ad(id, title, text, user_id, start_date, duration, status, category_id) values (
	    null, '"
	    . trim($title) . "','"
	    . trim($text) . "',"
	    . $userId . ","
	    . "NOW(),"
	    . $duration . ","
	    . "1,"
	    . $adCategory . ")";
		    
	    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
	    $stmt->execute();
	    
	    $lastInsertId = $d->getDb()->lastInsertId();
	    
	    if($allCounties)
	    {
		    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), "insert into buy_ad_county(ad_id, county_id) values(" . $lastInsertId . ", -1);");
		    $stmt->execute();	
	    }
	    else
	    {
		    foreach($countyArray as $countyId)
		    {
			    $stmt = new Zend_Db_Statement_Mysqli($d->getDb(), "insert into buy_ad_county(ad_id, county_id) values(" . $lastInsertId . ", " . $countyId . ");");
			    $stmt->execute();
		    }
	    }
    }

    public function fetchLastTenAds()
    {
		$d = new Db;
		
		$sql = "select 
		a.id,
		a.title,
		a.text,
		a.user_id,
		u.name,
		a.start_date,
		a.duration,
		a.status,
		c.name as category
		
		from buy_ad as a 
		inner join buy_user as u on u.id = a.user_id
		inner join buy_category as c on c.id = a.category_id
		
		where a.status = 1
			
		order by a.start_date desc
		limit 10";

		$result = $d->getDb()->fetchAll($sql);
		
		$entries   = array();
		foreach ($result as $row) {
		    $entry = new Default_Model_Ad();
		    $entry->setId($row["id"]);
		    $entry->setTitle($row["title"]);
		    $entry->setText(substr($row["text"],0,100) . "...");
		    $entry->setCategoryName($row["category"]);		
		    $entry->setStartDate($row["start_date"]);
		    $entries[] = $entry;
		}
		
        return $entries;
    }
}

?>