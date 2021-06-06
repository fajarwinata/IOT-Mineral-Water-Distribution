<?php
class Mlog extends CI_Model{

    function user_check($username,$pass,$level){
      switch($level){
        case 'admin':
          $table = "mod_users";
          $id    = "user";
        break;
        case 'siswa':
          $table = "mod_students";
          $id    = "stud";
        break;
      }

      return $this->db->get_where($table, array("id_$id" => $username, "pass_$id" => $pass));
    }
}
