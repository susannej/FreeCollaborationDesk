<?php
/* The base configurations of Free Help Desk.
/** The name of the database */
define('db_name', 'freehelpdesk');

/** MySQL database username */
define('db_user', 'root');

/** MySQL database password */
define('db_password', '');

/** MySQL hostname */
define('db_host', 'localhost');

/** adjust the time display in hours */
define('FHD_TIMEADJUST', '-5');

/** Set an Auth Key for security*/
define('AUTH_KEY','this is a secret key');

/** Set how many login tries (session only)*/
define('LOGIN_TRIES',10);

/** email address to send new ticket and registration notices FROM, etc  */
define('FROM_EMAIL','postmaster@example.com');

/** email address to send new ticket and registration notices TO, etc  */
define('TO_EMAIL','postmaster@example.com');

/** Allow registrations yes or no */
define('ALLOW_REGISTER','yes');

/** Use CAPTCHA with registration? yes or no */
define('CAPTCHA_REGISTER','yes');

/** All registrations need to be approved by admin yes or no */
define('REGISTER_APPROVAL','yes');

/** Allow unregistered users to submit requests yes/no  */
define('ALLOW_ANY_ADD','no');

/** Enter the organization title **/
define('FHD_TITLE', "Acme");
?>