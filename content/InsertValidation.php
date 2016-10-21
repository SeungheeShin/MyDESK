<?php
include '../lib/BaseValidation.php';

class InsertValidation extends BaseValidation 
{
    function __construct() 
    {
        parent::__construct();
    }
    
    private function makeThumbnail($upfileName, $sourcePath, $upfileType, $upfileSize, $upfileError, $uploadDir, $uploadDirThumb) 
    { // 이미지확인
        
        //이미지 나누기
        $fileName = pathinfo($upfileName, PATHINFO_FILENAME);
        $fileExt = pathinfo($upfileName, PATHINFO_EXTENSION);
        if ($fileName == null || $fileExt == null) {
            throw new Exception('pathinfo Fail');
        }
    
        //썸네일
        $desiredImageWidth = define('DESIRED_IMAGE_WIDTH', 300);
        $desiredImageHeight = define('DESIRED_IMAGE_HEIGHT', 300);
        if ($desiredImageWidth === false || $desiredImageHeight === false) {
            throw new Exception('define Fail');
        }

        $getimagesize = getimagesize($sourcePath);
        if ($getimagesize === false){
            throw new Exception('getimagesize Fail');
        }
        list($sourceWidth, $sourceHeight, $sourceType)  = $getimagesize;

        switch ($sourceType) {
            case IMAGETYPE_GIF:
                $sourceGdim = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_JPEG:
                $sourceGdim = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceGdim = imagecreatefrompng($sourcePath);
                break;
        }
        if ($sourceGdim == false) {
            throw new Exception('imagecreatefrom Fail');
        }
    
        $sourceAspectRatio = $sourceWidth / $sourceHeight;
        $desiredAspectRatio = DESIRED_IMAGE_WIDTH / DESIRED_IMAGE_HEIGHT;

        if ($sourceAspectRatio > $desiredAspectRatio) {
            $tempHeight = DESIRED_IMAGE_HEIGHT;
            $tempWidth = ( int ) (DESIRED_IMAGE_HEIGHT * $sourceAspectRatio);
        } else {
            $tempWidth = DESIRED_IMAGE_WIDTH;
            $tempHeight = ( int ) (DESIRED_IMAGE_WIDTH / $sourceAspectRatio);
        }
    
        $tempGdim = imagecreatetruecolor($tempWidth, $tempHeight);
        if ($tempGdim === false) {
            throw new Exception('imagecreatetruecolor Fail');
        }

        $imagecopyresampled = imagecopyresampled(
            $tempGdim,
            $sourceGdim,
            0, 0,
            0, 0,
            $tempWidth, $tempHeight,
            $sourceWidth, $sourceHeight
        );
        if ($imagecopyresampled == false) {
            throw new Exception('imagecopyresampled Fail');
        }

        $x0 = ($tempWidth - DESIRED_IMAGE_WIDTH) / 2;
        $y0 = ($tempHeight - DESIRED_IMAGE_HEIGHT) / 2;
        $desiredGdim = imagecreatetruecolor(DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);
        if ($desiredGdim == false) {
            throw new Exception('imagecreatetruecolor Fail');
        }

        $imagecopy = imagecopy(
            $desiredGdim,
            $tempGdim,
            0, 0,
            $x0, $y0,
            DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT
        );
        if ($imagecopy == false) {
            throw new Exception('imagecopy Fail');
        }

        header('Content-type: image/jpeg');

        $thumbFileName = date('Y_m_d_H_i_s');
        $thumbFileName = 'thumb_'.$thumbFileName;
        $thumbFileName = $thumbFileName.'.'.$fileExt;

        $imagejpeg = imagejpeg($desiredGdim, $uploadDirThumb.$thumbFileName);
        if ($imagejpeg === false) {
            throw new Exception('imagejpeg Fail');
        } 
        //썸네일 끝
        
    
        if (!$upfileError) {
            $newFileName = date('Y_m_d_H_i_s');
            $newFileName = $newFileName.'_';
            $copiedFileName = $newFileName.'.'.$fileExt;
            $uploadedFile = $uploadDir.$copiedFileName;

            if ($upfileSize>5000000) {
                $resultArray['result'] = false;
                $resultArray['msg'] = '업로드 파일 크기가 지정된 용량(5000KB)을 초과합니다.';

            } else if (($upfileType != 'image/png') && ($upfileType != 'image/jpeg')) {
                $resultArray['result'] = false;
                $resultArray['msg'] = '이미지 파일만 업로드 가능합니다.';

            } else if (!move_uploaded_file($sourcePath, $uploadedFile)) {
                $resultArray['result'] = false;
                $resultArray['msg'] = '파일을 지정한 디렉토리에 복사하는데 실패했습니다.';

            } else {
                $resultArray['result'] = true;
                $resultArray['msg'] = '업로드 성공';
                $resultArray['thumbFileName'] = $thumbFileName;
                $resultArray['copiedFileName'] = $copiedFileName;
            }
            return $resultArray;

        } else {
            return $upfileError;
        }
    }
    
    public function insert($nickname, $email, $job, $content, $registDay, $upfileName, $sourcePath, $upfileType, $upfileSize, $upfileError, $uploadDir, $uploadDirThumb) 
    { //업로드

        try {
            $resultArray = $this->makeThumbnail($upfileName, $sourcePath, $upfileType, $upfileSize, $upfileError, $uploadDir, $uploadDirThumb);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        if ($resultArray['result']) {
            $this->db->insert(
                'mydesk',
                array( 
                    'nickname' => $nickname,
                    'email' => $email,
                    'job' => $job,
                    'content' => $content,
                    'file_name'=> $upfileName,
                    'file_thumb' => $resultArray['thumbFileName'],
                    'file_copied' => $resultArray['copiedFileName'],
                    'regist_day' => $registDay
                )
            );
        }
        return $resultArray;
    }
}

?>