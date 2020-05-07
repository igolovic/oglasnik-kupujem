<?php

require_once("Db.php");

class Default_Model_User
{
    protected $_id;
	protected $_userName;
	protected $_password;
	protected $_name;
	protected $_lastName;
	protected $_countyId;
	protected $_countyName;	
	protected $_city;
	protected $_postalCode;
	protected $_streetName;
	protected $_streetNumber;
	protected $_telephone1;
	protected $_telephone2;
	protected $_email;
	protected $_uniqueId;
	protected $_confirmed;

    public function getId()
    {
        return $this->_id;
    }
	
	public function setId($id)
	{
		$this->_id = $id;
	}
	
    public function getUserName()
    {
        return $this->_userName;
    }
	
	public function setUserName($userName)
	{
		$this->_userName = $userName;
	}

    public function getPassword()
    {
        return $this->_password;
    }
	
	public function setPassword($password)
	{
		$this->_password = $password;
	}

    public function getName()
    {
        return $this->_name;
    }
	
	public function setName($name)
	{
		$this->_name = $name;
	}

    public function getLastName()
    {
        return $this->_lastName;
    }
	
	public function setLastName($lastName)
	{
		$this->_lastName = $lastName;
	}

    public function getCountyId()
    {
        return $this->_countyId;
    }
	
	public function setCountyId($countyId)
	{
		$this->_countyId = $countyId;
	}

    public function getCountyName()
    {
        return $this->_countyName;
    }

    public function getCity()
    {
        return $this->_city;
    }
	
	public function setCity($city)
	{
		$this->_city = $city;
	}	

    public function getPostalCode()
    {
        return $this->_postalCode;
    }
	
	public function setPostalCode($postalCode)
	{
		$this->_postalCode = $postalCode;
	}

    public function getAddress()
    {
        return $this->_address;
    }
	
	public function setAddress($address)
	{
		$this->_address = $address;
	}

    public function getStreetName()
    {
        return $this->_streetName;
    }

	public function setStreetName($streetName)
	{
		$this->_streetName = $streetName;
	}

    public function getStreetNumber()
    {
        return $this->_streetNumber;
    }

	public function setStreetNumber($streetNumber)
	{
		$this->_streetNumber = $streetNumber;
	}

    public function getTelephone1()
    {
        return $this->_telephone1;
    }
	
	public function setTelephone1($telephone1)
	{
		$this->_telephone1 = $telephone1;
	}

    public function getTelephone2()
    {
        return $this->_telephone2;
    }
	
	public function setTelephone2($telephone2)
	{
		$this->_telephone2 = $telephone2;
	}	

    public function getEmail()
    {
        return $this->_email;
    }
	
	public function setEmail($email)
	{
		$this->_email = $email;
	}
	
    public function getUniqueId()
    {
        return $this->_uniqueId;
    }
	
	public function setUniqueId($uniqueId)
	{
		$this->_uniqueId = $uniqueId;
	}
	
    public function getConfirmed()
    {
        return $this->_confirmed;
    }
	
	public function setConfirmed($confirmed)
	{
		$this->_confirmed = $confirmed;
	}
	
	public function updateUser(
	 $id,
	 $password,
	 $name,
	 $lastName,
	 $countyId,
	 $city,
	 $postalCode,
	 $streetName,
	 $streetNumber,
	 $telephone1,
	 $telephone2
	)
	{
		$d = new Db;
		
		$sql = "update buy_user set
		password = '" . $password . "',
		name = '" . trim($name) . "',
		last_name = '" . trim($lastName) . "',
		county_id = " . $countyId . ",
		city = '" . trim($city) . "',
		postal_code = '" . $postalCode . "',
		street_name = '" . trim($streetName) . "',
		street_number = '" . trim($streetNumber) . "',
		telephone1 = '" . trim($telephone1) . "',
		telephone2 = '" . trim($telephone2) . "'
		where id = " . $id . ";";
		
		$stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
		$stmt->execute();	
	}
	
	public function confirmed($uid)
	{
		$d = new Db();
		
		if($d->getDb()->fetchOne("select unique_id from buy_user where unique_id = '" . $uid . "';") == false)
		{
			return false;
		}
		else
		{
			$sql = "update buy_user set confirmed = 1 where unique_id = '" . $uid . "';";
			$stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
			$stmt->execute();
			return true;
		}
	}
	
	public function nameExists($username)
	{
		$d = new Db;
		
		return $d->getDb()->fetchOne("select username from buy_user where username = '" . $username . "';");
	}
	
	public function emailExists($email)
	{
		$d = new Db;
		
		return $d->getDb()->fetchOne("select email from buy_user where email = '" . trim($email) . "';");
	}
	
	public function insertUser(
		$userName,
		$password,
		$name,
		$lastName,
		$countyId,	
		$city,
		$postalCode,
		$streetName,
		$streetNumber,
		$telephone1,
		$telephone2,
		$email
	)
	{
		$d = new Db;
		$uniqueId = uniqid("", true);
		$sql = "insert into buy_user(id, username, password, name, last_name, county_id, city, postal_code, street_name, street_number, telephone1, telephone2, email, unique_id, confirmed) 
		values (
		null,
		'" . trim($userName) . "',
		'" . $password . "',
		'" . trim($name) . "',
		'" . trim($lastName) . "',
		'" . $countyId . "',
		'" . trim($city) . "',
		'" . trim($postalCode) . "',
		'" . trim($streetName) . "',
		'" . trim($streetNumber) . "',	
		'" . trim($telephone1) . "',
		'" . trim($telephone2) . "',
		'" . trim($email) . "',
		'" . $uniqueId . "',
		1);";	// confirmed - set to 1 because e-mail confirmation is not working, this site is only in demo mode and will stay that way :)
		
		$stmt = new Zend_Db_Statement_Mysqli($d->getDb(), $sql);
		if($stmt->execute() != false)
		{
			$mail = new Zend_Mail("UTF-8");
			$body = "
<span style='font-weight:strong; color:navy; font-family:Arial; margin:0px; padding:0px'>
<img alt='' src='http://www.kupujem.net/res/emailLogo.gif'><br /><br />
Dobrodošli na Kupujem.net!
<br/><br/>
Kako biste aktivirali Vaš Kupujem.net korisnički račun kliknite na dolje navedeni link ili ga kopirajte, zalijepite u adresno polje preglednika
i stisnite tipku Enter. Nakon toga moći ćete se prijaviti u sustav, predavati oglase i uređivati svoje korisničke podatke.
<br/><br/><br/>
<a href='http://www.kupujem.net/confirm?uid=" . $uniqueId . "'>http://www.kupujem.net/confirm?uid=" . $uniqueId . "</a>
<br/><br/><br/>
Vaši korisnički podaci:<br />
Korisničko ime: " . trim($userName) . "<br />
Lozinka: " . trim($password) . "
<br/><br/><br/>
Pozdrav, Vaš Kupujem.net
<br/><br/><br/>
<p>
<span style='font-size:11px'>Za sva pitanja, komentare i sugestije obratite se na <a href='mailto:info@kupujem.net'>info@kupujem.net</a></span><br />
<span style='font-size:11px'>U slučaju tehničkih problema kontaktirajte nas na <a href='mailto:admin@kupujem.net'>admin@kupujem.net</a></span>
</p>
</span>
				";
			try
			{	
				$mail->setBodyHtml($body);	
				$mail->setFrom('kupujemn@depri1.srv16.com', 'Kupujem.net');
				$mail->addTo($email, $email);
				$mail->setSubject('Kupujem.net - Aktivacija Vašeg računa');
				$mail->send();
			}
			catch(Zend_Exception $e)
			{
				print $e->getMessage();
			}
			
			return true;
		}
	}

	public function getUserByEmail($email)
	{
		$db = new Db;
		
		$sql = "select 
		u.id, 
		u.username,
		u.password,
		u.name,
		u.last_name,
		u.county_id,
		u.city,
		u.postal_code,
		u.street_name,
		u.street_number,	
		u.telephone1, 
		u.telephone2, 
		u.email, 
		u.unique_id, 
		u.confirmed,
		c.name as county_name
		
		from buy_user as u inner join buy_county as c on c.id = u.county_id
		
		where u.email = '" . trim($email) . "';";
		
		
		$row = $db->getDb()->fetchRow($sql);
		
		$this->_id = $row["id"];
		$this->_userName = $row["username"];
		$this->_password = $row["password"];		
		$this->_name = $row["name"];
		$this->_lastName = $row["last_name"];
		$this->_countyId = $row["county_id"];		
		$this->_city = $row["city"];		
		$this->_postalCode = $row["postal_code"];					
		$this->_streetName = $row["street_name"];
		$this->_streetNumber = $row["street_number"];					
		$this->_telephone1 = $row["telephone1"];
		$this->_telephone2 = $row["telephone2"];						
		$this->_email = $row["email"];
		$this->_uniqueId = $row["unique_id"];
		$this->_confirmed = $row["confirmed"];
		$this->_countyName = $row["county_name"];		
	}

	public function getUserByName($userName)
	{
		$db = new Db;
		
		$sql = "select 
		u.id, 
		u.username,
		u.password,
		u.name,
		u.last_name,
		u.county_id,
		u.city,
		u.postal_code,
		u.street_name,
		u.street_number,	
		u.telephone1, 
		u.telephone2, 
		u.email, 
		u.unique_id, 
		u.confirmed,
		c.name as county_name
		
		from buy_user as u inner join buy_county as c on c.id = u.county_id
		
		where u.username = '" . trim($userName) . "';";
		
		
		$row = $db->getDb()->fetchRow($sql);
		
		$this->_id = $row["id"];
		$this->_userName = $row["username"];
		$this->_password = $row["password"];		
		$this->_name = $row["name"];
		$this->_lastName = $row["last_name"];
		$this->_countyId = $row["county_id"];		
		$this->_city = $row["city"];		
		$this->_postalCode = $row["postal_code"];					
		$this->_streetName = $row["street_name"];
		$this->_streetNumber = $row["street_number"];					
		$this->_telephone1 = $row["telephone1"];
		$this->_telephone2 = $row["telephone2"];						
		$this->_email = $row["email"];
		$this->_uniqueId = $row["unique_id"];
		$this->_confirmed = $row["confirmed"];
		$this->_countyName = $row["county_name"];		
	}
	
	public function getUserById($userId)
	{
		$db = new Db;
		
		$sql = "select 
		u.id, 
		u.username, 
		u.password, 
		u.name,
		u.last_name,
		u.county_id, 
		u.city, 
		u.postal_code, 
		u.street_name,
		u.street_number,
		u.telephone1, 
		u.telephone2, 
		u.email, 
		u.unique_id, 
		u.confirmed,
		c.name as county_name 
		
		from buy_user as u inner join buy_county as c on c.id = u.county_id
		
		where u.id = " . $userId . " ;";

		$row = $db->getDb()->fetchRow($sql);
		
		$this->_id = $row["id"];
		$this->_userName = $row["username"];
		$this->_password = $row["password"];		
		$this->_name = $row["name"];
		$this->_lastName = $row["last_name"];
		$this->_countyId = $row["county_id"];		
		$this->_city = $row["city"];		
		$this->_postalCode = $row["postal_code"];					
		$this->_streetName = $row["street_name"];
		$this->_streetNumber = $row["street_number"];							
		$this->_telephone1 = $row["telephone1"];
		$this->_telephone2 = $row["telephone2"];					
		$this->_email = $row["email"];
		$this->_uniqueId = $row["unique_id"];
		$this->_confirmed = $row["confirmed"];
		$this->_countyName = $row["county_name"];		
	}
	
	public function loginApproved($username, $password)
	{
		$db = new Db;
		
		$sql = "select username from buy_user where username='" 
		. addslashes(trim($username)) .
		"' and password='"
		. addslashes($password) .
		"' and confirmed = 1;";

		if($db->getDb()->fetchOne($sql) == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}

?>