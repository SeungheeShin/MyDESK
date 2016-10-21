<?php
include '../lib/BaseValidation.php';

class ReplyDeleteValidation extends BaseValidation 
{
    function __construct() 
    {
        parent::__construct();
    }

    private function deleteCheck($replyNum) 
    {//삭제처리
        $datas = $this->db->delete('reply', array('reply_num' => $replyNum));
        return $datas;
    }

    public function delete($replyNum) 
    {//삭제처리 후 응답
        $datas = $this->deleteCheck($replyNum);
        if ($datas) {
            return true;
        } else {
            return false;
        }
    }
}
?>