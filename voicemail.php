<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say voice="Polly.Kendra" language="en-US">
        Please leave a message after the tone, hang up when finished.
    </Say>
    <Record
        playBeep="true"
        recordingStatusCallback="<?php echo getWebhookUrl()?>voicemail-complete.php?caller_id=<?php echo urlencode($_REQUEST["caller_id"])?>&amp;caller_number=<?php echo urlencode($_REQUEST["Caller"])?>"
        recordingStatusCallbackMethod="GET"
        maxLength="120"
        timeout="15"/>
</Response>
