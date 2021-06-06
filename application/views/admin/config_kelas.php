<div class="main">
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="container-fluid">
      <h3 class="page-title"><i class="fa fa-cogs"></i> Konfigurasi</h3>
      <div class="row">
        <div class="col-md-12">
          <!-- BASIC TABLE -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-university"></i> Kelas</h3>
              <div class="pull-right" style="margin-top: -20px">
                <a class="btn btn-info update-pro" href="?q=<?= base64_encode('import_kelas') ?>" title="IMPORT" ><i class="fa fa-file-excel-o"></i> <span>Import Data</span></a>
                <a class="btn btn-success update-pro" href="#" title="Tambah Data" ><i class="fa fa-plus"></i> <span>Tambah Data</span></a>
              </div>
            </div>
            <div class="panel-body">
              <table id="master_siswa" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID Kelas</th>
                    <th>Nama Kelas</th>
                    <th>Limit Harian (ml/Siswa)</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $this->mdata->kelas("");
                    if($data->num_rows() > 0){
                      $no = 1;
                      foreach ($data->result() as $kelas) {
                        $class = explode("/", $kelas->id_class);
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td>".$kelas->id_class."</td>";
                        echo "<td>".$kelas->nm_class."</td>";
                        echo "<td><input type='number' class='lim$class[1] form-control text-right' id='lim".$kelas->id_class."' value='".$kelas->lim_member."'> </td>";
                        echo "<td><button data-row='".$kelas->id_class."' class='ubahlimit btn btn-primary col-md-12'><i class='fa fa-pencil'></i> Ubah Limit</button></td>";
                        echo "</tr>";
                        $no++;
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
