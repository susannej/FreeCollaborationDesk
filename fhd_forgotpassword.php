<?php error_reporting(E_ALL & ~E_NOTICE); ?>
<!DOCTYPE html>

<html>
<head>
	<title>Forgot Password</title>
<?php
include("includes/header.php");
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$thedomain = $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//initilize db
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);

//if STEP 2 of the process
if (isset($_GET['action'])) {
	$action = $_GET['action'];
	$key = $_GET['key'];
	//check if action is to reset password and that the key is not blank.
	if ($action == "rp") {
		if (!empty($key)){
		$myquery = "SELECT user_id,user_email FROM site_users WHERE user_im_other = '$key' limit 1;";
		$resets = $db->get_row($myquery);
		// if a record is returned then continue
		if ($db->num_rows == 1){
			$user_email = $resets->user_email;
			$user_id = $resets->user_id;
			//generage a new password, set resetcode to blank so link cannot be used again.
			$user_password = generatePassword(8,9);
			//update the password in the database.
			$db->query("UPDATE site_users set user_password = '$user_password',user_im_other = '' WHERE user_id = $user_id limit 1;");

			//send out the message
			$from = FROM_EMAIL;
			$to    = $user_email;
			$subject = 'Your new password';
			// message
			$message = '
			<html>
			<body>
			  <p>HelpDesk New Password</p>
			  <p>Email: ' . $user_email . '</p>
			  <p>Password: ' .  $user_password. '</p>
			</body>
			</html>
			';
			$headers = "From:" . $from . "\r\n";
			$headers .="Reply-To: " .$from . "\r\n";
			$headers .="X-Mailer: PHP/" . phpversion() ."\r\n";
			$headers .="MIME-Version: 1.0" . "\r\n";
			$headers .="Content-type: text/html; charset=iso-8859-1" . "\r\n";
			mail($to, $subject, $message, $headers);
			$message = "Check your email for your new password.";
			//if key is wrong, then no records will be found, give this error.
			} else {
			$message = "Error, invalid password reset key";
			}
		}else {
		$message = "Error, password reset key is blank.";
		}
		} else {
		$message = "Error";
		}
$finish = 1;
}

//STEP 1 of the process
// is ?try=true 
if (isset($_POST['try'])) {
    // clicked on the submit button
   if(empty($_POST['user_email'])) {
    // At least one of the file is empty, display an error
    echo '<p style="color: red;">email address is required</p>';
} else {
    // User has filled it all in.
	//run the password reset.
	$user_email = $_POST['user_email'];
	$finish = 1;

	//check to make sure the email addreess is in the database
	$myquery = "select count(user_id) from site_users where user_email = '$user_email' AND user_pending = 0 limit 1;";
	$count = $db->get_var($myquery);
	//$db->debug();

	//if the email is valid then continue
	if ($count == 1){
		//insert a random code into the database for the user
		$resetpasswordcode = generatePassword(9,4);
		//$resetdate = date("Y-m-d H:i:s");
		$query = "UPDATE site_users set user_im_other = '$resetpasswordcode' WHERE user_email = '$user_email' limit 1;";
		$db->query($query);

		//send out the message
		$from = FROM_EMAIL;
		$to      = $user_email;
		$subject = 'HelpDesk Confirmation';
		// message
		$message = '
		<html>
		<body>
		  <p>Here is the HelpDesk reset code as requested.</p>
		  <p>To reset your password visit the following address, otherwise just ignore this email and nothing will happen.</p>
		  <p><a href="http://' . $thedomain . '?action=rp&key='. $resetpasswordcode . '">http://' . $thedomain . '?action=rp&key='. $resetpasswordcode . '</a>
		</body>
		</html>
		';
		$headers = "From:" . $from . "\r\n";
		$headers .="Reply-To: " .$from . "\r\n";
		$headers .='X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to, $subject, $message, $headers);
		$message = "Check your e-mail for the confirmation link. (be sure to check your spam folders also)";
	} else {
		$message = "Error, email address not found, or your registration is still pending.";
	}
}
}
?>

<h2>Forgot Password</h2>

<?php if ($finish == 1) { ?>

<p class="margin"><?php echo $message;?></p>

<?php }else{ ?>
<p>enter your email address</p>
<form action="fhd_forgotpassword.php" method="post">
<table>
<tr>
	<td>email:</td>
	<td><input type="text" name="user_email" size="50" maxlength="100"></td>
</tr>
<?php
if (CAPTCHA_RESET_PASSWORD == "yes"){
	include("includes/captcha.php");
	$_SESSION['captcha'] = captcha();
    $captchaimg = '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />';
?>
<tr>
	<td><?php echo $captchaimg; ?></td>
	<td>Enter Code<br><input type="text" name="captcha"></td>
</tr>
<?php } ?>
</table>
<input type="hidden" name="try" value="true">
<p><input type="submit" value="enter" class="btn"></p>
</form>
<p><a href="index.php">back to login page</a> | <a href="fhd_forgotpassword.php">reload page</a></p>
<?php } ?>

<?php include("includes/footer.php");?>
