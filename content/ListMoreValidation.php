<?php
include '../lib/BaseValidation.php';

class ListMoreValidation extends BaseValidation 
{
    function __construct() 
    {
        parent::__construct();
    }
    
    private function listMoreCheck($moreNum, $userMail) 
    {
        $datas = $this->db->select(
            'mydesk',
            array('email', 'desk_num', 'nickname', 'file_thumb', 'vote_good'),
            array('desk_num[<]' => $moreNum, 'ORDER' => array('desk_num' => 'DESC'), 'LIMIT' => 8)
        );

        foreach ($datas as $data) {
            $item = new stdClass();
            $item->desk_num = $data['desk_num'];
            $item->email = $data['email'];
            $item->nickname = $data['nickname'];
            $item->file_thumb = $data['file_thumb'];
            $item->vote_good = $data['vote_good'];
                
            $datas2 = $this->db->get(
                'vote',
                'vote_num',
                array('AND' => array('desk_num' => $data['desk_num'], 'user_id' => $userMail))
            );

            if ($datas2) {
                $item->hasVote = true;
            } else {
                $item->hasVote = false;
            }
                
            $items[] = $item;
            $lastItem = end($items);
        } // end foreach
        $resultArray1 = array($items, $lastItem);

        return $resultArray1;
    }

    private function hashMoreCheck($lastItem) 
    {
        
        $datas3 = $this->db->count(
            'mydesk',
            array('desk_num[<]' => ($lastItem->desk_num))
        );
        
        if ($datas3 > 0) {
            $hasMore = true;
        } else {
            $hasMore = false;
        }
        return $hasMore;
    }
    
    public function listMore($moreNum, $userMail) 
    {
       $resultArray1 = $this->listMoreCheck($moreNum, $userMail);
       
       if ($resultArray1) {                  
           $resultArray2 = $this->hashMoreCheck($resultArray1[1]);
           $resultArray = array ( $resultArray1[0], $resultArray2);
       }       
       return $resultArray;
    }    
}
?>