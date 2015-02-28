<?php

require_once("connection.php");

/*
* Behöver mer documentation
*/

/*
* Här genererar vi en salt för våran lösenordskryptering, ska ej kallas
*/
function generateSalt() 
{
	$uniqueRandomString = md5(uniqid(mt_rand(), true));

	$base64String = base64_encode($uniqueRandomString);

	$modBase64String = str_replace("+", ".", $base64String);

	$salt = substr($modBase64String, 0, 22);

	return $salt;
}

/*
*	Här krypterar vi lösenordet, använd denna i er registreringssida.
*/
function passwordEncrypt($password) 
{
	$hashFormat = "$2y$10$";

	$salt = generateSalt();

	$key = $hashFormat . $salt;

	$hash = crypt($password, $key);

	$hash = md5($hash);

	return array('key' => $key, 'hash' => $hash);
}

/*
*	validerar lösenordet, denna kallas av validateUser funktionen
*/
function validatePassword($input, $password, $key) 
{
	if(md5(crypt($input,$key)) == $password) 
	{
		return true;
	}

	return false;
}


/*
* validerar att det är rätt lösenord för användaren, framtidia tips är att låsa användaren efter x antal försök att logga in
*/
function validateUser($username, $password) 
{
	if($username == "" || $password == "") 
	{
    	return false;
	}

	$user = DBRow("SELECT * FROM litter_users
				WHERE username = '$username'");

	if($user) 
	{
		$validPass = validatePassword($password,$user[0]['password'],$user[0]['hashkey']);

		if($validPass) 
		{
			$array = array(
					'id' => $user[0]['id']

				);
			return $array;
		}
	} 
	else 
	{
		return false;
	}
}

?>