<?php include("includes/session.php");?>
<!DOCTYPE html>

<html>
<head>
	<title>Help Desk</title>
<?php
$_SESSION['auth'] = md5(uniqid(microtime()));
include("includes/header.php");

//check for fhd_config
$filename = 'fhd_config.php';
if (!file_exists($filename)) {
    echo "<div class=\"alert alert-error\" style=\"max-width: 350px; text-align: center;\"><strong>Notice:</strong> Software Configuration Needed</div>";
    echo "<p>Please check the <strong>fhd_config.php</strong> file.</p>";
    echo "<p>If this is a new install, you can <strong>rename fhd_config_sample.php to fhd_config.php</strong></p>";
    echo "<p>Open fhd_config.php in a text editor and <strong>configure your settings</strong>.</p>";
    echo "<p>For more information, please check the <a href='readme.htm' target='_blank'>readme file</a>.</p>";
	include("includes/footer.php");
	exit;
}

include("fhd_config.php");
if(isset($_SESSION['user_id'])){
//the session variable is registered, the user is allowed to see anything that follows
$name = $_SESSION['name'];
$user_id = $_SESSION['user_id'];
include("includes/all-nav.php");
echo ("<p>Welcome $name</p>");
echo ("<p><a href='fhd_dashboard.php'>Help Desk Dashboard</a></p>");
}else{
?>	

<h2><?php echo FHD_TITLE;?> Help Desk</h2>

<?php
if ( isset ($_GET['loggedout']) ) {
echo "<div class=\"alert alert-success\" style=\"max-width: 350px; text-align: center;\"><strong>Logged Out</strong><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
}
?>

<form action="fhd_login.php" method="post" class="form-horizontal">

<div class="control-group">
<label class="control-label" for="inputEmail">Email</label>
<div class="controls">
<input type="text" id="inputEmail" name="user_login" placeholder="Email/Username" required>
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputPassword">Password</label>
<div class="controls">
<input type="password" id="inputPassword" name="user_password" placeholder="Password" required>
</div>
</div>
<div class="control-group">
<div class="controls">
<button type="submit" class="btn btn-primary">Sign in</button>
</div>
</div>
</form>

<p><?php if (ALLOW_REGISTER == "yes"){?>
<a href="fhd_register.php">register</a> &bull; 
<?php } ?><a href="fhd_forgotpassword.php">forgot password</a></p>
<?php }?>

<?php include("includes/footer.php");?>	
