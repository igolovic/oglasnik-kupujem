<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

$db = mysqli_connect("127.0.0.1", "root", "");
mysqli_select_db("kupujemn_buy");

$result = mysqli_query("select 
	a.id,
	a.title,
	u.email
	
	from buy_ad as a inner join buy_user as u on a.user_id = u.id
	
	where DATE_ADD(start_date, INTERVAL duration DAY) < NOW()"
);

while($row = mysqli_fetch_array($result))
{
/*
	$text = "
	<span style='font-family:Arial; font-size:14px; color:navy'>
	<p>
		<strong>Obavijest od Kupujem.net</strong>
	</p>
	<p>
	Vaš oglas:
	<em>" . $row["title"] . "</em> (šifra: " . $row["id"] . ") je istekao.
	</p>
	<p>
	Kako bi obnovili Vaš oglas, otiđite na adresu
	<br />
	<br />
	<a style='color:blue; font-weight:bold' href='http://www.kupujem.net/my-ads'>Moji oglasi</a>
	<br />
	<br />
	i kliknite 'Uredi' za navedeni oglas.
	<br />
	Nakon toga biti će Vam ponuđena opcija za produljenje trajanja oglasa.
	</p>
	Pozdrav, Vaš Kupujem.net
	</span>
	";
*/
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	
	mysqli_query("update buy_ad set status = 0 where id = " . $row["id"] . ";");
	
	/*
	try
	{
		mail($row["email"], "Kupujem.net - obavijest", $text, $headers);
	}
	catch(Exception $e){}
	*/
}

?>