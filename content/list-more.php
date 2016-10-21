<?php
include '../lib/ParamValidation.php';    
$paramCheck = new ParamValidation;    
$numCheck = $paramCheck->stringCheck($_POST['moreNum']);
$emailCheck = $paramCheck->emailCheck($_POST['userMail']);

if ($numCheck != true || $emailCheck != true) {
    if ($numCheck != true && $emailCheck != true) {
        $message = "$numCheck, $emailCheck";
    } else if ($numCheck != true) {
        $message = "$numCheck";
    } else if ($emailCheck != true) {
        $message = "$emailCheck";
    }
    
    if (isset($message) === true) {
        echo json_encode( array (
        'bool' => false, 
        'message' => $message));
    } 
} else {
    $moreNum = $_POST['moreNum'];
    $userMail = $_POST['userMail'];

    include './ListMoreValidation.php';
    $nList = new ListMoreValidation;
    $nMore = $nList->listMore($moreNum, $userMail);

    echo json_encode( array(
        'bool' => true,
        'items' => $nMore[0],
        'hasMore' => $nMore[1]        
    ));
}
?>
