<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
    <?php if ($_POST["Digits"] == "1") { ?>
        <Play>https://bmlt.charlestonna.org/recordings/outdial-response.mp3</Play>
<!--        <Say voice="Polly.Kendra" language="en-US">Connecting You To The Caller</Say>-->
    <?php } ?>
    <?php if ($_POST["Digits"] == "2") { ?>
        <Hangup/>
    <?php }?>
</Response>
