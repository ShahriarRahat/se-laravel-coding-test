## About This Project

This is a coding test from Mediusware. The main requirements of this project are

- Implement a banking system with two types of users: Individual and Business.
- The system should support deposit and withdrawal operations for both types of users.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## How to set up and run the project

As the project is built on Laravel Framework 10.10. You'll need to have php version 8.1+ to get it up and running. If you don't have php, you can get the latest version with installation instruction from here - [Windows](https://www.geeksforgeeks.org/how-to-install-php-in-windows-10/), [Mac](https://www.geeksforgeeks.org/how-to-install-php-on-macos/), [Linux](https://www.geeksforgeeks.org/how-to-install-php-on-linux/).
You'll need [Composer](https://getcomposer.org/download/) and MySQL/MariaDB for resolving the dependencies and database connection.

*Or*, You can get virtual environment creators like [Laragon](https://laragon.org/download/index.html) - for Windows, [Valet](https://laravel.com/docs/10.x/valet) - for Mac, [Valet](https://cpriego.github.io/valet-linux/) - for Linux 


Setting Up the project is pretty simple. Just follow the instruction below:

- Clone the repository first
- Copy .env.example and paste in the same direcory renaming it to *.env*
- Update your database credentials in .env
- Open a terminal in the current directory and run *composer u*
- After successfully completing the composer update process run *php artisan migrate:fresh*
- Run *php artisan serve*
- You can also use the virtual environments according to their respective instruction to get the site up and running


