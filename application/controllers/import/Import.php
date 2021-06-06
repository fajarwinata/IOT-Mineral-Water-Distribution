<?php
class Import extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model(array('mwater','mimport'));
  }
  public function siswa(){
     include APPPATH.'third_party/PHPExcel/PHPExcel.php';

     $excelreader = new PHPExcel_Reader_Excel2007();
     $loadexcel = $excelreader->load('temp/temp_import.xlsx');
     $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

     $data = array();

     $numrow = 1;
     $no=0;
     foreach($sheet as $row){
       if(empty($row['A']) && empty($row['B'])&&empty($row['C']) && empty($row['D'])&&empty($row['E']) && empty($row['F']))
          continue;

       if($numrow > 1){
         $password   = date("Ymd", strtotime($row['F']));
         $indate    = date("Y-m-d", strtotime($row['F']));
         $id_stud   = $row['B'];

         $get_balance = $this->mwater->water_balance($row['A']);

         ($get_balance->num_rows() > 0) ? $balance = $get_balance->row()->lim_member : $balance = 0;

         // Kita push (add) array data ke variabel data
         array_push($data, array(
           'id_stud'=> $id_stud, // Insert data nis dari kolom A di excel
           'nis_stud'=>$id_stud, // Insert data nama dari kolom B di excel
           'nisn_stud'=> $row['C'],
           'nm_stud'=>$row['D'],
           'rfid_stud'=>0,
           'pass_stud'=>md5($id_stud),
           'balance_stud'=> $balance,
           'id_class'=>$row['A']
         ));
       }
       $no++;
       $numrow++; // Tambah 1 setiap kali looping
     }
     $this->mimport->insert_multiple($data);
     redirect(base_url("?q=".base64_encode("master")."&md=".base64_encode("siswa"))); // Redirect ke halaman awal (ke controller siswa fungsi index)
  }


  public function kelas(){
     include APPPATH.'third_party/PHPExcel/PHPExcel.php';

     $excelreader = new PHPExcel_Reader_Excel2007();
     $loadexcel = $excelreader->load('temp/temp_import.xlsx');
     $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

     $data = array();

     $numrow = 1;
     $no=0;
     foreach($sheet as $row){
       if(empty($row['A']) && empty($row['B'])&&empty($row['C']) && empty($row['D']))
          continue;

       if($numrow > 1){

         // Kita push (add) array data ke variabel data
         array_push($data, array(
           'id_class'=> $row['A'], // Insert data nis dari kolom A di excel
           'nm_class'=> $row['B'], // Insert data nama dari kolom B di excel
           'lim_member'=> $row['C'], // Insert data nama dari kolom B di excel
           'id_school'=> $row['D']
         ));
       }
       $no++;
       $numrow++; // Tambah 1 setiap kali looping
     }
     $this->mimport->insert_class($data);
     redirect(base_url("?q=".base64_encode("config")."&sq=".base64_encode("kelas"))); // Redirect ke halaman awal (ke controller siswa fungsi index)
  }

}
