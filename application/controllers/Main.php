<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->model(array("mwater","mimport","mdata"));
	}

	public function index()
	{
		$this->load->view('struktur_tema/header');
		if($this->session->userdata('sess_status') == "ONLINE"){
			$data = array("wlog" => $this->mwater->water_log());
			$this->load->view('struktur_tema/body', $data);
		}
		else
			$this->load->view('login');
		$this->load->view('struktur_tema/footer');
	}
}
