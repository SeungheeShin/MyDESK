<?php
include '../lib/ParamValidation.php';
$paramCheck = new ParamValidation;
$numCheck = $paramCheck->stringCheck($_POST['deskNum']);
$emailCheck = $paramCheck->emailCheck($_POST['userId']);

if ($numCheck != true || $emailCheck != true) {
    if ($numCheck != true && $emailCheck != true) {
        $message = "$numCheck, $emailCheck";
    } else if ($numCheck != true) {
        $message = "$numCheck";
    } else if ($emailCheck != true) {
        $message = "$emailCheck";
    }

    if (isset($message) === true) {
        echo json_encode($message);
    }
} else {
    $deskNum = $_POST['deskNum'];
    $userId = $_POST['userId'];
    // $ipId = $_POST['ipId'];
    $registDay = date("Y-m-d (H:i:s)");

    include './VoteValidation.php';
    $nInsert = new VoteValidation;
    $nVote = $nInsert->voteCount($deskNum, $userId, $registDay);

    echo json_encode($nVote);
}
?>
