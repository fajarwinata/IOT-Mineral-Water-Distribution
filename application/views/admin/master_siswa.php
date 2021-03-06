<div class="main">
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="container-fluid">
      <h3 class="page-title"><i class="fa fa-database"></i> Data Master</h3>
      <div class="row">
        <div class="col-md-12">
          <!-- BASIC TABLE -->
          <div class="panel" id="loading">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-users"></i> Peserta Didik (Siswa)</h3>
              <div class="pull-right" style="margin-top: -20px">
                <a class="btn btn-info update-pro" href="?q=<?= base64_encode('import_siswa') ?>" title="IMPORT" ><i class="fa fa-file-excel-o"></i> <span>Import Data</span></a>
                <a class="btn btn-success update-pro" type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> <span>Tambah Data</span></a>
              </div>
              <br>
              <p class="small col-md-8"><i class="fa fa-file"></i> Saldo/jatah air minum yang disediakan oleh sekolah akan di atur ulang ke pengaturan kelas setiap harinya.</p>
            </div>
            <div id="btn_hapus" class="hapus"></div>

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
                      $total = $this->mdata->kelas($siswa->id_class)->row();
                      $nm_kelas = $total->nm_class;
                      $total = ($total->lim_member-$siswa->balance_stud)/$total->lim_member*100;
                      $total = 100-$total;
                      if($total > 70 && $total <= 100) $progres ="success";
                      else if($total > 30 && $total <= 70) $progres  ="primary";
                      else if($total > 20 && $total <= 30) $progres  ="waring";
                      else if($total >= 0 && $total <= 20) $progres  ="danger";

                      echo "<tr>";
                      echo "<td></td>";
                      echo "<td>".$siswa->nis_stud."</td>";
                      echo "<td>".$siswa->nisn_stud."</td>";
                      echo "<td>".$siswa->nm_stud." <span class='badge bg-danger pull-right'> $nm_kelas </span></td>";
                      echo "<td class='text-center'>
                      ".$siswa->balance_stud." milli liter
                      <div class=\"progress\">
                      <div class=\"progress-bar progress-bar-$progres\" role=\"progressbar\" aria-valuenow=\"$total\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $total%;\">
                        <span>".$total."%</span>
                      </div></div>
                      </td>";
                      echo "<td><button onclick=\"location.replace('?q=".base64_encode('master_siswa_detil')."&id=".$siswa->id_stud."')\" class='btn btn-primary col-md-12'><i class='fa fa-search'></i> Detail</button></td>";
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

<!-- Tambah DataBaru -->
<!-- Modal -->
<div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="baru_siswa" autocomplete="off">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel"><i class ="fa fa-plus"></i> Tambah Data Baru</h3>

      </div>
      <div class="modal-body" id="loading">
        <!--FORM-->

            <div class="form-group row">
              <label for="nis" class="col-md-4">NIPD/NIS</label>
              <div class="col-md-8">
                <input id="nis" name="nis" placeholder="Contoh: 1819200001" type="text" class="form-control text-right" >
                <label id="nis_error" class="text-danger"></label>
              </div>
            </div>

            <div class="form-group row">
              <label for="nisn" class="col-md-4">NISN</label>
              <div class="col-md-8">
                <input id="nisn" name="nisn" value="0" placeholder="Contoh: 003001000101" type="text" class="form-control text-right">
              </div>
            </div>

            <div class="form-group row">
              <label for="nama" class="col-md-4">Nama</label>
              <div class="col-md-8">
                <input id="nama" name="nama" placeholder="Nama Lengkap" type="text" class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label for="rfid" class="col-md-4">Nomor RFID</label>
              <div class="col-md-8">
                <input id="rfid" name="rfid" value="0" placeholder="Tap Kartu atau masukan Nomor" type="text" class="form-control text-right">
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4">Password</label>
              <div class="col-md-8">
                <input id="pass"  name="pass" type="password" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="kelas" class="col-md-4">Kelas</label>
              <div class="col-md-8">
                <select id="kelas"  name="kelas" class="kelas form-control">
                  <?php
                    $all_class = $this->mdata->kelas("")->result();
                    foreach ($all_class as $class):

                      echo "<option value='".$class->id_class."'>".$class->nm_class."</option>";
                    endforeach;
                  ?>
                </select>
              </div>
            </div>
      <!--FORM-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="insert" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </div>
  </form>
  </div>
</div>
