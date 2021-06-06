<div class="main">
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="container-fluid">
      <h3 class="page-title"><i class="fa fa-database"></i> Data Master</h3>
      <div class="row">
        <div class="col-md-12">
          <!-- BASIC TABLE -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-users"></i> Peserta Didik (Siswa)</h3>
              <div class="pull-right" style="margin-top: -20px">
                <a class="btn btn-info update-pro" href="?q=<?= base64_encode('import_siswa') ?>" title="IMPORT" ><i class="fa fa-file-excel-o"></i> <span>Import Data</span></a>
                <a class="btn btn-success update-pro" href="#" title="Tambah Data" ><i class="fa fa-plus"></i> <span>Tambah Data</span></a>
              </div>
              <br>
              <p class="small col-md-8"><i class="fa fa-file"></i> Saldo/jatah air minum yang disediakan oleh sekolah akan di atur ulang ke pengaturan kelas setiap harinya.</p>
            </div>
            <div class="panel-body">
              <table id="master_siswa" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>NIPD</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Saldo Air (<?= date("d/m/y") ?>)</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $data = $this->mdata->siswa("");
                  if($data->num_rows() > 0){
                    $no = 1;
                    foreach ($data->result() as $siswa) {
                      echo "<tr>";
                      echo "<td></td>";
                      echo "<td>".$siswa->nis_stud."</td>";
                      echo "<td>".$siswa->nisn_stud."</td>";
                      echo "<td>".$siswa->nm_stud."</td>";
                      echo "<td class='text-center'>".$siswa->balance_stud." ml</td>";
                      echo "<td><button class='btn btn-primary col-md-12'><i class='fa fa-search'></i> Detail</button></td>";
                      echo "</tr>";

                    }
                  }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
          <!-- END BASIC TABLE -->
        </div>

      </div>
    </div>
  </div>
  <!-- END MAIN CONTENT -->
</div>
