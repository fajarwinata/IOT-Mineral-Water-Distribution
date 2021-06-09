<?php
if($this->input->get('id')){
  $siswa = $this->mdata->siswa($this->input->get('id'))->row();
  $kelas = $this->mdata->kelas($siswa->id_class)->row();
  $credit= $kelas->lim_member-$siswa->balance_stud;
  $persen= ($kelas->lim_member-$siswa->balance_stud)/$kelas->lim_member*100;
  //
 ?>
<div class="main">
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="container-fluid">
      <div class="panel panel-profile">
        <div class="clearfix">
          <!-- LEFT COLUMN -->
          <div class="profile-left">
            <!-- PROFILE HEADER -->
            <div class="profile-header">
              <div class="overlay"></div>
              <div class="profile-main">
                <img src="assets/img/student.jpg" width="90px" class="img-circle" alt="Avatar">
                <h3 class="name"><?= $siswa->nm_stud ?></h3>
                <span class="online-status status-available">NISN: <?= $siswa->nisn_stud ?></span>
              </div>
              <div class="profile-stat">
                <div class="row">
                  <div class="col-md-4 stat-item">
                    <?= $siswa->balance_stud ?> ml<span>Saldo Air</span>
                  </div>
                  <div class="col-md-4 stat-item">
                    <?= $credit ?> ml<span>Debit(hari ini)</span>
                  </div>
                  <div class="col-md-4 stat-item">
                    <?= $persen ?>% <span>Konsumsi</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- END PROFILE HEADER -->
            <!-- PROFILE DETAIL -->
            <div class="profile-detail">
              <div class="profile-info" id="loading">
                <h4 class="heading"><i class="fa fa-user"></i> Ubah Profil</h4>
                <div class="clearfix"></div><hr>

                <form id="profil_siswa" autocomplete="off">
                  <div class="form-group row">
                    <label for="id" class="col-md-4">ID Sistem</label>
                    <div class="col-md-8">
                      <input id="id" name="id" value="<?= $siswa->id_stud ?>" type="text" class="form-control text-right" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="nis" class="col-md-4">NIPD/NIS</label>
                    <div class="col-md-8">
                      <input id="nis" name="nis" value="<?= $siswa->nis_stud ?>" type="text" class="form-control text-right" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="nisn" class="col-md-4">NISN</label>
                    <div class="col-md-8">
                      <input id="nisn" name="nisn" value="<?= $siswa->nisn_stud ?>" type="text" class="form-control text-right">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="nama" class="col-md-4">Nama</label>
                    <div class="col-md-8">
                      <input id="nama" name="nama" value="<?= $siswa->nm_stud ?>" type="text" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfid" class="col-md-4">Nomor RFID</label>
                    <div class="col-md-8">
                      <input id="rfid" name="rfid" value="<?= $siswa->rfid_stud ?>" type="text" class="form-control text-right">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="password" class="col-md-4">Ganti Password</label>
                    <div class="col-md-8">
                      <input id="password"  name="pass" type="password" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="kelas" class="col-md-4">Kelas</label>
                    <div class="col-md-8">
                      <select id="kelas"  name="kelas" class="kelas form-control">
                        <?php
                          $all_class = $this->mdata->kelas("")->result();
                          foreach ($all_class as $class):
                            ($class->id_class == $siswa->id_class)? $select = "selected" : $select = "";
                            echo "<option value='".$class->id_class."' $select>".$class->nm_class."</option>";
                          endforeach;
                        ?>

                      </select>
                    </div>
                  </div>
              </div>
                <button id="update" type="submit" class="btn btn-primary col-md-6"><i class="fa fa-save"></i> Ubah Pofil</button>
                <button id="delete" type="button" class="btn btn-danger col-md-6"><i class="fa fa-trash"></i> Hapus Data</button>

            </form>
            </div>
            <!-- END PROFILE DETAIL -->

          </div>
          <!-- END LEFT COLUMN -->
          <!-- RIGHT COLUMN -->
          <div class="profile-right">
            <h4 class="heading"><?= "[".$siswa->nis_stud."] ".$siswa->nm_stud ?></h4>
            <div class="pull-right" style="margin-top: -60px">
              <a class="btn btn-info update-pro" onclick="location.reload()" title="reload" ><i class="fa fa-refresh fa-spin"></i> <span>Refresh</span></a>
              <a class="btn btn-danger update-pro" href="<?= "?q=".base64_encode('master')."&md=".base64_encode('siswa') ?>" title="Kembali" ><i class="fa fa-close"></i> <span>Kembali</span></a>
            </div>
            <!-- AWARDS -->
            <div class="awards">
              <!-- TRY WATER LEVEL -->
              <h4>Sisa Saldo air Hari ini: <?= 100-$persen ?> % (<?= $siswa->balance_stud ?> ml)</h4>
              <div class="chart col-md-12 ">
                <div class="bar bar-<?= 100-$persen ?> cyan">
                  <div class="face top">
                    <div class="growing-bar"></div>
                  </div>
                  <div class="face side-0">
                    <div class="growing-bar"></div>
                  </div>
                  <div class="face floor">
                    <div class="growing-bar"></div>
                  </div>
                  <div class="face side-a"></div>
                  <div class="face side-b"></div>
                  <div class="face side-1">
                    <div class="growing-bar"></div>
                  </div>
                </div>
              </div>
              <!--TRY WATER LEVEL-->
              <?php
              $waterlog = $this->mwater->water_log()->num_rows();
              $a = array_filter($this->mwater->water_log()->result());

              ?>
              <div class="row">
                <div class="col-md-3 col-sm-6">
                  <div class="award-item">
                    <div class="hexagon">
                      <span class="lnr lnr-database award-icon"></span>
                    </div>
                    <span>Total Transaksi:<br> <?= $waterlog ?> Log</span>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="award-item">
                    <div class="hexagon">
                      <span class="lnr lnr-drop award-icon"></span>
                    </div>
                    <span>Rata-rata Debit<br>
                      <?php
                      if(count($a)) echo $average = array_sum($a)/count($a);
                      else echo "0";
                       ?>
                       milli liter</span>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="award-item">
                    <div class="hexagon">
                      <span class="lnr lnr-file-empty award-icon"></span>
                    </div>
                    <span>No. RFID:<br> <?= $siswa->rfid_stud ?></span>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="award-item">
                    <div class="hexagon">
                      <span class="lnr lnr-apartment award-icon"></span>
                    </div>
                    <span>Kelas: <br><?= $kelas->nm_class ?></span>
                  </div>
                </div>
              </div>

              <!-- <div class="text-center"><a href="#" class="btn btn-default">-</a></div> -->
            </div>
            <!-- END AWARDS -->
            <!-- TABBED CONTENT -->
            <?php
            $log       = $this->mwater->water_log();
            $log_error = $this->mwater->water_log_error();
            ?>
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
              <ul class="nav" role="tablist">
                <li class="active"><a href="#tab-bottom-left1" role="tab" data-toggle="tab">Aktifitas Terakhir </a></li>
                <li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Aktifitas Gagal  <span class="badge bg-danger"><?= $log_error->num_rows() ?></span></a></li>
              </ul>
            </div>
            <div class="tab-content">
              <div class="tab-pane fade in active" id="tab-bottom-left1">
                <ul class="list-unstyled activity-timeline">
                  <?php
                  if($log->num_rows() > 0){
                      foreach ($log->result() as $data_log):
                        echo "
                        <li>
                        <i class=\"fa fa-tint activity-icon\"></i>
                        <p>[DEBET] Sebanyak <a href=\"#\">200 ml</a> <span class=\"badge bg-success\">SUKSES</span> <span class=\"timestamp\">2 minutes ago</span></p>
                        </li>";
                      endforeach;
                  } else {
                    echo "
                    <li>
                    <i class=\"fa fa-database activity-icon\"></i>
                    <p>[NO DATA] Belum Ada Transaksi Hari ini <a href=\"#\">#</a></p>
                    </li>";
                  }
                   ?>


                </ul>
                <!-- <div class="margin-top-30 text-center"><a onclick="belum_ada()" class="btn btn-default">Lihat Semua Aktifitas</a></div> -->
              </div>
              <div class="tab-pane fade" id="tab-bottom-left2">
                <div class="table-responsive">
                  <table class="table project-table">
                    <thead>
                      <tr>
                        <th>Kode Log</th>
                        <th>Id Siswa</th>
                        <th>Tanggal & Waktu</th>
                        <th>Balance</th>
                        <th>Tipe Transaksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($log_error->num_rows() > 0){
                          foreach ($log_error->result() as $data_log):
                       ?>
                          <tr>
                            <td><a href="#"><?= $data_log->id_log ?></a></td>
                            <td>
                              <?= $data_log->id_stud ?>
                            </td>
                            <td><?= $data_log->log_date." ".$data_log->log_time ?></td>
                            <td><?= $data_log->acc_type ?></td>
                          </tr>
                      <?php
                          endforeach;
                        }
                       ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- END TABBED CONTENT -->
          </div>
          <!-- END RIGHT COLUMN -->
        </div>
      </div>
    </div>
  </div>
  <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<div class="clearfix"></div>
<?php
} else {
  ?>
  <div id="error_detail"></div>
<?php } ?>
