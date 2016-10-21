<?php
include '../lib/ParamValidation.php';
$paramCheck = new ParamValidation;  
$numCheck = $paramCheck->stringCheck($_POST['replyNum']);

if ($numCheck === true) {
    $replyNum = $_POST['replyNum'];
    
    include './ReplyDeleteValidation.php';
    $deleteReply = new ReplyDeleteValidation;
    $delete = $deleteReply->delete($replyNum);
    
    echo json_encode( array(true, $delete));
} else {
    echo json_encode( array(false, $numCheck));
}
?>