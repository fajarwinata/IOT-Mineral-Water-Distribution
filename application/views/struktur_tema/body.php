<?php
  $total_waterlog = $wlog->num_rows();
 ?>
<div id="wrapper">
  <!-- NAVBAR -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
      <a href="index.html"><img src="assets/img/logo-dark.png" alt="Sidiam Logo" class="img-responsive logo"></a>
    </div>
    <div class="container-fluid">
      <div class="navbar-btn">
        <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
      </div>
      <form class="navbar-form navbar-left">
        <div class="input-group">
          <input type="text" value="" class="form-control" placeholder="Cari Siswa...">
          <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
        </div>
      </form>
      <?php if($this->session->userdata("sess_level") == "ADM"){
        echo "<div class=\"navbar-btn navbar-btn-right\">
        <a class=\"btn btn-success update-pro\" href=\"#\" title=\"Data Mesin\" ><i class=\"fa fa-gear\"></i> <span>Mesin Air</span></a>
        </div>";
      } ?>

      <div id="navbar-menu">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
              <i class="lnr lnr-alarm"></i>
              <span class="badge bg-danger"><?= $total_waterlog ?></span>
            </a>
            <ul class="dropdown-menu notifications">
              <?php
              if($total_waterlog > 0){
                foreach ($wlog->result() as $logdata):
                  ($logdata->acc_status == "SUCCESS")? $status = "success" : $status = "danger";
                  echo "<li><a href=\"#\" class=\"notification-item\"><span class=\"dot bg-$status\"></span>[".$logdata->id_stud."] ".$logdata->acc_type." ".$logdata->acc_balance." ml. </a></li>";
                endforeach;
              } else {
                echo "<li><a href=\"#\" class=\"notification-item\"><span class=\"dot bg-info\"></span>Tidak ada Aktivitas hari ini</a></li>";
              }
              ?>
              <li><a href="#" class="more">Lihat Seluruh Transaksi</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar"> <span><?= $this->session->userdata("sess_name")?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#"><i class="lnr lnr-cog"></i>Level: <span><?= $this->session->userdata("sess_level")?></span></a></li>
              <li><a href="#"><i class="lnr lnr-user"></i> <span>Profil</span></a></li>
              <li><a href="<?= site_url('cas/log/logout') ?>"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
            </ul>
          </li>
          <!-- <li>
            <a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
          </li> -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- END NAVBAR -->
  <!-- LEFT SIDEBAR -->

  <!-- END LEFT SIDEBAR -->
  <!-- MAIN -->
  <?php
  $this->load->view('struktur_tema/nav.php');
  if($this->session->userdata("level") == "siswa"){
    echo "siswa";
    // $this->load->view('admin/page.php');
  } else {

    if($this->input->get("md"))
      $page = base64_decode($this->input->get("q"))."_".base64_decode($this->input->get("md"));
    else if($this->input->get("sq"))
      $page = base64_decode($this->input->get("q"))."_".base64_decode($this->input->get("sq"));
    else if($this->input->get("q"))
      $page = base64_decode($this->input->get("q"));
    else
      $page = "dashboard";
      if(file_exists(APPPATH."views/admin/$page.php"))
        $this->load->view("admin/$page");
      else{
        echo "<link rel=\"stylesheet\" href=\"assets/css/error.css\">";
        
        $this->load->view("errors/html/error_404");
        echo "<script src=\"assets/scripts/error.js\"></script>";
      }

  }
  ?>
  <!-- END MAIN -->
  <div class="clearfix"></div>
  <footer>
    <div class="container-fluid">
      <p class="copyright">&copy; <?= date("Y") ?> <a href="#" target="_blank">SMK Merdeka Bandung</a>. All Rights Reserved.</p>
    </div>
  </footer>
</div>
