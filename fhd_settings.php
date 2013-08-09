<?php
include("includes/session.php");
include ("includes/checksession.php");
include("includes/checksessionadmin.php");
?>

<!DOCTYPE html>

<html>
<head>
	<title>Help Desk Settings</title>
<?php
include("includes/header.php");
include("includes/all-nav.php");
include("includes/admin-nav.php");
?>

<h4>Help Desk Settings</h4>

<div class="well" style="max-width: 240px; padding: 8px 0;">

<ul class="nav nav-list">
<li class="nav-header">Settings</li>
<li><a href="fhd_settings_action.php?type=1">Departments</a></li>
<li><a href="fhd_settings_action.php?type=2">Request Types</a></li>
<li><a href="fhd_settings_action.php?type=3">Device Type</a></li>
<li><a href="fhd_users.php?support_staff=show">Support Staff</a></li>
<!-- 	<li class="lipad"><a href="fhd_settings_action.php?type=0">Support Staff</a></li> -->
</ul>

</div>

<?php include("includes/footer.php");?>	
