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
- ~~remove sectioning between add and edit user~~
- ~~remove sectioning between user and staff~~ (take user as someone who isn't allowed to work on tickets...)
- ~~redirect to the dashboard after login~~
- insert a group membership (no need to insert a group, rename the department to group)
- possibility to add files to a ticket
- rename fhd_mod_types.php -> fhd_edit_types.php
- ~~modify title in fhd_mod_types.php from "edit types" in "edit department", "edit xxx" and so on...~~
- ~~add title like in fhd_mod_types to edit-user~~
- ~~add a return to user-list link (like in add-type) into add-user and in all edit-xxx pages~~
- ~~include the fhd_settings page into the fhd_settings-action and fhd_users page~~ NO! (corrupts the clean design of fhd!)
- ~~remove the fhd-settings page afterwards~~ NO! (corrupts the clean design of fhd!)
- make sure, that add and edit user contain the same fields