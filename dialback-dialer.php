<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
<!--    <Say voice="Polly.Kendra" language="en-US">Please wait while we connect your call</Say>-->
    <Play>https://bmlt.charlestonna.org/recordings/dialback-dialer.mp3</Play>
    <Dial callerId="<?php echo $_GET['Called'] ?>">
        <?php echo str_replace("#", "", $_GET['Digits']); ?>
    </Dial>
</Response>
