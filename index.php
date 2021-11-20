<?php
require_once 'twilio-client.php';
require_once 'functions.php';


$recipient = "15089391663";
$caller_id = getOutboundDialingCallerId();

date_default_timezone_set('America/New_York');
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Say voice="Polly.Kendra" language="en-US">Please wait while we connect your call</Say>
<Dial>
    <Conference waitUrl="https://pjoyce.photos/becky/lovelyday.mp3"
                statusCallback="dialer.php?Caller=<?php echo $_REQUEST['Called'] ?>"
                startConferenceOnEnter="false"
                endConferenceOnExit="true"
                statusCallbackMethod="GET"
                statusCallbackEvent="start join end leave"
                beep="false">
        2
    </Conference>
</Dial>
