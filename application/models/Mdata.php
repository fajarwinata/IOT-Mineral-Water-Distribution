<?php
class Mdata extends CI_Model{
    /*============= SISWA =====================*/
    //READ
    function siswa($id){
      if($id == "") return $this->db->get("mod_students");
      else return $this->db->get_where("mod_students", array("id_stud" => $id));
    }

    //UPDATE
    function siswa_update($data, $where){
      $this->db->set($data);
      $this->db->where($where);
      return $this->db->update("mod_students");
    }

    //CREATE
    function siswa_insert($data){
      return $this->db->insert("mod_students", $data);
    }

    //DELETE
    function siswa_delete($where){
      return $this->db->delete("mod_students", $where);
    }

    /*============= KELAS =====================*/
    function kelas($id){
      if($id == "") return $this->db->get("conf_class");
      else return $this->db->get_where("conf_class", array("id_class" => $id));
    }

    /*============= SEKOLAH =====================*/
    function sekolah($id){
       return $this->db->get_where("conf_school", array("id_school" => $id));
    }

    /*=================== SISTEM ADMIN =====================*/
    //READ
    function admin(){
       return $this->db->get("mod_users");
    }

    //UPDATE
    function admin_update($data, $where){
      $this->db->set($data);
      $this->db->where($where);
      return $this->db->update("mod_users");
    }

    //CREATE
    function admin_insert($data){
      return $this->db->insert("mod_users", $data);
    }

    //DELETE
    function admin_delete($where){
      return $this->db->delete("mod_users", $where);
    }

}
