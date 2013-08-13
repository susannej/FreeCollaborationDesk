<?php
include("includes/session.php");
include("includes/checksession.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Open Tickets</title>
<?php
include("includes/header.php");
include("includes/all-nav.php");
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$colspan = 2;
if($user_level == 1){
	$queryadd = " AND call_user = $user_id";
	$colspan = 1;
}
if(isset($_GET['user_id'])){
	$queryadd = " AND call_user = ".$_GET['user_id'];
	$colspan = 2;
}
?>

<?php
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$myquery = "SELECT call_id,call_date,call_first_name,call_last_name,call_request,call_department,call_device from site_calls WHERE (call_status = 0) $queryadd order by call_id desc;";
$site_calls = $db->get_results($myquery);
$num = $db->num_rows;
//$db->debug();
echo "<h4><i class='icon-tags'></i> Open Tickets [ $num ]</h4>";

$addpage = ($user_level == 1) ? "fhd_user_call_add.php" : "fhd_call_add.php";
echo "<h5><i class='icon-plus'></i> <a href='$addpage'>Add New</a></h5>";

if ($num > 0){
?>
<table class="<?php echo $table_style_1;?>">
<tr>
	<th colspan="<?php echo $colspan;?>" style='text-align: center;'>Action</th>
	<?php if($user_level <> 1){?>
	<th>Name</th>
	<?php } ?>
	<th>Notes</th>
	<th>Date</td>
	<th>Type</th>
	<th>Dept</th>
	<th>Device</th>
</tr>
<?php
foreach ( $site_calls as $call )
{
	$call_id = $call->call_id;
//	$call_date = date("n/j/y g:i a",$call->call_date);
	$call_date = date("m/d/y",$call->call_date);
	$call_first_name  = $call->call_first_name;
	$call_last_name  = $call->call_last_name;
	$call_request = $call->call_request;
	$call_department = $call->call_department;
	$call_device = $call->call_device;
	$request_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_request);");
	$department_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_department);");
	$device_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_device);");
	$note_count = $db->get_var("SELECT count(note_id) from site_notes WHERE (note_relation = $call_id) and (note_type = 1);");
	echo "<tr>\n<td style='text-align: center;'><a href='fhd_call_details.php?call_id=$call_id'><i class='icon-eye-open'></i></a></td>\n";

	if($user_level <> 1){
	echo "<td style='text-align: center;'><a href='fhd_call_edit.php?call_id=$call_id'><i class='icon-edit' title='edit'></i></a><td>$call_first_name</td>\n</td>\n";
	}

	echo "<td>$note_count</td>\n<td>$call_date</td>\n";
	echo "<td>$request_name</td>\n<td>$department_name</td>\n<td>$device_name</td>\n</tr>\n";
}
}
?>
</table>

<?php
if(isset($_SESSION['user_name'])){
//the session variable is registered, the user is allowed to see anything that follows
// echo "<h5><strong>Name:</strong> " . $_SESSION['user_name'] . "</h5>";
}
include("includes/footer.php");
?>	