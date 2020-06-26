<?php

// Includes composer packages
require '../vendor/autoload.php';

// Function allows to return a connection to the db
function getDb(){

    // Here you can change settings to connection to the site's db
    $dbHost = 'localhost';
    $dbName = 'revisions_php';
    $dbUser = 'root';
    $dbPassword = '';

    return new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8', $dbUser, $dbPassword);
}
