<?php

include '../lib/BaseValidation.php';

class VoteValidation extends BaseValidation 
{

    function __construct() 
    {
        parent::__construct();
    }
    
    private function voteCheck($deskNum, $userId) 
    { //추천 확인
        $datas = $this->db->select(
            'vote', '*',
            array('AND' => array('desk_num' => $deskNum, 'user_id' => $userId))
        );
        
        if ($datas) {
            return true;
        } else {
            return false;
        }
    }
    
    private function insertVote($deskNum, $userId, $registDay) 
    { //추천처리
        $this->db->insert(
            'vote',
            array(
                'desk_num' => $deskNum,
                'user_id' => $userId,
                'regist_day' => $registDay
            )
        );
        
        $this->db->update(
            'mydesk', 
            array('vote_good[+]' => 1), 
            array('desk_num' => $deskNum)
        );
    }
    
    public function voteCount($deskNum, $userId, $registDay) 
    { //추천
        if ($this->voteCheck ($deskNum, $userId) === true) {
            $item = "이미 추천하셨습니다";
        } else {
            $this->insertVote ($deskNum, $userId, $registDay);
            
            $datas2 = $this->db->select(
                'mydesk', "*",
                array('desk_num' => $deskNum)
            );
            
            foreach ($datas2 as $data2) {
                if ($data2) {
                    $item = new stdClass();
                    $item->desk_num = $data2['desk_num'];
                    $item->vote_good = $data2['vote_good'];
                }
            }        
        }
        return $item;
    }    
}

?>