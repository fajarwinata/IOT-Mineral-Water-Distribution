<?php
class Preview extends CI_Controller{
  public function siswa(){
    $data = array(); // Buat variabel $data sebagai array

    if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
      // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php

          $upload = $this->m_import->upload_file($this->filename);

      if($upload['result'] == "success"){ // Jika proses upload sukses
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('temp/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder

        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

        // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
        // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
        $data['sheet'] = $sheet;
      }else{ // Jika proses upload gagal
        //echo "<script>alert('".$upload['error']."'); location.replace('".base_url('Panitia/import1')."');</script>";
        $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
      }
    }

    $this->load->view('privateroom/header');
        switch($this->input->post('type')){
      case base64_encode("peserta"):
          $this->load->view('panitia/import1', $data);
          break;
          case base64_encode("rombel"):
          $this->load->view('panitia/import2', $data);
          break;
          case base64_encode("kompetensi"):
          $this->load->view('panitia/import3', $data);
          break;
          case base64_encode("program"):
          $this->load->view('panitia/import4', $data);
          break;
          case base64_encode("nilai"):
          $this->load->view('panitia/import5', $data);
          break;
          case base64_encode("nilai_detail"):
          $this->load->view('panitia/import6', $data);
          break;
          default:
          echo "<script>alert('ERROR !');
                  location.replace('".base_url('Panitia')."');</script>";
          break;
    }
  }
}
