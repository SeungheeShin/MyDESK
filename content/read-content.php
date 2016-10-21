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
        echo json_encode( array (
            'bool' => false, 
            'message' => $message
        ));
    } 
} else {
    $deskNum = $_POST['deskNum'];
    $userId = $_POST['userId'];

    include './ReadContentValidation.php';
    $readContent = new ReadContentValidation;
        
    if ($deskNum) {
        $read = $readContent->read($deskNum, $userId);
    } else {
        $read = $readContent->readRand($userId);
    }
            
    echo json_encode( array(
        'bool' => true,
        'itemCon' => $read[0],
        'itemRep' => $read[1],
        'itemDel' => $read[2]
    ));
}
?>
