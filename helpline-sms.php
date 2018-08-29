<?php
include 'config.php';
include 'functions.php';
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;

try {
    $service_body = getServiceBodyCoverage( $_REQUEST['Latitude'], $_REQUEST['Longitude'] );
} catch ( Exception $e ) {
    error_log($e);
}
$serviceBodyConfiguration   = getServiceBodyConfiguration($service_body->id);
$sid                        = $GLOBALS['twilio_account_sid'];
$token                      = $GLOBALS['twilio_auth_token'];
$tracker                    = !isset( $_REQUEST["tracker"] ) ? 0 : $_REQUEST["tracker"];

$phone_number = getHelplineVolunteer( $serviceBodyConfiguration->service_body_id, $tracker, $serviceBodyConfiguration->sms_strategy, VolunteerType::SMS );
if ($phone_number == SpecialPhoneNumber::UNKNOWN) {
    $phone_number = $serviceBodyConfiguration->primary_contact_number;
}

try {
    $client = new Client( $sid, $token );
} catch ( \Twilio\Exceptions\ConfigurationException $e ) {
    error_log("Missing Twilio Credentials");
}

if ($serviceBodyConfiguration->sms_routing_enabled) {
    if (isset( $_REQUEST["OriginalCallerId"] )) {
        $original_caller_id = $_REQUEST["OriginalCallerId"];
    }

    $client->messages->create(
        $original_caller_id,
        array(
            "body" => "Your request has been received, someone should be responding to you shortly.",
            "from" => $_REQUEST['To']
        ) );

    $client->messages->create(
        $phone_number,
        array(
            "body" => "Someone is requesting help from " . $original_caller_id . ", please respond back to them.",
            "from" => $_REQUEST['To']
        ) );
}