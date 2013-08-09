<?php
include("includes/session.php");
include("includes/checksession.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Users</title>
<?php
include("includes/header.php");
include("includes/all-nav.php");
include("includes/admin-nav.php");
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
?>

<?php
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);

if (isset($_GET['pending'])){
	$pending = "AND user_pending = 1";
}

if (isset($_GET['support_staff'])){
	$pending = "AND user_level = 2";
}

$myquery = "SELECT user_id,user_name,user_email,user_phone,user_pending,user_level from site_users where 1 $pending order by user_level,user_id desc;";
$site_calls = $db->get_results($myquery);
$num = $db->num_rows;
//$db->debug();
echo "<h4>$num Users</h4>";
if ($num > 0){
?>
<table class="<?php echo $table_style_2;?>">
<tr>
	<th>ID</th>
	<th>Open</th>
	<th>Name</th>
	<th>Email</th>
	<th>Phone</th>
	<th>Level</th>
</tr>
<?php
foreach ( $site_calls as $call )
{
	$user_id = $call->user_id;
	$user_name = $call->user_name;
	$user_email  = $call->user_email;
	$user_phone  = $call->user_phone;
	$user_pending = $call->user_pending;
	$user_level = $call->user_level;
	$bg = ($user_pending == 1) ? " class='usernote'" : "";
	$call_count = $db->get_var("SELECT count(call_id) from site_calls WHERE (call_user = $user_id) AND (call_status = 0);");
	echo "<tr>\n";
	echo "<td".$bg."><a href='fhd_edit_user.php?url_user_id=$user_id'>$user_id</a></td>\n";
	echo "<td align='center'><a href='fhd_calls.php?user_id=$user_id'>$call_count</a></td>\n";
	echo "<td>$user_name</td>\n";
	echo "<td>$user_email</td>\n";
	echo "<td>$user_phone</td>\n";
	echo "<td>" . show_user_level($user_level). "</td>\n";	
	echo "</tr>\n";
	}
}
?>
</table>

<?php
if(isset($_SESSION['user_name'])){
//the session variable is registered, the user is allowed to see anything that follows
echo "<h5>Current User: " . $_SESSION['user_name'] . "</h5>";
}
include("includes/footer.php");
?>	