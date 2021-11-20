<?php
require_once 'twilio-client.php';
require_once 'functions.php';


$caller_id = getOutboundDialingCallerId();

$callerNumber = $_REQUEST["caller_number"];
$GLOBALS['twilioClient']->messages->create(
    $GLOBALS['recipient'],
    array(
        "from" => $caller_id,
        "body" => "You have a message from " . $callerNumber . ", " . $_REQUEST["RecordingUrl"] . ".mp3"
    )
);
