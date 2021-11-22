<?php
$recipientNumber = "+15089391663";
$menuInput = $_GET["Digits"];
header("content-type: text/xml");
error_log(print_r($_REQUEST, true));
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
<?php if ($_REQUEST["From"] == $recipientNumber) { ?>
    <Gather language="en-US" input="dtmf" timeout="15" finishOnKey="#" method="GET" action="dialback-dialer.php">
        <Say voice="Polly.Kendra" language="en-US">Hello Becky Please enter the phone number to dialback, followed by the pound sign.</Say>
    </Gather>
<?php } else { ?>
    <?php if ($menuInput == "1") { ?>
    <Dial timeout="10" action="./dial-call-status.php" callerId="<?php echo $_REQUEST["To"] ?>">
        <Number url="./dialer.php"><?php echo $recipientNumber ?></Number>
    </Dial>
    <?php } else { ?>
    <Gather method="GET" timeout="25" numDigits="1">
        <Say voice="Polly.Kendra" language="en-US">Hello and welcome to Becky Bakes Cakes, to get a hold of becky press 1.</Say>
    </Gather>
    <?php } ?>
<?php } ?>
</Response>
