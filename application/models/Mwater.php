<?php
class Mwater extends CI_Model{
    function water_log(){
      if($this->session->userdata("level") == "siswa"){
        return $this->db->get_where("log_access", array("id_stud" => $this->session->userdata("sess_id"), "log_date" => date("Y-m-d")));
      } else {
        return $this->db->get_where("log_access", array("log_date" => date("Y-m-d")));
      }
    }
}
