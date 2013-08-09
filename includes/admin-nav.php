<?php $page = basename($_SERVER['REQUEST_URI']);?>

<ul class="nav nav-tabs">
<li<?php if($page == 'fhd_settings.php'){echo ' class="active"';};?>><a href="fhd_settings.php">Settings</a></li>
<li<?php if($page == 'fhd_admin_register.php'){echo ' class="active"';};?>><a href="fhd_admin_register.php">Add User</a></li>
<li<?php if($page == 'fhd_users.php'){echo ' class="active"';};?>><a href="fhd_users.php">Edit User</a></li>
</ul>