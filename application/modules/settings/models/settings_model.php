<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Settings_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function getSettings(){
        $q = $this->db->get_where('settings',array('id'=>1));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function updateSetting($data = array()){
        $this->db->where('id',1);
        if($this->db->update('settings',$data)){
            return true;
        }
        return false;
    }
}
?>