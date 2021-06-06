<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mimport extends CI_Model {
    public function view(){
        return $this->db->get('siswa')->result(); // Tampilkan semua data yang ada di tabel siswa
    }

    // Fungsi untuk melakukan proses upload file
    public function upload_file($filename){
        $this->load->library('upload'); // Load librari upload

        $config['upload_path'] = FCPATH.'temp/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '2048';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    // Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
    public function insert_multiple($data){
        $this->db->empty_table('mod_students');
        $proses = $this->db->insert_batch('mod_students', $data);

    }

    public function insert_multiple_nilai($data){
        $this->db->empty_table('m_peserta_nilai_rekap');
        $proses = $this->db->insert_batch('m_peserta_nilai_rekap', $data);

    }

    public function insert_multiple_nilai2($data){
        $this->db->empty_table('m_peserta_nilai_detil');
        $proses = $this->db->insert_batch('m_peserta_nilai_detil', $data);

    }

    public function insert_class($data){
        $this->db->empty_table('conf_class');
        $proses = $this->db->insert_batch('conf_class', $data);

    }

    public function insert_kompetensi($data){
        $this->db->empty_table('m_paket');
        $proses = $this->db->insert_batch('m_paket', $data);

    }

    public function insert_program($data){
        $this->db->empty_table('m_program');
        $proses = $this->db->insert_batch('m_program', $data);

    }
}
