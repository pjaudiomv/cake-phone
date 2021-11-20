<?php
require_once 'twilio-client.php';
require_once 'functions.php';

$caller_id = getOutboundDialingCallerId();

$GLOBALS['twilioClient']->messages->create(
    $GLOBALS['recipient'],
    array(
        "from" => $caller_id,
        "body" => "You have a message from " . $_REQUEST["caller_number"] . ", " . $_REQUEST["RecordingUrl"] . ".mp3"
    )
);
