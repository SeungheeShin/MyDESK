<?php
include '../lib/ParamValidation.php';
$paramCheck = new ParamValidation;
$emailCheck = $paramCheck->emailCheck($_POST['userEmail']);
$numCheck1 = $paramCheck->stringCheck($_POST['deskNum']);
$numCheck2 = $paramCheck->stringCheck($_POST['userNick']);
$numCheck3 = $paramCheck->stringCheck($_POST['repContent']);

if ($emailCheck != true || $numCheck1 != true || $numCheck2 != true || $numCheck3 != true) {
    if ($emailCheck != true) {
        $message = "$emailCheck";
    } else if ($numCheck1 != true) {
        $message = "$numCheck1";
    } else if ($numCheck2 != true) {
        $message = "$numCheck2";
    } else if ($numCheck3 != true) {
        $message = "$numCheck3";
    }

    if (isset($message) === true) {
        echo json_encode(array(false, $message));
    }
} else {
    $deskNum = $_POST['deskNum'];
    $userEmail = $_POST['userEmail'];
    $userNickname = $_POST['userNick'];
    $repContent = $_POST['repContent'];
    $registDay = date("Y-m-d (H:i:s)");

    include './ReplyValidation.php';
    $nInsert = new ReplyValidation;
    $nReply = $nInsert->insertReply($deskNum, $userEmail, $userNickname, $repContent, $registDay);

    echo json_encode(array(true, $nReply));
}
?>

