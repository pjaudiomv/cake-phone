<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
<?php if (in_array($_REQUEST["DialCallStatus"], ["busy", "no-answer", "failed"])) { ?>
    <Say voice="Polly.Kendra" language="en-US">I am sorry. No one is around at the moment to take your call. Please leave your name and number and someone will get back to you shortly. Thank you!</Say>
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
