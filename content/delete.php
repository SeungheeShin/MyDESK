<?php
include '../lib/ParamValidation.php';
$paramCheck = new ParamValidation;
$numCheck = $paramCheck->stringCheck($_POST['deskNum']);

if ($numCheck === true) {
    $deskNum = $_POST['deskNum'];

    include './DeleteValidation.php';
    $deleteContent = new DeleteValidation;
    $delete = $deleteContent->delete($deskNum);
    echo json_encode($delete);
} else {
    echo json_encode($numCheck);
} 
?>
