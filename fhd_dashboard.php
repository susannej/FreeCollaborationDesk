<?php
include("includes/session.php");
include("includes/checksession.php");
?>
<!DOCTYPE html>

<html>
<head>
	<title>Help Desk</title>
<?php include("includes/header.php");?>	
<?php include("includes/all-nav.php");?>

<h3><i class="icon-wrench"></i> Help Desk Dashboard</h3>

<?php
include("fhd_config.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include ("includes/functions.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
//only show tickets for the user if not admin.
switch ($user_level) {
    case 0:
        $queryadd = "";
        break;
    case 1:
       	$queryadd = " AND call_user = $user_id";
		break;
    case 2:
        $addpage = "";
		break;
	}
$opentickets = $db->get_var("select count(call_id) from site_calls where call_status = 0 $queryadd;");
//$db->debug();
?>

<h4><i class="icon-user"></i> User Name: <?php echo $user_name;?></h4>

<table class="<?php echo $table_style_1;?>" style="max-width: 250px;">
<tr>
	<td>Open Tickets</td><td style='text-align: right;'><a href="fhd_calls.php"><?php echo $opentickets; ?></a></td>
</tr>
<tr>
	<td>Total Tickets</td><td style='text-align: right;'><?php echo $db->get_var("select count(call_id) from site_calls where call_status < 2  $queryadd;")?></td>
</tr>
<?php if(isset($_SESSION['admin'])){ ?>
<tr>
	<td>Pending Users</td><td style='text-align: right;'><a href="fhd_users.php?pending=1"><?php echo $db->get_var("select count(user_id) from site_users where user_pending = 1;")?></a></td>
</tr>
<tr>
	<td>Users</td><td style='text-align: right;'><a href="fhd_users.php"><?php echo $db->get_var("select count(user_id) from site_users;")?></a></td>
</tr>
<tr>
	<td>Notes</td><td style='text-align: right;'><?php echo $db->get_var("select count(note_id) from site_notes;")?></td>
</tr>

<?php } ?>
</table>


<?php
if(isset($_SESSION['name'])){
//the session variable is registered, the user is allowed to see anything that follows
echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>	
