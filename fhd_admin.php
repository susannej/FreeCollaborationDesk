<?php
include("includes/session.php");
include ("includes/checksession.php");
include ("includes/checksessionadmin.php");
?>
<!DOCTYPE html>

<html>
<head>
	<title>Administration Dashboard</title>
<?php include("includes/header.php");?>	
<?php include("includes/all-nav.php");?>

<h4>Administration Dashboard</h4>

<?php include("includes/admin-nav.php");?>

<?php
if(isset($_SESSION['name'])){
//the session variable is registered, the user is allowed to see anything that follows
echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>	
