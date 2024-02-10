# taskmanagement
Task Management System with Authentication
<p align="center"><a href="https://cbtms1210.x10.bz" target="_blank"><img src="https://github.com/ceejay06s/taskmanagement/blob/main/public%2Flogo.png" width="400"></a></p>

<!--<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status">1.0.2</a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>-->

## About Task Manager

Create a Task or a Sub-Task with Task Manager with following functions using Laravel and Materialize Css

- Authentication.
- Send Email to Verify new registration
- Reset Password
- Create and Edit Task and Sub Task.
- Remove Task (will be move to bin for manually deletion).
- Permanently Delete Task.
- Upload Attachments Image or Document in Task and Sub-Task.
- Download attachments.
- Delete Attachments Permanently.

<h1>How to Setup?</h1>

- Clone or Download this Repository to your respective server or local server
- Create your Database Schema
- modify the .env file the database credentials to connect to database
- (Option 1) execute to the terminal <code>php artisan migrate</code> or simply run your browser (http://yourdomain/migrate) only run once
- (option 2) import the taskmanagementsytem.sql to your created Database Schema
- execute to the terminal <code>php artisan storage:link</code> or simply run your browser (http://yourdomain/link)
- to create temporary server in your local workstation run command <code>php artisan serve</code> then browse to (http://localhost:8000)

For Demo Go to [https://cbtms1210.x10.bz] 

Works with Mobile and Desktop Browsers
