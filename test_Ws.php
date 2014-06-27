<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
hello
</body>
</html>
<?php
echo "test";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,'http://localhost/gitstarter/index.php/api/login');	
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('email:quagnitia.testuser1@gmail.com','password:qspluser1'));
	curl_exec($ch);
?>