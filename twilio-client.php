<?php
require_once __DIR__ . 'vendor/autoload.php';
require_once 'functions.php';

use Twilio\Rest\Client;

try {
    $twilioClient = new Client($GLOBALS['twilio_sid'], $GLOBALS['twilio_token']);
    $GLOBALS['twilioClient'] = $twilioClient;
} catch (\Twilio\Exceptions\ConfigurationException $e) {
    error_log("Missing Twilio Credentials");
}
