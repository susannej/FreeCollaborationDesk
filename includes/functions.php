<?php
function checkid($id) {
	if(!is_numeric($id)){
		echo "<p>Invalid ID</p>";
		exit;
		}else{
	return $id;
	}
}

function stri_replace( $find, $replace, $string ) {
// Case-insensitive str_replace()

  $parts = explode( strtolower($find), strtolower($string) );

  $pos = 0;

  foreach( $parts as $key=>$part ){
    $parts[ $key ] = substr($string, $pos, strlen($part));
    $pos += strlen($part) + strlen($find);
  }

  return( join( $replace, $parts ) );
}


function check_email_address($email) {
 if (!preg_match("/^( [a-zA-Z0-9] )+( [a-zA-Z0-9\._-] )*@( [a-zA-Z0-9_-] )+( [a-zA-Z0-9\._-] +)+$/" , $email)) {
  return false;
 }
 return true;
}

function show_user_level($type) {
switch ($type) {
    case 0:
        $show_user_level = "Administrator";
        break;
    case 1:
        $show_user_level = "User";
		break;
    case 2:
        $show_user_level = "Support Staff";
		break;
    case 3:
        $show_user_level = "";
		break;
}
return $show_user_level;
}

function show_type_name($type) {
switch ($type) {
    case 0:
        echo "Support Staff";
        break;
    case 1:
        echo "Departments";
		break;
    case 2:
        echo "Request Type";
		break;
    case 3:
        echo "Device Type";
		break;
}
}

function show_type_col($type) {
switch ($type) {
    case 0:
        $show_type_col = "call_staff";
        break;
    case 1:
        $show_type_col = "call_department";
		break;
    case 2:
        $show_type_col = "call_request";
		break;
    case 3:
        $show_type_col = "call_device";
		break;
}
return $show_type_col;
}


function call_status($value) {
switch ($value) {
    case '0':
        $value = "Active";
        break;
    case '1':
        $value = "Closed";
		break;
}
	return $value;
}

///////////
function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}

	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
?>