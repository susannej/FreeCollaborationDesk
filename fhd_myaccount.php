<?php
include("includes/session.php");
include ("includes/checksession.php");
?>
<!DOCTYPE html>

<html>
<head>
	<title>Help Desk - My Account</title>
<?php 
include("includes/header.php");
include("includes/all-nav.php");
include('includes/functions.php');
$user_id = checkid($user_id);
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
//check that user exists before continuing.
$isuser = $db->get_var("SELECT count(*) from site_users WHERE (user_id = $user_id);");
if ($isuser == 0) {
	echo "<p>Error</p>";
	echo exit;
}
//check if user is locked out from changes
$user_protect_edit = $db->get_var("select user_protect_edit from site_users where user_id = $user_id;");
if ($user_protect_edit == 1){
	echo "<p>Account Changes Locked</p>";
	include("includes/footer.php");
	exit;
}

//<UPDATE>
if (isset($_POST['update'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;")) ) {
	//authenticaion verified, continue.
	$user_email = $db->escape($_POST['user_email']);
		//check email exists
		$num = $db->get_var("select count(user_email) from site_users where (user_email = '$user_email') and (user_id <> $user_id);");
		if ($num > 0) {
		echo "<p><a href='fhd_myaccount.php'>Error: that email address is already in  use.</a></p>";
		include("includes/footer.php");
		exit;
		}

	$user_name = $db->escape($_POST['user_name']);

	$user_password = $db->escape($_POST['user_password']);
		//check password length
		if(strlen($user_password) < 5){
		echo "<div class=\"alert alert-error\" style=\"max-width: 350px;\"><a href='fhd_myaccount.php'>Password must be at least 5 characters</a>.</div>";
		include("includes/footer.php");
		exit;
		}

	$user_date = date(time());
	$user_phone = $db->escape($_POST['user_phone']);
	$user_address = $db->escape($_POST['user_address']);
	$user_city = $db->escape($_POST['user_city']);
	$user_state = $db->escape($_POST['user_state']);
	$user_zip = $db->escape($_POST['user_zip']);
	$user_country = $db->escape($_POST['user_country']);
	$user_msg_send = 0;
	$user_msg_send_value = $db->escape($_POST['user_msg_send']);
	if($user_msg_send_value == 1){$user_msg_send = 1;};

	$db->query("UPDATE site_users SET user_password='$user_password',user_email='$user_email',user_name='$user_name',user_phone='$user_phone',user_address='$user_address',user_city='$user_city',user_state='$user_state',user_zip='$user_zip',user_country='$user_country',user_msg_send=$user_msg_send where user_id = $user_id;");
        $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>Updated.</div>";
 }
}
//</UPDATE>

$nacl = md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;"));
$site_users = $db->get_row("SELECT user_login,user_password,user_name,user_address,user_city,user_state,user_zip,user_country,user_phone,user_email,user_msg_send,user_level FROM site_users WHERE (user_id = $user_id) limit 1;");
$user_msg_send = $site_users->user_msg_send;
?>

<?php echo $actionstatus;?>
<h4><i class="icon-user"></i> My Account</h4>
<form action="fhd_myaccount.php" method="post" class="form-horizontal">
<table class="<?php echo $table_style_2;?>">
<tbody>
	<tr><td>User Login </td>
	<td><?php echo $site_users->user_login;?></td></tr>
	
	<tr><td>Password</td>
	<td><input type="text" name="user_password" value="<?php echo $site_users->user_password;?>"></td></tr>

	<tr><td>Name</td>
	<td><input type="text" name="user_name" value="<?php echo $site_users->user_name;?>"></td></tr>
	
	<tr><td>Email</td>
	<td><input type="text" name="user_email" value="<?php echo $site_users->user_email;?>" size="25"></td></tr>
	
	<tr><td colspan="2">
	Receive ticket status emails? <input type="checkbox" name="user_msg_send" value="1" <?php if($user_msg_send == 1){echo " CHECKED";}?>>
	</td></tr>
	
	<tr><td>Phone</td>
	<td><input type="text" name="user_phone" value="<?php echo $site_users->user_phone;?>" size="20"></td></tr>

	<tr><td>Address</td>
	<td><input type="text" name="user_address" value="<?php echo $site_users->user_address;?>" size="20"></td></tr>

	<tr><td>City</td>
	<td><input type="text" name="user_city" value="<?php echo $site_users->user_city;?>" size="20"></td></tr>

	<tr><td>State</td>
	<td><input type="text" name="user_state" value="<?php echo $site_users->user_state;?>" size="20"></td></tr>

	<tr><td>Zip</td>
	<td><input type="text" name="user_zip" value="<?php echo $site_users->user_zip;?>" size="20"></td></tr>

	<tr><td>Country</td>
	<td><input type="text" name="user_country" value="<?php echo $site_users->user_country;?>" size="20"></td></tr>

	<tr><td>ID </td>
	<td><?php echo $user_id;?></td></tr>

	<td>Level</td>
	<td><em><?php echo show_user_level($site_users->user_level);?></em></td></tr>
	
</table>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type='hidden' name='update' value='1'>
<input type="submit" value="update" class="btn btn-primary">
</form>

<?php
if(isset($_SESSION['name'])){
//the session variable is registered, the user is allowed to see anything that follows
echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>	