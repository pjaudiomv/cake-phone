<?php
include 'config.php';
$menuInput = $_GET["Digits"];
$recipientNumber = $GLOBALS['recipient'];
date_default_timezone_set('America/New_York');
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
//error_log(print_r($_REQUEST, true));
?>
<Response>
<?php if ($_REQUEST["From"] == $recipientNumber) { ?>
    <Gather language="en-US" input="dtmf" timeout="15" finishOnKey="#" method="GET" action="dialback-dialer.php">
        <Play>https://bmlt.charlestonna.org/recordings/hello-becky.mp3</Play>
<!--        <Say voice="Polly.Kendra" language="en-US">Hello Becky Please enter the phone number to dialback, followed by the pound sign.</Say>-->
    </Gather>
<?php } else { ?>
    <?php if ($menuInput == "1") {
        if (in_array(date("l"), ["Saturday", "Sunday"])) {
            // Weekend
            header("Location: voicemail.php?To="
                . urlencode($_REQUEST["To"])
                . "&Caller="
                . urlencode($_REQUEST["Caller"]));
        } else {
            // Weekday
            if (date('G') >= 9 && date('G') < 17) { ?>
                <Dial timeout="10" action="./dial-call-status.php" callerId="<?php echo $_REQUEST["To"] ?>">
                    <Number url="./dialer.php"><?php echo $recipientNumber ?></Number>
                </Dial>
                <?php
            }
            // weekday after hours
            header("Location: voicemail.php?To="
                . urlencode($_REQUEST["To"])
                . "&Caller="
                . urlencode($_REQUEST["Caller"]));
        }
    } elseif (isset($menuInput)) { ?>
        <Gather method="GET" timeout="25" numDigits="1">
            <Play>https://bmlt.charlestonna.org/recordings/invalid-key.mp3</Play>
<!--            <Say voice="Polly.Kendra" language="en-US">You have pressed an invalid key, to get a hold of becky press 1.</Say>-->
        </Gather>
    <?php } else { ?>
    <Gather method="GET" timeout="25" numDigits="1">
        <Play>https://bmlt.charlestonna.org/recordings/welcome.mp3</Play>
<!--        <Say voice="Polly.Kendra" language="en-US">Hello and welcome to Becky Bakes Cakes, to get a hold of becky press 1.</Say>-->
    </Gather>
    <?php } ?>
<?php } ?>
</Response>
