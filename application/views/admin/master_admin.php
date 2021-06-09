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
              <h3 class="panel-title"><i class="fa fa-user-secret"></i> Admin/User (Adminsitrator)</h3>
              <div class="pull-right" style="margin-top: -20px">
                <a class="btn btn-success update-pro" type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> <span>Tambah Data</span></a>
              </div>
              <br>
            </div>
            <div id="btn_hapus" class="hapus"></div>
            <div class="panel-body">
              <table id="master_admin" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID Pengguna</th>
                    <th>Nama Pengguna</th>
                    <th>Password</th>
                    <th>Level</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $data = $this->mdata->admin();
                  if($data->num_rows() > 0){
                    $no = 1;
                    foreach ($data->result() as $admin) {
                      echo "<tr>";
                      echo "<td></td>";
                      echo "<td><input type='text' name='id_user' id='id_user' value='".$admin->id_user."' class='form-control ' readonly></td>";
                      echo "<td><input type='text' name='nm_user' id='nm_user' value='".$admin->nm_user."' class='form-control '></td>";
                      echo "<td><input type='text' name='pass_user' id='pass_user' class='form-control '></td>";
                      if($this->session->userdata('sess_level') == "ADM")
                      echo "<td class='text-center'>".$admin->level.", ubah:
                      <select name='level' class='form-control'>
                        <option value='ADM'>Admin Master</option>
                        <option value='MAN'>Manager</option>
                        <option value='SPV'>Supervisi</option>
                      </select></td>";
                      else
                      echo "<td class='text-center'>".$admin->level."</td>";
                      echo "<td>
                            <button class='ubah btn btn-primary col-md-12'><i class='fa fa-pencil'></i> Ubah</button>
                            <button data-row=\"".$admin->id_user."\" class='hapus btn btn-danger col-md-12'><i class='fa fa-trash'></i> Hapus</button>
                            </td>";
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
