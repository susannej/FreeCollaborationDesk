<?php
ob_start();
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksession_ss.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ticket Details</title>
<?php 
include("includes/header.php");
include("includes/all-nav.php");
include('includes/functions.php');
$call_id = checkid($_REQUEST ['call_id']);
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");

$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$isnotes = $db->get_var("SELECT count(*) from site_notes WHERE (note_relation = $call_id) AND note_type = 1;");
//<DELETE>
if ($_GET['action'] == 'delete'){
	if (isset($_GET['nacl'])){
	 if ( $_GET['nacl'] == md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;")) ) {
		//authenticaion verified, continue.
		$call_id = checkid($_GET['call_id']);
		$db->query("UPDATE site_calls SET call_status = 3 WHERE call_id = $call_id limit 1;");
		$db->query("UPDATE site_notes SET note_type = 0 WHERE note_relation = $call_id;");
		header("Location: fhd_calls.php");
		}
	}
}
//</DELETE>

//<UPDATE>
if (isset($_POST['nacl'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;")) ) {
	//authenticaion verified, continue.
	$call_id = checkid($_POST['call_id']);
	$call_status = $db->escape($_POST['call_status']);
	$call_status_now = $db->escape($_POST['call_status_now']);
	$call_date2 = strtotime($_POST['call_date2']);
// if no status change
	if($call_status_now == 0 && $call_status == 0){
		$call_date2 = 0;
		}

	//if changing call status from open to closed
	if($call_status_now == 0 && $call_status == 1){
		$call_date2 = strtotime(date('Y-m-d'));
		$statusquery="call_date2=$call_date2,";
		}
	//if changing from closed to open.
	if($call_status_now == 1 && $call_status == 0){
		$call_date2 = 0;
		}

	$call_date = strtotime($_POST['call_date']);
	$call_first_name = $db->escape($_POST['call_first_name']);
	$call_email = $db->escape($_POST['call_email']);
	$call_phone = $db->escape($_POST['call_phone']);
	$call_department = $db->escape($_POST['call_department']);
	$call_request = $db->escape($_POST['call_request']);
	$call_device = $db->escape($_POST['call_device']);
	$call_details = $db->escape($_POST['call_details']);
	$call_solution = $db->escape($_POST['call_solution']);
	$call_staff = $db->escape($_POST['call_staff']);
	$db->query("UPDATE site_calls SET call_status=$call_status,call_date=$call_date,call_date2=$call_date2,$statusquery call_first_name='$call_first_name',call_email='$call_email',call_phone='$call_phone',call_department=$call_department,call_request=$call_request,call_device=$call_device,call_details='$call_details',call_solution='$call_solution',call_staff=$call_staff WHERE call_id = $call_id;");
        $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    Call Updated.
    </div>";
//$db->debug();
 }
}
//</UPDATE>

$nacl = md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;"));
$site_calls = $db->get_row("SELECT call_id,call_first_name,call_last_name,call_phone,call_email,call_department,call_request,call_device,call_details ,call_date,call_date2,call_status,call_solution,call_phone,call_staff,call_user FROM site_calls WHERE (call_id = $call_id) limit 1;");
?>
<h4>Ticket # <?php echo $call_id;?> &bull; Notes: <a href="#notes"><?php echo $isnotes;?></a></h4>
<?php echo $actionstatus;?>

<form action="fhd_call_edit.php" method="post" class="form-horizontal">
<input type="hidden" name="call_status_now" value="<?php echo $site_calls->call_status; ?>">
<table class="<?php echo $table_style_3;?>">
<?php
	$call_id = $site_calls->call_id;
	$call_user = $site_calls->call_user;
	$call_request = $site_calls->call_request;
	$request_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_request);");
	$call_department = $site_calls->call_department;
	$department_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_department);");
	$call_device = $site_calls->call_device;
	$device_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_device);");
	$call_staff = $site_calls->call_staff;
	$staff_name = $db->get_var("SELECT user_name from site_users WHERE (user_id = $call_staff);");
?>
	<tr><td valign="top">Status</td>
	<td><select name='call_status'>
	<option value='0'<?php if($site_calls->call_status == 0){echo ' selected';}?>>active</option>
	<option value='1'<?php if($site_calls->call_status == 1){echo ' selected';}?>>closed</option>
	<option value='3'<?php if($site_calls->call_status == 3){echo ' selected';}?>>deleted</option>
	</select> <a href="fhd_call_edit.php?call_id=<?php echo $call_id;?>&action=delete&nacl=<?php echo $nacl;?>" onclick="return confirm('Are you sure you want to delete?')"><i class="icon-remove-circle" title-"delete"></i></a>
	</td></tr>
	
	<tr><td>Date</td></td>
	<td>
	<input type="text" name="call_date" value="<?php echo date('Y-m-d',$site_calls->call_date);?>" id="datepicker" class="input-small"></td></tr>	

	<?php if ($site_calls->call_status == 1){ ?>
	<tr><td><strong>Closed</strong></td></td>
	<td><?php echo date('Y-m-d',$site_calls->call_date2);?><input type="hidden" name="call_date2" value="<?php echo date('Y-m-d',$site_calls->call_date2);?>"></td></tr>
	<?php } ?>
	
	<tr><td>Name</td>
	<td><input type="text" name="call_first_name" value="<?php echo $site_calls->call_first_name;?>" class="input-xlarge"> 
	<small><?php echo $call_user;?></small>
	</td></tr>
	
	<tr><td>Email</td>
	<td><input type="text" name="call_email" value="<?php echo $site_calls->call_email;?>" class="input-xlarge"></td></tr>
	
	<tr><td>Phone</td>
	<td><input type="text" name="call_phone" value="<?php echo $site_calls->call_phone;?>" class="input-medium"></td></tr>

	<tr><td>Dept</td><td><select name='call_department'>
	<?php $call_dept = $db->get_results("select type_id,type_name from site_types where type=1");
foreach ($call_dept as $dept )
{?>
	<option value='<?php echo $dept->type_id;?>'<?php if($dept->type_id == $call_department){echo ' selected';}?>><?php echo $dept->type_name;?></option>
<?php } ?>
	</select></td></tr>

	<tr><td>Request</td><td><select name='call_request'>
	<?php $request_name = $db->get_results("select type_id,type_name from site_types where type=2");
foreach ($request_name as $request )
{?>
	<option value='<?php echo $request->type_id;?>'<?php if($request->type_id == $call_request){echo ' selected';}?>><?php echo $request->type_name;?></option>
<?php } ?>
	</select></td></tr>

	<tr><td>Device</td><td><select name='call_device'>
	<?php $device_name = $db->get_results("select type_id,type_name from site_types where type=3");
foreach ($device_name as $device )
{?>
	<option value='<?php echo $device->type_id;?>'<?php if($device->type_id == $call_device){echo ' selected';}?>><?php echo $device->type_name;?></option>
<?php } ?>
	</select></td></tr>
	<tr><td valign="top">Details</td><td><textarea rows="4" name="call_details" class="input-xlarge"><?php echo $site_calls->call_details;?></textarea></td></tr>
	<tr><td valign="top">Solution</td><td><textarea rows="4" name="call_solution" class="input-xlarge"><?php echo $site_calls->call_solution;?></textarea></td></tr>
	<tr><td>Staff</td><td><select name='call_staff'>
	<?php $staff_name = $db->get_results("select user_id,user_name from site_users where user_level<>1 order by user_name;");
foreach ($staff_name as $staff )
{?>
	<option value='<?php echo $staff->user_id;?>'<?php if($staff->user_id == $call_staff){echo ' selected';}?>><?php echo $staff->user_name;?></option>
<?php } ?>
	</select></td></tr>
</table>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type='hidden' name='call_id' value='<?php echo $call_id;?>'>
<input type="submit" value="update" class="btn btn-primary">
</form>
<h4><i class="icon-plus"></i> <a href="fhd_add_note.php?call_id=<?php echo $call_id;?>&action=add&nacl=<?php echo $nacl;?>">Add Note</a></h4>
<?php
//CALL NOTES=======================================================
//i notes is set at the top of this file.
if ($isnotes > 0){
	echo "<a name='notes'></a>\n";
	echo "<table class='$table_style_3'><tr>\n<th>User</th>\n<th>Date</th>\n<th>Contents</th>\n<th colspan='2'>Actions</th>\n</tr>\n";
	$site_notes = $db->get_results("SELECT note_id,note_title,note_body,note_type,note_post_date,note_post_user from site_notes WHERE (note_relation = $call_id) AND note_type = 1 order by note_id desc;");
	foreach ( $site_notes as $note )
	{
		$note_post_user = $note->note_post_user;
		$user_level = $db->get_var("select user_level from site_users where user_id = $note_post_user;");
		$bg = ($user_level == 1) ? " style='background-color:#FFFF55;'" : "";
		$note_id = $note->note_id;
		$note_post_date = date("n/j/y g:i a",($note->note_post_date + (FHD_TIMEADJUST * 3600)));
		$note_title = $note->note_title;
		$note_body = $note->note_body;
		$note_post_user = $note->note_post_user;
		$note_post_name = $db->get_var("select user_name from site_users where user_id = $note_post_user;");
		echo "<tr>\n";
		echo "<td valign='top'".$bg.">$note_post_name</td>\n";
		echo "<td valign='top'>$note_post_date</td>\n";
		echo "<td valign='top' style='width: 400px;'>$note_body</td>\n";
		echo "<td align='center'><a href='fhd_add_note.php?note_id=$note_id&action=edit&call_id=$call_id&nacl=$nacl'><i class=' icon-edit'></i></a></td>\n";
		echo "<td align='center'><a href='fhd_note_actions.php?note_id=$note_id&call_id=$call_id&action=delete&nacl=$nacl' $confirm><i class=' icon-remove-circle' title='delete'></i></a></td>\n";
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