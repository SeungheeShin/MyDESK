<?php
include '../lib/BaseValidation.php';

class ReadContentValidation extends BaseValidation 
{

    function __construct()
    {
        parent::__construct();
    }
    
    private function randomCheck()
    { //랜덤 글 확인
        $datas = $this->db->query('SELECT desk_num AS ran_num FROM mydesk order by rand() limit 1');

        foreach($datas as $data) {
            $ranNum = $data['ran_num'];
        }
        
        if (isset($ranNum) === true) {
            return $ranNum;
        } else {
            return false;
        }
    }
    
    private function contentCheck($deskNum)
    { //글 확인
        $datas2 = $this->db->select(
            'mydesk', '*',
            array('desk_num' => $deskNum)
        );

        foreach ($datas2 as $data2) {
            $itemCon = new stdClass();
            $itemCon->desk_num = $data2['desk_num'];
            $itemCon->nickname = $data2['nickname'];
            $itemCon->job = $data2['job'];
            $itemCon->content = $data2['content'];
            $itemCon->file_copied = $data2['file_copied'];
        }
        return $itemCon;
    }
    
    private function replyCheck($deskNum)
    { //댓글 확인
        $datas3 = $this->db->select(
          'reply', '*',
          array('desk_num' => $deskNum),
          array('ORDER' => array('reply_num' => 'DESC'))
        );
        
        foreach ($datas3 as $data3) {
            if ($data3) {
                $itemRep = new stdClass();
                $itemRep->reply_num = $data3['reply_num'];
                $itemRep->desk_num = $data3['desk_num'];
                $itemRep->email = $data3['email'];
                $itemRep->nickname = $data3['nickname'];
                $itemRep->content = $data3['content'];
                $itemRep->regist_day = $data3['regist_day'];
                $itemRepA[] = $itemRep;
            }
        }
        
        if (isset($itemRepA)) {
            return $itemRepA;
        } else {
            return false;
        }
    }
    
    private function userCheck($deskNum, $userId)
    { //글쓴이 확인
        $datas4 = $this->db->get(
            'mydesk', 'email',
            array('AND' => array('email' => $userId, 'desk_num' => $deskNum))
        );

        if ($datas4) {
            return true;
        } else {
            return false;
        }
    }
    
    public function read($deskNum, $userId)
    { //글 읽기
        $returnArray1 = $this->contentCheck($deskNum);
        $returnArray2 = $this->replyCheck($deskNum);
        $returnArray3 = $this->userCheck($deskNum, $userId);
        $returnArray = array($returnArray1, $returnArray2, $returnArray3);
        return $returnArray;
    }
    
    public function readRand($userId)
    { //램덤 글 읽기
        $randNum = $this->randomCheck();
        if ($randNum === false) {
            return false;
        } else {
            $returnArray1 = $this->contentCheck($randNum);
            $returnArray2 = $this->replyCheck($randNum);
            $returnArray3 = $this->userCheck($randNum, $userId);
            $returnArray = array($returnArray1, $returnArray2, $returnArray3);
            return $returnArray;
        }
    }
}
?>