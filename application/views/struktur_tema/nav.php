<div id="sidebar-nav" class="sidebar" >
  <div class="sidebar-scroll" style="margin-top:20px">
    <nav>
      <ul class="nav">
        <?php
          $link = array("dashboard","master_data","transaksi","config","mesin");
          $menu = array("Beranda","Data Master","Transaksi","Konfigurasi","Mesin");
          $icon = array("home","file-empty","dice","code","cog");
          for($i = 0; $i < 5; $i++){
            ($this->input->get("q") == md5($link[$i])) ? $class = "active" : $class= "";
            if($link[$i] == "config"){
              ($this->input->get('sq')) ? $collapse = "in" : $collapse = "";
              echo "<li>
              <a href=\"#config\" data-toggle=\"collapse\" class=\"collapsed $class\"><i class=\"lnr lnr-".$icon[$i]."\"></i> <span>".$menu[$i]."</span></a>
              <div id=\"config\" class=\"collapse $collapse\">
                  <ul class=\"nav\">
                    <li><a href=\"?q=".md5($link[$i])."&sq=".base64_encode("sekolah")."\" class=\"\">Sekolah</a></li>
                    <li><a href=\"?q=".md5($link[$i])."&sq=".base64_encode("kelas")."\" class=\"\">Kelas</a></li>
                  </ul>
                </div>
                </li>
                ";
            } else if($link[$i] == "master_data"){
              ($this->input->get('md')) ? $collapse = "in" : $collapse = "";
              echo "<li>
              <a href=\"#masterData\" data-toggle=\"collapse\" class=\"collapsed $class\"><i class=\"lnr lnr-".$icon[$i]."\"></i> <span>".$menu[$i]."</span></a>
              <div id=\"masterData\" class=\"collapse $collapse\">
                  <ul class=\"nav\">
                    <li><a href=\"?q=".md5($link[$i])."&md=".base64_encode("siswa")."\" class=\"\">Siswa</a></li>
                    <li><a href=\"?q=".md5($link[$i])."&md=".base64_encode("admin")."\" class=\"\">Admin</a></li>
                  </ul>
                </div>
                </li>
                ";
            } else {
              echo "<li><a href=\"?q=".md5($link[$i])."\" class=\"$class\"><i class=\"lnr lnr-".$icon[$i]."\"></i> <span>".$menu[$i]."</span></a></li>";
            }

          }
        ?>
      </ul>
    </nav>
  </div>
</div>
