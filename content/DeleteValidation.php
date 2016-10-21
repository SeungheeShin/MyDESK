<?php
include '../lib/BaseValidation.php';

class DeleteValidation extends BaseValidation 
{
    function __construct() 
    {
        parent::__construct();
    }
    
    private function deleteImage($deskNum) 
    {           
        $datas = $this->db->get(
            'mydesk', 
            array('file_copied', 'file_thumb'),
            array('desk_num' => $deskNum)
        );

        if ($datas) {
            $copiedName = $datas['file_copied'];
            $thumbName = $datas['file_thumb'];
            $copiedImgName = '../data/origin/'.$copiedName;
            $thumbImgName = '../data/thumbnails/'.$thumbName;
            
            if (file_exists($copiedImgName)) {
                @unlink($copiedImgName);
            }
            if (file_exists($thumbImgName)) {
                @unlink($thumbImgName);
            }
            return true;
        } else {                
            return false;
        }
    }
    
    private function deleteMydesk($deskNum) 
    {
        $datas = $this->db->delete(
            'mydesk',
            array('desk_num' => $deskNum)
        );
        return $datas;
    }
    
    private function deleteReply($deskNum) 
    {
        $datas = $this->db->delete(
            'reply',
            array('desk_num' => $deskNum)
        );
        return $datas;
    }
    
    private function deleteVote($deskNum) 
    {
        $datas = $this->db->delete(
            'vote',
            array('desk_num' => $deskNum)
        );
        return $datas;
    }
    
    public function delete($deskNum) 
    {
        if ($this->deleteImage($deskNum) === true) {
            $this->deleteMydesk($deskNum);
            $this->deleteReply($deskNum);
            $this->deleteVote($deskNum);
            return true;
        } else {
            return false;
        }
    }    
}
?>