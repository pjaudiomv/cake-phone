<?php
include 'config.php';
include 'functions.php';
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;

class CallConfig
{
    public $phone_number;
    public $voicemail_url;
    public $options;
}

function getCallConfig($client)
{
    $tracker            = !isset($_REQUEST["tracker"]) ? 0 : $_REQUEST["tracker"];
    $numbers            = $client->incomingPhoneNumbers->read(array( "phoneNumber" => $_REQUEST['Caller'] ));
    $voice_url          = $numbers[0]->voiceUrl;
    if (strpos(basename($voice_url), ".php")) {
        $webhook_url = substr($voice_url, 0, strrpos($voice_url, "/"));
    } elseif (strpos($voice_url, "?")) {
        $webhook_url =  substr($voice_url, 0, strrpos($voice_url, "?"));
    } else {
        $webhook_url = $voice_url;
    }
    $caller_id = isset($_REQUEST["Caller"]) ? $_REQUEST["Caller"] : "0000000000";
    $config = new CallConfig();
    $config->phone_number = $GLOBALS['recipient'];
    $config->voicemail_url = $webhook_url . '/voicemail.php?caller_id=' . $caller_id;
    $config->options = array(
        'url'                  => $webhook_url . '/outdial-response.php?conference_name=' . $_REQUEST['FriendlyName'],
        'statusCallback'       => $webhook_url . '/dialer.php?tracker=' . ++ $tracker . '&FriendlyName=' . $_REQUEST['FriendlyName'],
        'statusCallbackEvent'  => 'completed',
        'statusCallbackMethod' => 'GET',
        'timeout'              => 20,
        'callerId'             => $caller_id
    );

    return $config;
}

$sid                        = $GLOBALS['twilio_account_sid'];
$token                      = $GLOBALS['twilio_auth_token'];
try {
    $client = new Client($sid, $token);
} catch (\Twilio\Exceptions\ConfigurationException $e) {
    error_log("Missing Twilio Credentials");
}

$conferences = $client->conferences->read(array ("friendlyName" => $_REQUEST['FriendlyName'] ));
if (count($conferences) > 0 && $conferences[0]->status != "completed") {
    // Make timeout configurable per volunteer
    if (( isset($_REQUEST['SequenceNumber']) && intval($_REQUEST['SequenceNumber']) == 1 ) ||
        ( isset($_REQUEST['CallStatus']) && ( $_REQUEST['CallStatus'] == 'no-answer' || $_REQUEST['CallStatus'] == 'completed' ) )) {
        $callConfig = getCallConfig($client);
        error_log("Dialing " . $callConfig->phone_number);

        $participants = $client->conferences($conferences[0]->sid)->participants->read();

        // Do not call if the caller hung up.
        if (count($participants) > 0) {
            $callerSid = $participants[0]->callSid;
            $callerNumber = $client->calls($callerSid)->fetch()->from;
            if ($callConfig->phone_number == SpecialPhoneNumber::VOICE_MAIL) {
                $client->calls($callerSid)->update(array(
                    "method" => "GET",
                    "url" => $callConfig->voicemail_url . "&caller_number=" . $callerNumber
                ));
            } else {
                try {
                    $client->messages->create(
                        $callConfig->phone_number,
                        array(
                            "body" => "You have an becky bakes cakes call from " . $callerNumber . ".",
                            "from" => $callConfig->options['callerId']
                        )
                    );


                    $client->calls->create(
                        $callConfig->phone_number,
                        $callConfig->options['callerId'],
                        $callConfig->options
                    );
                } catch (\Twilio\Exceptions\TwilioException $e) {
                    error_log($e);
                }
            }
        }
    } elseif (isset($_REQUEST['StatusCallbackEvent']) && $_REQUEST['StatusCallbackEvent'] == 'participant-leave') {
        $conference_sid          = $conferences[0]->sid;
        $conference_participants = $client->conferences($conference_sid)->participants;
        foreach ($conference_participants as $participant) {
            try {
                $client->calls($participant->callSid)->update(array( $status => 'completed' ));
            } catch (\Twilio\Exceptions\TwilioException $e) {
                error_log($e);
            }
        }
    }
}














//
//if (in_array(date("l"), ["Saturday", "Sunday"])) {
//    // Weekend
//    echo "weekend: office hours";
//} else {
//    // Weekday
//    if (date('G') >= 9 && date('G') < 17) {
//        echo "weekday: office hours";
//    }
//    echo "weekday: after hours";
//}
//
//$conferences = $twilioClient->conferences->read(array ("friendlyName" => $_REQUEST['FriendlyName'] ));
//$participants = $twilioClient->conferences($conferences[0]->sid)->participants->read();
//$callerSid = $participants[0]->callSid;
//
//$twilioClient->calls($callerSid)->update(array(
//    "method" => "GET",
//    "url" => "/voicemail.php?caller_id=$caller_id&caller_number=$callerNumber"
//));
