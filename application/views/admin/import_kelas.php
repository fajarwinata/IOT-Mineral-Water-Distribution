<div class="main">
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="container-fluid">
      <h3 class="page-title"><i class="fa fa-cogs"></i> Konfigurasi</h3>
      <div class="pull-right" style="margin-top: -60px">
        <a class="btn btn-danger update-pro" href="<?= "?q=".base64_encode('config')."&sq=".base64_encode('kelas') ?>" title="Kembali" ><i class="fa fa-close"></i> <span>Batal</span></a>
      </div>
        <?php
        if(isset($_POST['preview'])){
          $filename = "temp_import"; //nama file IMPORT
          $upload = $this->mimport->upload_file("temp_import");

        if($upload['result'] == "success"){ // Jika proses upload sukses
          // Load plugin PHPExcel nya
          include APPPATH.'third_party/PHPExcel/PHPExcel.php';

          $excelreader = new PHPExcel_Reader_Excel2007();
          $loadexcel = $excelreader->load('temp/temp_import.xlsx'); // Load file yang tadi diupload ke folder

          $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

          // Buat sebuah tag form untuk proses import data ke database
          echo"<div class=\"row\">
            <div class=\"col-md-12\">
              <!-- BASIC TABLE -->
              <div class=\"panel\">
                <div class=\"panel-heading\">
                  <h3 class=\"panel-title\"><i class=\"fa fa-upload\"></i>Import Data Kelas</h3>
                </div>
                <div class=\"panel-body\">
                <p align='center'>*Pastikan tidak terdapat data kosong pada kolom Kode Kelas, karena bersifat Primary Key</p>";
          echo "<form method='post' action='".base_url("import/import/kelas")."'>";

          // Buat sebuah div untuk alert validasi kosong
          echo "
          <table id='import' class='table table-striped col-md-12'>
          <thead>
            <tr>
                <th width='5%'>No</th>
                <th>ID Kelas</th>
                <th>Nama Kelas</th>
                <th>Limit (ml/Siswa)</th>
                <th width='5%'>Sekolah</th>
            </tr>
          </thead>
          <tbody>";

          $numrow = 1;
          $no = 0;
          $class = 0;
          foreach($sheet as $row){
              if(empty($row['A']) && empty($row['B'])&&empty($row['C']) && empty($row['D']))
                continue;

              if($numrow > 1){
                $get_school = $this->mdata->sekolah($row['D']);
                if($get_school->num_rows() > 0) {
                  $badge = "<span class=\"badge bg-success\">".$get_school->row()->nm_school."</span>";
                  $class += 1;
                }
                else{
                  $class += 0;
                  $badge = "<span class=\"badge bg-danger\">Kode Sekolah Tidak Sesuai </span>";
                }

                  echo "<tr>";
                  echo "<td>".$no."</td>";
                  echo "<td>".$row['A']."</td>";
                  echo "<td>".$row['B']."</td>";
                  echo "<td>".$row['C']." ml</td>";
                  echo "<td>$badge</td>";
                  echo "</tr>";
              }
              $no++;
              $numrow++; // Tambah 1 setiap kali looping
          }

          echo "</tbody>
          </table>";
              echo "<hr>";
              if($class  == $no-1){
                echo "<button type='submit' class='col-md-8 btn btn-primary' name='import'><i class='fa fa-save' ></i> Import ($class Data)</button>";
              } else {
                $total_kurang = $no-$class;
                echo "<a class='col-md-8 btn btn-default' name='import' onclick=\"alert('Perbaiki Data Sekolah Terlebih Dahulu')\"><i class='fa fa-warning'></i> $total_kurang Kode Sekolah Tidak Cocok </a>";
              }
              // Buat sebuah tombol untuk mengimport data ke database
              echo "<a class='btn btn-danger col-md-4' href='?q=".base64_encode('config')."&sq=".base64_encode('kelas')."'><i class='fa fa-close' ></i> Batalkan</a>";

          echo "</form>
              </div>
            </div>
          </div>
          ";

        }else{ // Jika proses upload gagal
        ?>
        <div class="alert  alert-danger alert-dismissible fade show" role="alert">
              <span class="badge badge-pill badge-danger">GAGAL PREVIEW</span> <?= $upload_error ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">??</span>
                </button>
            </div>
            <br>
            <button onclick="window.history.back()" type="button" class="btn btn-info">
                    Kembali
                </button>
        <?php
        }
        } else { ?>
        <form method="post" action="<?= "?q=".base64_encode("import_kelas") ?>" enctype="multipart/form-data">
                            <div class="file-upload col-md-12">
                              <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Tambahkan File Excel</button>

                              <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name="file" onchange="readURL(this);" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
                                <div class="drag-text">
                                  <h3>Pilih file Excel</h3>
                                </div>
                              </div>
                              <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                  <input type="hidden" name="type" value="<?= base64_encode("siswa") ?>">
                                  <button class="btn btn-success importar" type="submit" name="preview">PREVIEW</button>
                                  <!-- <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button> -->
                                </div>
                              </div>
                            </div>
        </form>
        <?php
        }
        ?>
    </div>
  </div>
</div>
