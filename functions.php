<?php
require_once 'config.php';

date_default_timezone_set('America/New_York');

class SpecialPhoneNumber
{
    const VOICE_MAIL = "voicemail";
}

function getOutboundDialingCallerId()
{
    if (isset($_REQUEST["Caller"])) {
        return $_REQUEST["Caller"];
    } elseif (isset($_REQUEST['caller_id'])) {
        return $_REQUEST['caller_id'];
    } else {
        return "0000000000";
    }
}

function getWebhookUrl()
{
    $voice_url = str_replace("/endpoints", "", "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
    if (strpos(basename($voice_url), ".php")) {
        return substr($voice_url, 0, strrpos($voice_url, "/"));
    } elseif (strpos($voice_url, "?")) {
        return substr($voice_url, 0, strrpos($voice_url, "?"));
    } else {
        return $voice_url;
    }
}
