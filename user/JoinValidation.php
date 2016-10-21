<?php
include '../lib/BaseValidation.php';

class JoinValidation extends BaseValidation 
{
    function __construct() 
    {
        parent::__construct();
    }
    
    private function idCheck($joinEmail) 
    { //아이디 검사 
        $count = $this->db->count(
            'user',
            array('email' => $joinEmail)
        );

        $this->tot = $count;
        return $this->tot;
    }
    
    public function memberJoin($joinEmail, $joinPswd, $joinNick, $registDay) 
    { //로그인 처리
        if ($this->idCheck($joinEmail) > 0) {
            $resultArray['result'] = false;
            $resultArray['msg'] = '이미 가입된 계정입니다';
        } else {
            $this->db->insert(
                'user',
                array(
                    'email' => $joinEmail,
                    '#password' => "PASSWORD('$joinPswd')",
                    'nickname' => $joinNick,
                    'regist_day' => $registDay
                )
            );
            $resultArray['result'] = true;
            $resultArray['msg'] = '가입완료되었습니다';
        }        
        return $resultArray;
    }
    
}
?>