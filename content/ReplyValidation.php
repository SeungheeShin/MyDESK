<?php
include '../lib/BaseValidation.php';

class ReplyValidation extends BaseValidation 
{
    function __construct()
    {
        parent::__construct();
    }
    
    private function replyCheck($deskNum, $userEmail, $userNickname, $repContent, $registDay)
    { //댓글 입력
        $result = $this->db->insert(
            'reply',
            array(
                'desk_num' => $deskNum,
                'email' => $userEmail,
                'nickname' => $userNickname,
                'content' => $repContent,
                'regist_day' => $registDay
            )
        );
        return $result;
    }
    
    public function insertReply($deskNum, $userEmail, $userNickname, $repContent, $registDay)
    { //댓글 입력 후 처리
        if ($this->replyCheck ($deskNum, $userEmail, $userNickname, $repContent, $registDay)) {
            $datas = $this->db->select(
                'reply', '*',
                array('desk_num' => $deskNum),
                array('ORDER' => array('reply_num' => 'DESC')),
                array('LIMIT' => 1)
            );

            foreach ($datas as $data) {
                if ($data) {
                    $item = new stdClass();
                    $item->reply_num = $data['reply_num'];
                    $item->desk_num = $data['desk_num'];
                    $item->email = $data['email'];
                    $item->nickname = $data['nickname'];
                    $item->content = $data['content'];
                    $item->regist_day = $data['regist_day'];
                }
            }
        } //end if
        return $item;
    }
    
}
?>