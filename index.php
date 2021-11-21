<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>

<Response>
    <Say voice="Polly.Kendra" language="en-US">Please wait while we connect your call</Say>
    <Pause length="2"></Pause>
    <Dial>
        <Conference waitUrl="https://pjoyce.photos/becky/lovelyday.mp3"
                    statusCallback="dialer.php?Caller=<?php echo $_REQUEST['Called'] ?>"
                    startConferenceOnEnter="false"
                    statusCallbackMethod="GET"
                    statusCallbackEvent="start join end leave"
                    endConferenceOnExit="true"
                    beep="false">
            beckycakes
        </Conference>
    </Dial>
</Response>
