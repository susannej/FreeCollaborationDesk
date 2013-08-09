<?php
include("includes/session.php");
include("includes/checksession.php");
?>

<!DOCTYPE html>

<html>
<head>
	<title>Ticket Details</title>
<?php 
include("includes/header.php");
include("includes/all-nav.php");
include('includes/functions.php');
$call_id = checkid($_GET['call_id']);
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");

$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$nacl = md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;"));
$site_calls = $db->get_row("SELECT call_id,call_first_name,call_last_name,call_phone,call_email,call_department,call_request,call_device,call_details ,call_date,call_date2,call_status,call_solution,call_user,call_staff FROM site_calls WHERE (call_id = $call_id) limit 1;");
?>
<h4><i class='icon-tag'></i> Ticket Details [ #<?php echo $call_id;?> ]</h4>

<?php if($user_level <> 1){ ?>
<p><i class="icon-edit"></i> <a href="fhd_call_edit.php?call_id=<?php echo $call_id;?>">Edit Ticket</a></p>
<?php } ?>
<table class="<?php echo $table_style_2;?>">
<?php
	$call_id = $site_calls->call_id;
	$call_status = $site_calls->call_status;
	$call_request = $site_calls->call_request;
	$request_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_request);");
	$call_department = $site_calls->call_department;
	$department_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_department);");
	$call_device = $site_calls->call_device;
	$device_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_device);");
	$call_staff = $site_calls->call_staff;
	$staff_name = $db->get_var("SELECT user_name from site_users WHERE (user_id = $call_staff);");
	echo "<tr><td>Status</td><td>" . call_status($site_calls->call_status) . "</td></tr>\n";
	echo "<tr><td>Date</td><td>" . date('Y-m-d',$site_calls->call_date) . "</td></tr>\n";
	if ($call_status ==1){
		echo "<tr><td>Closed</td><td>" . date('Y-m-d',$site_calls->call_date2) . "</td></tr>\n";
	}
	echo "<tr><td>Name</td><td>" . $site_calls->call_first_name . "</td></tr>\n";
//	echo "<tr><td>Last Name</td><td>".$site_calls->call_last_name."</td></tr>\n";
	echo "<tr><td>Email</td><td>".$site_calls->call_email."</td></tr>\n";
	echo "<tr><td>Dept</td><td>$department_name</td></tr>\n";
	echo "<tr><td>Request</td><td>$request_name</td></tr>\n";	
	echo "<tr><td>Device</td><td>$device_name</td></tr>\n";
	echo "<tr><td>Details</td><td style='width: 500px;'>".$site_calls->call_details."</td></tr>\n";
	echo "<tr><td>Solution</td><td style='width: 500px;'>".$site_calls->call_solution."</td></tr>\n";
	echo "<tr><td>Staff</td><td>$staff_name</td></tr>\n";
?>
</table>

<h5><i class="icon-plus"></i> <a href="fhd_add_note.php?call_id=<?php echo $call_id;?>&action=add&nacl=<?php echo $nacl;?>">Add Note</a></h5>

<?php 
$isnotes = $db->get_var("SELECT count(*) from site_notes WHERE (note_relation = $call_id) and note_type = 1;");
if ($isnotes > 0){
	echo "<table class='$table_style_2'>";
	echo "<tr><th>User</th><th>contents</th><th>Date</th></tr>";
	$site_notes = $db->get_results("SELECT note_id,note_title,note_body,note_type,note_post_date,note_post_user from site_notes WHERE (note_relation = $call_id) AND note_type = 1 order by note_id desc;");
	
	foreach ( $site_notes as $note )
	{
		$note_post_user = $note->note_post_user;
		$note_post_name = $db->get_var("select user_name from site_users where user_id = $note_post_user;");
		$user_level_note = $db->get_var("select user_level from site_users where user_id = $note_post_user;");
		$bg = ($user_level_note == 1) ? " class='usernote'" : "";
		$site_notes = $note->note_id;
//		$note_post_date = date("n/j/y g:i a",$note->note_post_date);
		$note_post_date = date("n/j/y g:i a",($note->note_post_date + (FHD_TIMEADJUST * 3600)));		
		$note_title = $note->note_title;
		$note_body = $note->note_body;
		echo "<tr>\n";
		echo "<td valign='top' style='width: 100px;'".$bg.">$note_post_name</td>\n";
		echo "<td valign='top' style='width: 400px;'".$bg.">$note_body</td>\n";
		echo "<td valign='top'".$bg.">$note_post_date</td>\n";
		echo "</tr>\n";
		}
	echo "</table>";
}
?>

<?php
if(isset($_SESSION['name'])){
//the session variable is registered, the user is allowed to see anything that follows
echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>	