<?php
include 'config.php';
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;

$sid    = $GLOBALS['twilio_account_sid'];
$token  = $GLOBALS['twilio_auth_token'];
try {
    $client = new Client($sid, $token);
    $client->messages->create(
        $GLOBALS['recipient'],
        array(
            "from" => $_REQUEST["caller_id"],
            "body" => "You have a message for becky bakes cakes from " . $_REQUEST["caller_number"],
            'mediaUrl' => $_REQUEST["RecordingUrl"] . ".mp3"
        )
    );
} catch (\Twilio\Exceptions\ConfigurationException $e) {
    error_log("Missing Twilio Credentials");
}
