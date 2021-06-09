<?php
class Mwater extends CI_Model{
    function water_log(){
      if($this->session->userdata("level") == "siswa"){
        return $this->db->get_where("log_access", array("id_stud" => $this->session->userdata("sess_id"), "log_date" => date("Y-m-d")));
      } else {
        return $this->db->get_where("log_access", array("log_date" => date("Y-m-d")));
      }
    }

    function water_log_error(){
      if($this->session->userdata("level") == "siswa"){
        return $this->db->get_where("log_access", array("id_stud" => $this->session->userdata("sess_id"), "acc_status" => "FAILED"));
      } else {
        return $this->db->get_where("log_access", array("acc_status" => "FAILED"));
      }
    }

    function water_balance($id_class){
        return $this->db->get_where("conf_class", array("id_class" => $id_class));
    }
}
