<?php

$outDialResponse = $_POST["Digits"];

if ($outDialResponse == "1") {
    $TwiMLResponse = "<Say>Connecting You To The Caller</Say>";
}
if ($outDialResponse == "2") {
    $TwiMLResponse = "<Hangup/>";
}

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response><?php echo $TwiMLResponse; ?></Response>
