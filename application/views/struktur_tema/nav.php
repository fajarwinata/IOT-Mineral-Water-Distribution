<div id="sidebar-nav" class="sidebar" >
  <div class="sidebar-scroll" style="margin-top:20px">
    <nav>
      <ul class="nav">
        <?php
        if($this->session->userdata("sess_level") != "siswa"){
          $link = array("dashboard","master","transaksi","config","mesin");
          $menu = array("Beranda","Data Master","Transaksi","Konfigurasi","Mesin");
          $icon = array("home","file-empty","dice","code","cog");
          for($i = 0; $i < 5; $i++){
            (base64_decode($this->input->get("q")) == $link[$i]) ? $class = "active" : $class= "";
            if($link[$i] == "config"){
              ($this->input->get('sq')) ? $collapse = "in" : $collapse = "";
              echo "<li>
              <a href=\"#config\" data-toggle=\"collapse\" class=\"collapsed $class\"><i class=\"lnr lnr-".$icon[$i]."\"></i> <span>".$menu[$i]."</span></a>
              <div id=\"config\" class=\"collapse $collapse\">
              <ul class=\"nav\">
              <li><a href=\"?q=".base64_encode($link[$i])."&sq=".base64_encode("sekolah")."\" class=\"\">Sekolah</a></li>
              <li><a href=\"?q=".base64_encode($link[$i])."&sq=".base64_encode("kelas")."\" class=\"\">Kelas</a></li>
              </ul>
              </div>
              </li>
              ";
            } else if($link[$i] == "master"){
              ($this->input->get('md')) ? $collapse = "in" : $collapse = "";
              echo "<li>
              <a href=\"#masterData\" data-toggle=\"collapse\" class=\"collapsed $class\"><i class=\"lnr lnr-".$icon[$i]."\"></i> <span>".$menu[$i]."</span></a>
              <div id=\"masterData\" class=\"collapse $collapse\">
              <ul class=\"nav\">
              <li><a href=\"?q=".base64_encode($link[$i])."&md=".base64_encode("siswa")."\" class=\"\">Siswa</a></li>
              <li><a href=\"?q=".base64_encode($link[$i])."&md=".base64_encode("admin")."\" class=\"\">Admin</a></li>
              </ul>
              </div>
              </li>
              ";
            } else {
              echo "<li><a href=\"?q=".base64_encode($link[$i])."\" class=\"$class\"><i class=\"lnr lnr-".$icon[$i]."\"></i> <span>".$menu[$i]."</span></a></li>";
            }

          }
        }
        ?>
      </ul>
    </nav>
  </div>
</div>
