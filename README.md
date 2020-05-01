# Proftalk

Scheduling module mockup for an existing education management system, designed to allow professors to open availabilty slots and allow students to select appointment slots from the available un-taken slots. Availability changes and appointments write to a [MariaDB](https://mariadb.org/) database using [mysqli](https://www.php.net/manual/en/book.mysqli.php), and site shows scheduled appointments as well as professors for the logged in account if the account is a student, site will show scheduled appointments and students for the logged in account if the account is a professor. Working model was requested inside of a two week window with emphasis placed on basic functionality rather than visual appeal or features suite.

## Current Database Layout

![ERD](https://github.com/iwantmyhatback/proftalk/blob/master/img/current_erd.png)
