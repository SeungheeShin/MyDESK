<?php
include '../lib/ParamValidation.php';
$paramCheck = new ParamValidation;
$emailCheck = $paramCheck->emailCheck($_POST['userId']);

if (is_bool($emailCheck) === true) {
    $userId = $_POST['userId'];
    include './ReadContentValidation.php';
    $readContent = new ReadContentValidation;
    $read = $readContent->readRand($userId);

    if ($read === false) {
        echo json_encode( array (
            'bool' => false, 
            'message' => '게시글이 없습니다'
        ));
    } else {
        echo json_encode( array(
            'bool' => true,
            'itemCon' => $read[0],
            'itemRep' => $read[1],
            'itemDel' => $read[2]
        ));
    }
} else {
    echo json_encode( array (
        'bool' => false, 
        'message' => $emailCheck
    ));
}    
?>