<?php
require_once 'vendor/autoload.php';
include_once('db/dbhelper.php');


// init configuration
$clientID = '168513165900-cpgel5509vk1ae0s9u200kk12gs7codo.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/techwiz/user-login.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
?>