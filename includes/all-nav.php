<?php $page = basename($_SERVER['REQUEST_URI']);?>
<?php// echo $_SESSION['user_level'];?>

<div class="navbar navbar-inverse">
<div class="navbar-inner">
<!-- ul class="nav nav-tabs" -->
<ul class="nav">
	<li<?php if($page == 'fhd_dashboard.php'){echo ' class="active"';};?>><a href="fhd_dashboard.php">Dashboard</a></li>
	<li<?php if($page == 'fhd_calls.php'){echo ' class="active"';};?>><a href="fhd_calls.php">Open Tickets</a></li>
	<li<?php if($page == 'fhd_search.php'){echo ' class="active"';};?>><a href="fhd_search.php">Search</a></li>
	<!-- li<?php if($page == 'fhd_myaccount.php'){echo ' class="active"';};?>><a href="fhd_myaccount.php">My Account</a></li -->

<?php
if(isset($_SESSION['admin'])){
?>
	<li class="divider-vertical"></li>

	<li<?php if($page == 'fhd_settings.php'){echo ' class="active"';};?>><a href="fhd_settings.php">Settings</a></li>
<?php
	}
?>

	<li class="divider-vertical"></li>
	
	<li<?php if($page == 'fhd_myaccount.php'){echo ' class="active"';};?>><a href="fhd_myaccount.php"><i class="icon-user icon-white"></i> <?php echo $user_name;?></a></li>
	<li><a href="includes/session.php?logout=y">Logout</a></li>

</ul>

<ul class="nav pull-right">
	
	<li><form class="navbar-search pull-right" action="fhd_search.php" method="get">
    <input type="text" name="call_details" class="search-query" placeholder="Quicksearch">
	<input type="hidden" name="search" value="1">
    </form></li>

</ul>

</div>
</div>