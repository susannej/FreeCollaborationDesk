<?php
ob_start();
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>

<html>
<head>
	<title>Edit User Details</title>
<?php 
include("includes/header.php");
include("includes/all-nav.php");
//include("includes/admin-nav.php");
include('includes/functions.php');
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");

$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
//<UPDATE>
if (isset($_POST['update'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;")) ) {
	//authenticaion verified, continue.
	$url_user_id = $db->escape($_POST['url_user_id']);
	$user_date = date(time());
	$user_name = $db->escape($_POST['user_name']);
	$user_password = $db->escape($_POST['user_password']);
	$user_email = $db->escape($_POST['user_email']);
	$user_phone = $db->escape($_POST['user_phone']);
	$user_address = $db->escape($_POST['user_address']);
	$user_city = $db->escape($_POST['user_city']);
	$user_state = $db->escape($_POST['user_state']);
	$user_zip = $db->escape($_POST['user_zip']);
	$user_country = $db->escape($_POST['user_country']);
	$user_level = $db->escape($_POST['user_level']);	
	$user_protect_edit = 0;
	$user_protect_edit_value = $db->escape($_POST['user_protect_edit']);
	if($user_protect_edit_value == 1){$user_protect_edit = 1;};

	$user_msg_send = 0;
	$user_msg_send_value = $db->escape($_POST['user_msg_send']);
	if($user_msg_send_value == 1){$user_msg_send = 1;};

	$user_pending = 1;
	$user_pending_value = $db->escape($_POST['user_pending']);
	if($user_pending_value == 0){$user_pending = 0;};

	$db->query("UPDATE site_users SET user_password='$user_password',user_email='$user_email',user_name='$user_name',user_phone='$user_phone',user_address='$user_address',user_city='$user_city',user_state='$user_state',user_zip='$user_zip',user_country='$user_country',user_level=$user_level,user_msg_send=$user_msg_send,user_protect_edit=$user_protect_edit,user_pending=$user_pending where user_id = $url_user_id;");
    $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    User Update Successful.
    </div>";
	//$db->debug();
 }
}
//</UPDATE>

if (isset($_REQUEST['url_user_id'])){
	$url_user_id = checkid($_REQUEST['url_user_id']);
	$site_users = $db->get_row("SELECT user_login,user_password,user_name,user_address,user_city,user_state,user_zip,user_country,user_phone,user_email,user_msg_send,user_protect_edit,user_pending,user_level FROM site_users WHERE (user_id = $url_user_id) limit 1;");
	$user_msg_send = $site_users->user_msg_send;
	$user_protect_edit = $site_users->user_protect_edit;
	$user_pending = $site_users->user_pending;
}
$nacl = md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;"));
echo $actionstatus;?>

<h4>Edit User: <?php echo $site_users->user_name;?></h4>

<form action="fhd_edit_user.php" method="post" class="form-horizontal">
<table class="<?php echo $table_style_2;?>">
	<tr><td>User Login </td>
	<td><input type="text" name="user_name" value="<?php echo $site_users->user_login;?>"</td></td></tr>
	
	<tr><td>Password</td>
	<td><input type="text" name="user_password" value="<?php echo $site_users->user_password;?>"></td></tr>

	<tr><td>User Level</td>
	<td><select name="user_level">
	<option value="1" <?php if ($site_users->user_level == 1) echo "selected";?>><?php echo show_user_level(1);?></option>
	<option value="2" <?php if ($site_users->user_level == 2) echo "selected";?>><?php echo show_user_level(2);?></option>
	<option value="0" <?php if ($site_users->user_level == 0) echo "selected";?>><?php echo show_user_level(0);?></option>
	</select></td></tr>
	
	<tr><td>Name</td>
	<td><input type="text" name="user_name" value="<?php echo $site_users->user_name;?>"></td></tr>
	
	<tr><td>Email</td>
	<td><input type="text" name="user_email" value="<?php echo $site_users->user_email;?>" size="25"></td></tr>
	
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
	<td><?php echo $url_user_id;?></td></tr>

	<tr><td colspan="2"><input type="checkbox" name="user_pending" value="1" <?php if($user_pending == 1){echo " CHECKED";}?>> User pending?</td></tr>

	<tr><td colspan="2"><input type="checkbox" name="user_msg_send" value="1" <?php if($user_msg_send == 1){echo " CHECKED";}?>> Receive ticket status emails?</td></tr>
	
	<tr><td colspan="2"><input type="checkbox" name="user_protect_edit" value="1" <?php if($user_protect_edit == 1){echo " CHECKED";}?>> Lock from user edit?</td></tr>
</table>
<input type='hidden' name='url_user_id' value='<?php echo $url_user_id;?>'>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type='hidden' name='update' value='1'>
<input type="submit" value="update" class="btn btn-primary">
</form>

<h5><i class="icon-arrow-left"></i> <a href="fhd_users.php">Back to user list</a></h5>

<?php
if(isset($_SESSION['name'])){
//the session variable is registered, the user is allowed to see anything that follows
echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>	