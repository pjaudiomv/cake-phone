<?php
require_once 'twilio-client.php';
require_once 'functions.php';


$recipient = "15089391663";
$caller_id = getOutboundDialingCallerId();

date_default_timezone_set('America/New_York');
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

if (in_array(date("l"), ["Saturday", "Sunday"])) {
    // Weekend
    echo "weekend: office hours";
} else {
    // Weekday
    if (date('G') >= 9 && date('G') < 17) {
        echo "weekday: office hours";
    }
    echo "weekday: after hours";
}

$conferences = $twilioClient->conferences->read(array ("friendlyName" => $_REQUEST['FriendlyName'] ));
$participants = $twilioClient->conferences($conferences[0]->sid)->participants->read();
$callerSid = $participants[0]->callSid;

$twilioClient->calls($callerSid)->update(array(
    "method" => "GET",
    "url" => "/voicemail.php?caller_id=$caller_id&caller_number=$callerNumber"
));
