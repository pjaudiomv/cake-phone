<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
    <Gather action="./outdial-response.php" numDigits="1">
        <Play>https://bmlt.charlestonna.org/recordings/dialer.mp3</Play>
<!--        <Say voice="Polly.Kendra" language="en-US">You have an incoming call from becky bakes cakes.</Say>-->
<!--        <Say voice="Polly.Kendra" language="en-US">To accept the call, press 1.</Say>-->
<!--        <Say voice="Polly.Kendra" language="en-US">To reject the call, press 2.</Say>-->
    </Gather>
</Response>
