<?php
require_once 'config.php';

function getOutboundDialingCallerId() {
    if (isset($_REQUEST["Caller"])) {
        return $_REQUEST["Caller"];
    } else if (isset($_REQUEST['caller_id'])) {
        return $_REQUEST['caller_id'];
    } else {
        return "0000000000";
    }
}

