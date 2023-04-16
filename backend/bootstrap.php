<?php


error_reporting(1); // turn off errors output
header("Access-Control-Allow-Origin: http://127.0.0.1:5173"); // allow local browser access to backend


include 'vendor/autoload.php';


// load environmental variables
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();


// Connect to MySQL and create a table if not exist
$mysqli = new mysqli(
    getenv('MYSQL_HOST'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
$mysqli->query('CREATE DATABASE IF NOT EXISTS ' . getenv('MYSQL_DB'));
$mysqli->query('USE ' . getenv('MYSQL_DB'));

$mysqli->multi_query(<<<sql
    CREATE TABLE IF NOT EXISTS twitter_oauth
    (
        id int auto_increment primary key, oauth_token char(200), oauth_token_secret char(200),
        user_id char(200), screen_name char(200)
    );
sql);
while ($mysqli->next_result()) {} // flush result to make $mysqli->query() work
