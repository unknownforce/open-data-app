<?php

// Creates a connection to the database

// We are using PDO to abstract away the database tyoe we are connecting to
// PDO allows us to connect to many different database types: MySQL, SQLite, MSSQL, Oracle, etc.

// WAMP's default user is 'root'
// MAMP's default user is also 'root'
// Edumedia's username is your Algonquin username, like chan0260
$user = 'root'; //WAMP's default user is 'root'


// WAMP's default password is nothing, an empty string, ''
// MAMP's default password is 'root'
// Edumedia's password is your student number, without the first 0
$pass = '';

// Data Source Name
// The location and the name of the database
$dsn = 'mysql:dbname=chan0260;host=localhost';
// localhost above means the database server is on the same computer as this PHP file

// Open the connection to the database using PDO
$db = new PDO($dsn, $user, $pass);

// Force our connectiong to be UTF-8
$db->exec('SET NAMES utf8');