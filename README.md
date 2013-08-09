FreeCollaborationDesk
=====================

A helpdesk system for collaborating teams

The initial version is based on the freehelpdesk.org FreeHelpDesk.

Prerequisites
-------------

- WEB-Server with the ability to serf PHP-pages
- MySQL Server

Installation
------------

1. copy all files to your web host
2. create a database and a database user for the application
3. run site.sql against your database.
4. open fhd_config.php and edit the database section with your database details.
5. go to index.php and login with username of admin with a password of test.
6. be sure to change the passwords for the admin and regular user.
7. delete the site.sql file.

ToDo
----

- posibility to delete user
- internationalisation
- remove sectioning between add and edit user
- remove sectioning between user and staff
- redirect to the dashboard after login
- insert a group membership