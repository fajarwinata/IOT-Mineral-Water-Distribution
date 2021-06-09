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

	//SISWA
	function siswa_update(){
		$id 	= $this->input->post('id');
		$nis 	= $this->input->post('nis');
		$nisn = $this->input->post('nisn');
		$nama = $this->input->post('nama');
		$rfid = $this->input->post('rfid');
		$pass = md5($this->input->post('pass'));
		$kelas= $this->input->post('kelas');

		if(strlen($pass) > 0)
			$data = array(
				"nisn_stud" => $nisn,
				"nm_stud" 	=> $nama,
				"rfid_stud" => $rfid,
				"pass_stud" => $pass,
				"id_class"  => $kelas
			);
		else
		$data = array(
			"nisn_stud" => $nisn,
			"nm_stud" 	=> $nama,
			"rfid_stud" => $rfid,
			"id_class"  => $kelas
		);
		$where = array("id_stud" => $id);

		$update = $this->mdata->siswa_update($data, $where);

		if($update)
			$response = array(
				"status" => "1",
				"message" => "Data Berhasil diperbaharui"
			);
		else
		$response = array(
			"status" => "0",
			"message" => "Data Gagal Diperbaharui"
		);

		echo json_encode($response);
	}

	function siswa_delete(){
		if($this->input->get('row') == "true"){
			$data = $this->input->post('id');
			$no = 1;
			foreach (json_decode($data) as $id) {
				$where = array("id_stud" => $id);
				$delete = $this->mdata->siswa_delete($where);

				if($delete)
				$response = array(
					"status" => "1",
					"message" => "Data Berhasil dihapus"
				);
				else{
					$response = array(
						"status" => "0",
						"message" => "Data $no Ke-Gagal Dihapus"
					);
					break;
				}
				$no++;
			}


		} else {
			$id 	= $this->input->post('id');

			$where = array("id_stud" => $id);

			$delete = $this->mdata->siswa_delete($where);

			if($delete)
			$response = array(
				"status" => "1",
				"message" => "Data Berhasil dihapus"
			);
			else
			$response = array(
				"status" => "0",
				"message" => "Data Gagal Dihapus"
			);
		}

		echo json_encode($response);
	}

	function siswa_insert(){
		if($this->input->get('cek_nis')){
			$cek = $this->mdata->siswa($this->input->post('nis'))->num_rows();
			if($cek >0)
				$response = array(
					"status" => "0",
					"message" => "NIS Sudah digunakan"
				);
			else
			$response = array(
				"status" => "1",
				"message" => "NIS Tersedia"
			);

				echo json_encode($response);
		} else {
			$nis 	= $this->input->post('nis');
			$nisn = $this->input->post('nisn');
			$nama = $this->input->post('nama');
			$rfid = $this->input->post('rfid');
			$pass = md5($this->input->post('pass'));
			$kelas= $this->input->post('kelas');
			$bal 	= $this->mdata->kelas($kelas)->row();
			$bal 	= $bal->lim_member;

				$data = array(
					"id_stud" 	=> $nis,
					"nis_stud" 	=> $nis,
					"nisn_stud" => $nisn,
					"nm_stud" 	=> $nama,
					"rfid_stud" => $rfid,
					"pass_stud" => $pass,
					"balance_stud" => $bal,
					"id_class"  => $kelas
				);

			$insert = $this->mdata->siswa_insert($data);

			if($insert)
				$response = array(
					"status" => "1",
					"message" => "Data Berhasil ditambahkan"
				);
			else
			$response = array(
				"status" => "0",
				"message" => "Data Gagal ditambahkan"
			);

			echo json_encode($response);
		}
	}
	//ADMIN
	function admin_delete(){
		//VALIDASI KHUSUS
		$cek = $this->mdata->admin()->num_rows();
		if($cek > 1){
			if($this->input->get('row') == "true"){
				$data = $this->input->post('id');
				$no = 1;
				foreach (json_decode($data) as $id) {
					$where = array("id_user" => $id);
					$delete = $this->mdata->admin_delete($where);

					if($delete)
					$response = array(
						"status" => "1",
						"message" => "Data Berhasil dihapus"
					);
					else{
						$response = array(
							"status" => "0",
							"message" => "Data $no Ke-Gagal Dihapus"
						);
						break;
					}
					$no++;
				}
			} else {
				$id 	= $this->input->post('id');

				$where = array("id_user" => $id);

				$delete = $this->mdata->admin_delete($where);

				if($delete)
				$response = array(
					"status" => "1",
					"message" => "Data Berhasil dihapus"
				);
				else
				$response = array(
					"status" => "0",
					"message" => "Data Gagal Dihapus"
				);
			}
		} else {
			$response = array(
				"status" => "0",
				"message" => "Admin minimal ada 1, Data Gagal Dihapus"
			);
		}

		echo json_encode($response);
	}
}
