<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Central Authentication System
//BACKEND RESPONSE

class Log extends CI_Controller {
  function login(){
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $level    = $this->input->post('level');

    //1. Check_All_Request
    if(strlen($username) > 0 && strlen($password) > 0 && strlen($level) > 0){
      //2. Check_user
      $check = $this->logsys->user_check($username,$password,$level);
      if($check->num_rows() > 0){
        $user_data  = $check->row();
        if($level == "admin"){
          $nama       = $user_data->nm_user;
          $level      = $user_data->level;
        } else {
          $nama       = $user_data->nm_stud;
          $level      = "siswa";
        }

          $sess_data  = array(
            "sess_id"   => $username,
            "sess_name" => $nama,
            "sess_level"=> $level,
            "sess_status"=> "ONLINE"
          );
        $this->session->set_userdata($sess_data);
        $response = array("status" => 1, "message" => "SUCCESS");
      }
      else $response = array("status" => 0, "message" => "User ID / Password salah!");
    } else {
      $response = array("status" => 0, "message" => "Error, data yang dikirmkan tidak sesuai");
    }

      echo json_encode($response);
  }

  function logout(){
    $this->session->sess_destroy();
    redirect(base_url());
  }

}
