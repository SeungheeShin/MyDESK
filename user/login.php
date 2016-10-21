<?php
session_start();

include '../lib/ParamValidation.php';
$paramCheck = new ParamValidation;
$emailCheck = $paramCheck -> emailCheck($_POST['loginEmail']);
$numCheck = $paramCheck -> stringCheck($_POST['loginPswd']);

if ($emailCheck != true || $numCheck != true) {
    if ($emailCheck != true) {
        $message = "$emailCheck";
    } else if ($numCheck1 != true) {
        $message = "$numCheck";
    }
    if (isset($message) === true) {
        echo json_encode(array(false, $message));
    }
} else {
    $loginEmail = $_POST['loginEmail'];
    $loginPswd = $_POST['loginPswd'];

    include './LoginValidation.php';
    $cMember = new LoginValidation;
    $Cuser = $cMember -> login($loginEmail, $loginPswd);

    if ($Cuser['result'] === true) {
        $sucsMessage = $Cuser['msg'];
        echo json_encode(array(true, $sucsMessage));
    } else {
        $failMessage = $Cuser['msg'];
        echo json_encode(array(false, $failMessage));
    }
}
?>