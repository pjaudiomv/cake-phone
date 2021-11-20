<?php
include 'functions.php';
require_once 'vendor/autoload.php';

use Twilio\Rest\Client;
$sid                        = $GLOBALS['twilio_account_sid'];
$token                      = $GLOBALS['twilio_auth_token'];
try {
    $client = new Client($sid, $token);
} catch (\Twilio\Exceptions\ConfigurationException $e) {
    error_log("Missing Twilio Credentials");
}

$caller_id = getOutboundDialingCallerId();

$client->messages->create(
    $GLOBALS['recipient'],
    array(
        "from" => $caller_id,
        "body" => "You have a message for becky bakes cakes from " . $_REQUEST["caller_number"] . ", " . $_REQUEST["RecordingUrl"] . ".mp3"
    )
);
