<?php
require_once __DIR__ . 'vendor/autoload.php';
use Twilio\Rest\Client;
$twilio_sid = "";
$twilio_token = "";

try {
    $twilioClient = new Client($twilio_sid, $twilio_token);
    $GLOBALS['twilioClient'] = $twilioClient;
} catch (\Twilio\Exceptions\ConfigurationException $e) {
    error_log("Missing Twilio Credentials");
}
