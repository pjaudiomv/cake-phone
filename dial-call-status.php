<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<?php if (in_array($_REQUEST["DialCallStatus"], ["busy", "no-answer", "failed"])
    || ($_REQUEST["DialCallStatus"] == "completed" && $_REQUEST["CallStatus"] == "in-progress")) {
    // This or handles case where the recipient picks up but then hits end call without selecting digit
    header("Location: voicemail.php?To="
        . urlencode($_REQUEST["To"])
        . "&Caller="
        . urlencode($_REQUEST["Caller"]));
} else { ?>
    <Response>
        <Hangup/>
    </Response>
<?php }?>
