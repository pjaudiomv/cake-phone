<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
    <Gather action="./outdial-response.php" numDigits="1">
        <Say>You have an incoming call from becky bakes cakes.</Say>
        <Say>To accept the call, press 1.</Say>
        <Say>To reject the call, press 2.</Say>
    </Gather>
</Response>
