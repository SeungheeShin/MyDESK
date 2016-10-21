<?php
include '../lib/ParamValidation.php';
    
$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : NULL;
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$job = isset($_POST['job']) ? $_POST['job'] : NULL;
$content = isset($_POST['content']) ? $_POST['content'] : NULL; 
$registDay = date('Y-m-d (H:i:s)');
$upfileName	 = $_FILES['upfile']['name'];
$sourcePath = $_FILES['upfile']['tmp_name'];
$upfileType = $_FILES['upfile']['type'];
$upfileSize = $_FILES['upfile']['size'];
$upfileError = $_FILES['upfile']['error'];
$uploadDir = '../data/origin/'; //원본 경로
$uploadDirThumb = '../data/thumbnails/'; //썸네일 경로
    
if (!$upfileName) {
    $failMessage = "파일명이 잘못되었습니다";
} else if (!$sourcePath) {
    $failMessage = "파일경로가 잘못되었습니다";
} else if (!$upfileType) {
    $failMessage = "파일타입이 잘못되었습니다";
} else if ($upfileSize === 0) {
    $failMessage = "파일크기가 잘못되었습니다";
} else if ($upfileError > 0) {
    $failMessage = $upfileError." 에러 발생";
}
    
if ($upfileError == 0) {
    include './InsertValidation.php';
    $nInsert = new InsertValidation;
    $nContent = $nInsert->insert(
        $nickname, $email, $job, $content, $registDay, 
        $upfileName, $sourcePath, $upfileType, $upfileSize, $upfileError, $uploadDir, $uploadDirThumb
        );

    if ($nContent['result'] === true) {
        $sucsMessage = $nContent['msg'];
        echo json_encode( array(
            'sm' => $sucsMessage
        ));
    } else {
        $failMessage = $nContent['msg'];
        echo json_encode( array(
            'fm' => $failMessage
        ));
    }
} else {
    echo json_encode( array(
        'fm' => $failMessage
    ));
}
?>