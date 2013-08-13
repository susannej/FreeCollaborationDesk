<?php
include("includes/session.php");
include ("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>

<html>
<head>
	<title>Add User Details</title>
<?php 
include("includes/header.php");
include("includes/all-nav.php");
//include("includes/admin-nav.php");
include('includes/functions.php');
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");

$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
//<ADD>
if (isset($_POST['nacl'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;")) ) {
	//authenticaion verified, continue.
	$user_login = $db->escape($_POST['user_login']);
	$user_email = $db->escape($_POST['user_email']);
		//check email exists
		$num = $db->get_var("select count(user_email) from site_users where (user_email = '$user_email');");
		if ($num > 0) {
		echo "<div class='alert alert-error'><strong>Error:</strong> that email address is already in use.</div>";
		include("includes/footer.php");
		exit;
		}
	$user_password = $db->escape($_POST['user_password']);
	$user_name = $db->escape($_POST['user_name']);
	$user_phone = $db->escape($_POST['user_phone']);	
	$user_address = $db->escape($_POST['user_address']);
	$user_city = $db->escape($_POST['user_city']);
	$user_state = $db->escape($_POST['user_state']);
	$user_zip = $db->escape($_POST['user_zip']);
	$user_country = $db->escape($_POST['user_country']);
	$db->query("INSERT INTO site_users(user_login,user_email,user_password,user_name,user_phone,user_address,user_city,user_state,user_zip,user_country,user_level,user_status)VALUES('$user_login','$user_email','$user_password','$user_name','$user_phone','$user_address','$user_city','$user_state','$user_zip','$user_country',1,1)");
//$db->debug();
        $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    User Added.
    </div>";
 }
}
//</ADD>

$nacl = md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;"));
?>

<h4>Add User</h4>
<?php echo $actionstatus;?>

<form action="fhd_admin_register.php" method="post" class="form-horizontal">
<table class="<?php echo $table_style_2;?>">
	<tr><td>User Login </td>
	<td><input type="text" name="user_login" required> *</td></tr>

	<tr><td>Email</td>
	<td><input type="text" name="user_email" required> *</td></tr>		
	
	<tr><td>Password</td>
	<td><input type="text" name="user_password" required> *</td></tr>		

	<tr><td>Name</td>
	<td><input type="text" name="user_name" required> *</td></tr>

	<tr><td>Phone</td>
	<td><input type="text" name="user_phone" size="15"></td></tr>
	
	<tr><td>Address</td>
	<td><input type="text" name="user_address" size="25"></td></tr>
	
	<tr><td>City</td>
	<td><input type="text" name="user_city" size="25"></td></tr>

	<tr><td>State</td>
	<td><input type="text" name="user_state" size="15"></td></tr>

	<tr><td>Zip</td>
	<td><input type="text" name="user_zip" size="15"></td></tr>

	<tr><td>Country</td>
	<td><input type="text" name="user_country" size="25"></td></tr>

</table>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type="submit" value="Add User" class="btn btn-primary">
</form>

<h5><i class="icon-arrow-left"></i> <a href="fhd_users.php">Back to user list</a></h5>

<?php
if(isset($_SESSION['name'])){
//the session variable is registered, the user is allowed to see anything that follows
echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>	