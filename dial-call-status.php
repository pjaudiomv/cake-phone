<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
<?php if (in_array($_REQUEST["DialCallStatus"], ["busy", "no-answer", "failed"])
    || ($_REQUEST["DialCallStatus"] == "completed" && $_REQUEST["CallStatus"] == "in-progress")) {
    // This or handles case where the recipient picks up but then hits end call without selecting digit
?>
    <Play>https://bmlt.charlestonna.org/recordings/voicemail.mp3</Play>
<!--    <Say voice="Polly.Kendra" language="en-US">I am sorry. No one is around at the moment to take your call. Please leave a message after the tone, hang up when finished.</Say>-->
    <Record playBeep="true"
            recordingStatusCallback="./voicemail-handle.php?caller_id=<?php echo urlencode($_REQUEST["To"])?>&amp;caller_number=<?php echo urlencode($_REQUEST["Caller"])?>"
            recordingStatusCallbackMethod="GET"
            maxLength="120"
            timeout="15"/>
    <Say voice="Polly.Kendra" language="en-US">I did not receive a recording</Say>
<?php } else { ?>
    <Hangup/>
<?php }?>
</Response>
