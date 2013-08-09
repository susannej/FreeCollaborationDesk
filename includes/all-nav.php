<?php $page = basename($_SERVER['REQUEST_URI']);?>
<?php// echo $_SESSION['user_level'];?>

<ul class="nav nav-tabs">
	<li<?php if($page == 'fhd_dashboard.php'){echo ' class="active"';};?>><a href="fhd_dashboard.php">Dashboard</a></li>
	<li<?php if($page == 'fhd_calls.php'){echo ' class="active"';};?>><a href="fhd_calls.php">Open Tickets</a></li>

<?php
switch ($_SESSION['user_level']) {
    case 0:
        $addpage = "fhd_call_add.php";
        break;
    case 1:
        $addpage = "fhd_user_call_add.php";
		break;
    case 2:
        $addpage = "fhd_call_add.php";
		break;
}
$addpage = ($_SESSION['user_level'] == 1) ? "fhd_user_call_add.php" : "fhd_call_add.php"; ?>
	<li<?php if($page == $addpage){echo ' class="active"';};?>><a href="<?php echo $addpage;?>">Add  Ticket</a></li>

	<li<?php if($page == 'fhd_search.php'){echo ' class="active"';};?>><a href="fhd_search.php">Search</a></li>
	<li<?php if($page == 'fhd_myaccount.php'){echo ' class="active"';};?>><a href="fhd_myaccount.php">My Account</a></li>

<?php
if(isset($_SESSION['admin'])){
?>
	<li<?php if($page == 'fhd_admin.php'){echo ' class="active"';};?>><a href="fhd_settings.php">Admin</a></li>

<?php
	}
?>

	<li><a href="includes/session.php?logout=y">Logout</a></li>

</ul>