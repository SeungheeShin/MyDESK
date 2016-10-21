<?php
include '../lib/BaseValidation.php';

class LoginValidation extends BaseValidation 
{
    function __construct() {
        parent::__construct();
    }
    
    private function idCheck($loginEmail) 
    { //아이디 검사 
        $count = $this->db->count(
            "user",
            array('email' => $loginEmail)
        );

        $this->tot = $count;
        return $this->tot;
    }
    
    private function pswdCheck($loginEmail, $loginPswd) 
    { //아이디에 대한 비밀번호 검사
        $count = $this->db->count(
            "user",
            array( 'AND' => array('email' => $loginEmail, '#password' => "PASSWORD('$loginPswd')"))
        );

        $this->tot = $count;
        return $this->tot;
    }
    
    private function loginCheck($loginEmail, $loginPswd) 
    { //로그인 전 유효성 확인
        if ($this->idCheck($loginEmail) <= 0) {
            $resultArray['result'] = false;
            $resultArray['msg'] = '존재하지 않는 계정입니다.';
        } else {
            if ($this->pswdCheck($loginEmail, $loginPswd) <= 0) {
                $resultArray['result'] = false;
                $resultArray['msg'] = '잘못된 비밀번호 입니다. ';
            } else {
                $resultArray['result'] = true;
                $resultArray['msg'] = '로그인 성공';
            }
        }
        return $resultArray;
    }

    private function logoutCheck() 
    { //로그아웃 처리 -- 미사용
        unset($_SESSION['useremail']);
        unset($_SESSION['usernickname']);
        $this->$resultArray['result'] = true;
        $this->$resultArray['msg'] = '로그아웃 확인';
        return $this->$resultArray;
    }
    
    public function login($loginEmail, $loginPswd) 
    { //로그인 처리
        $returnArray = $this->loginCheck($loginEmail, $loginPswd);

        if ($returnArray['result'] === true) {
            $datas2 = $this->db->select(
                'user', "*",
                array('AND' => array('email' => $loginEmail, '#password' => "PASSWORD('$loginPswd')"))
            );

            foreach($datas2 as $data){
                $useremail = $data['email'];
                $usernickname = $data['nickname'];
                $_SESSION['useremail'] = $useremail;
                $_SESSION['usernickname'] = $usernickname;
            }
        } //end if
        return $returnArray;
    }
    
}
?>