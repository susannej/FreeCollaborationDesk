<?php include("includes/session.php");?>
<!DOCTYPE html>

<html>
<head>
	<title>Help Desk</title>
<?php
include("includes/header.php");
include("fhd_config.php");

if (!isset($_SESSION['auth'])) {
	echo "<p>Authentication Error</p><p><i class='icon-lock'></i></p>";
	include("includes/footer.php");
	exit;
}

//limit login tries.
$_SESSION['hit'] += 1;
if ($_SESSION['hit'] > LOGIN_TRIES){
	echo "<p>Access Locked</p><p><i class='icon-lock'></i></p>";
	include("includes/footer.php");
	exit;
}

if (isset($_POST['user_login'])) {
	$user_login = trim($_POST['user_login']);
	}else{
	$user_login = "";
}

if (isset($_POST['user_password'])) {
	$user_password = trim($_POST['user_password']);
	//$hash = md5($password);
	}else{
	$user_password = "";
}

include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);

//uesrs can login with either login name or email address.
$pos = strrpos($user_login, "@");
if ($pos === false) { // note: three equal signs 
    $checkusing = "user_login";
}else{ 
    $checkusing = "user_email";
}

$user_login = $db->escape($user_login);
$user_password= $db->escape($user_password);
$num = $db->get_var("select count(user_id) from site_users where $checkusing = '$user_login' AND user_password = BINARY '$user_password' AND user_pending = 
0 limit 1;");
//$db->debug();
if ($num <> 1){
	echo "<div class='alert alert-error'>Login incorrect, or your registration is pending.</div>";
	include("includes/footer.php");
	exit;
}

$site_users = $db->get_row("select user_id,user_name,user_level from site_users WHERE $checkusing = '$user_login' and user_password = BINARY '$user_password' limit 1;");

$user_id = $site_users->user_id;
$user_name = $site_users->user_name;
$user_level = $site_users->user_level;

if ($user_level == 0){
	$_SESSION['admin']=1;
}else{
	$_SESSION['user']=1;
}

$_SESSION['user_id']=$user_id;
$_SESSION['user_name']=$user_name;
$_SESSION['user_level']=$user_level;
$_SESSION['hit'] = 0;

include("includes/all-nav.php");

echo "<!-- <p>$user_id</p> -->";
echo "<h2>Welcome, $user_name</h2>";

//record some details about this login
$lastip = $_SERVER['REMOTE_ADDR'];

//$last_login = mktime($dateTime->format("n/j/y g:i a"));
$last_login = date(time());
//echo $dateTime->format("Y-m-d h:i:s");

$db->query("UPDATE site_users SET last_ip = '$lastip',last_login = '$last_login' WHERE user_id = $user_id;");
//$d_last_login = $db->get_var("select last_login from site_users where user_id = $num limit 1;");
?>

<h3><a href="fhd_user_call_add.php" class="btn btn-large btn-primary btn-success">Open Ticket</a></h3>

<h3><a href="fhd_calls.php" class="btn btn-large btn-primary">View Tickets</a></h3>

<?php
include("includes/footer.php");
?>
