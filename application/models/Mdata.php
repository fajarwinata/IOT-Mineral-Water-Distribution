<?php
class Mdata extends CI_Model{

    function siswa($id){
      if($id == "") return $this->db->get("mod_students");
      else return $this->db->get_where("mod_students", array("id_stud" => $id));
    }

    function kelas($id){
      if($id == "") return $this->db->get("conf_class");
      else return $this->db->get_where("conf_class", array("id_class" => $id));
    }

    function sekolah($id){
       return $this->db->get_where("conf_school", array("id_school" => $id));
    }

}
