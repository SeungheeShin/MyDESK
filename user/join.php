<?php
include '../lib/ParamValidation.php';
$paramCheck = new ParamValidation;
$emailCheck = $paramCheck -> emailCheck($_POST['joinEmail']);
$numCheck1 = $paramCheck -> stringCheck($_POST['joinPswd']);
$numCheck2 = $paramCheck -> stringCheck($_POST['joinNick']);

if (is_bool($emailCheck) === true && $numCheck1 === true && $numCheck2 === true) {
    $joinEmail = $_POST['joinEmail'];
    $joinPswd = $_POST['joinPswd'];
    $joinNick = $_POST['joinNick'];
    $registDay = date("Y-m-d (H:i:s)");

    include './JoinValidation.php';
    $nMember = new JoinValidation;
    $nUser = $nMember -> memberJoin($joinEmail, $joinPswd, $joinNick, $registDay);

    if ($nUser['result'] === true) {
        $sucsMessage = $nUser['msg'];
        echo json_encode(array(true, $sucsMessage));
    } else {
        $failMessage = $nUser['msg'];
        echo json_encode(array(false, $failMessage));
    }
} else {
    if (is_bool($emailCheck) != true) {
        $message = "$emailCheck";
    } else if ($numCheck1 != true) {
        $message = "$numCheck1";
    } else if ($numCheck2 != true) {
        $message = "$numCheck2";
    }

    if (isset($message) === true) {
        echo json_encode(array(false, $message));
    }
}
?>