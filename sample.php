<?php

// Include config file that contains login credentials
require_once './config.php';
require_once './vendor/autoload.php';

use Trunk\VtigerApi\VtigerApi;

// Create APi Instance
$api = VtigerApi::url('https://yoururlhere')->authenticate(config::USERNAME, config::SECRET);
