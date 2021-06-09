<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script type="text/javascript" src="assets/vendor/datatables/datatables.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>
<script src="assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="assets/vendor/select2/select2.min.js"></script>
<script src="assets/scripts/upload.js"></script>
<script src="assets/scripts/jquery.md5.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>


<script>
//GET METHOD
var $_GET = {};

document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }

    $_GET[decode(arguments[1])] = decode(arguments[2]);
});
//GET METHOD

$(document).ready(function(){
  //STANDAR select2
  $('.kelas').select2();

  if(!$_GET["q"]){
    location.replace("?q="+btoa("dashboard"));
  }
  //Khusus_Import
  $('#import').DataTable();

  //Data Table
  var events = $('#btn_hapus');
  var data_pilih = [];
  var rowData, countData = " ", state_id;

    switch(atob($_GET['md'])){
      case 'siswa':
        state_id = 1;
      break;

      case 'admin':
        state_id = 1;
      break;

    }

  var table = $('#master_'+atob($_GET['md'])).DataTable( {
      "columnDefs": [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
      "select": {
            style:    'multiple',
            selector: 'td:first-child'
        },
      "paging":   true,
      "ordering": true,
      "info":     true
  } );

  table
        .on( 'select', function ( e, dt, type, indexes ) {
            data_pilih = [];
            rowData = table.rows( { selected: true } ).data().toArray();
            countData = table.rows( { selected: true } ).count();
            // events.prepend( '<div><b>'+countData+' selection</b></div>') ;
            if(countData>0){
              for(var i = 0; i < countData; i++)
              data_pilih.push(rowData[i][state_id]);
              events.html( '<a href=\'#\' class=\'text-danger pull-right\' style=\'margin-right:25px;margin-bottom:10px\'><i class=\'fa fa-trash\'></i> ('+countData+') Hapus Data Terpilih</a>' );
            }
            else
              events.html('');
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
          data_pilih = [];
          rowData = table.rows( { selected: true } ).data().toArray();
          countData = table.rows(  { selected: true }  ).count();
          // events.prepend( '<div><b>'+countData+' selection</b></div>' ) ;

          if(countData>0){
            for(var i = 0; i < countData; i++)
            data_pilih.push(rowData[i][state_id]);
            events.html( '<a href=\'#\'  class=\'text-danger pull-right\' style=\'margin-right:25px;margin-bottom:10px\'><i class=\'fa fa-trash\'></i> ('+countData+') Hapus Data Terpilih</a>' );
            for(var i = 0; i < countData; i++)
            console.log(rowData[i][1]+" ");
          }
            else
              events.html('');
        } );

        $(".hapus").on("click",function proses_hapus(){
          swal({
          title: "Kamu Yakin?",
          text: "Kamu akan menghapus "+countData+" Data terpilih, Data yang sudah dihapus tidak dapat dikembalikan!",
          icon: "warning",
          buttons: ["Oh Tidak!", "Oke, Proses!"],
          dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              var id,kondisi;
              if(btoa($_GET['md']) == "admin"){
                id      = $(".hapus").data();
                kondisi = "false";
              } else {
                kondisi = "false";
                id      = JSON.stringify(data_pilih);
              }
                $.ajax({
                  url: '<?= site_url('main/'.base64_decode($this->input->get('md')).'_delete?row=') ?>'+kondisi,
                  method: "post",
                  dataType: "json",
                  data: {id:id},
                  beforeSend: function(){
                    $("#loading").html("<img src=\"assets/img/loading.gif\" width=\"100%\" />");
                    $("#loading").fadeIn(3000);
                  },
                  error: function(xhr) { // if error
                    var message =" unknown ";
                    if(xhr.status == "404")
                    message = "["+xhr.statusText+"] 404 : Halaman yang direquest tidak ditemukan";
                    else if(xhr.status == "200")
                    message = "["+xhr.statusText+"] 200 : System tidak merespon balik";
                    else
                    message = "["+xhr.status+"] "+xhr.statusText;

                    swal({
                      title: "AJAX Error!",
                      text: message,
                      icon: "error"
                    }).then(function(){
                      location.reload();
                    });

                  },
                  success: function(response){
                    if(response.status == "0") {
                      swal({title : "Kesalahan!", text: response.message, icon: "error"})
                      .then(function(){location.reload()});
                    }
                    else {
                      swal({title : "Sukses!", text: response.message, icon: "success"})
                      .then(function(){location.replace("?q="+btoa("master")+"&md="+$_GET['md'])});
                    }
                  },
                  complete: function() {
                    $("#loading").fadeOut();
                  }
                });
            } else {
              swal("Data Batal Dihapus!");
            }
          });
          // alert(JSON.stringify(data_pilih));
        });
});
//UPDATE_LIMIT_KELAS
$(".ubahlimit").on("click", function(){
  var id_class  = $(this).data("row");
  var id_class2 = id_class.split("/");
  var data_lim  = $(".lim"+id_class2[1]).val();
  alert(data_lim);
});

$("#login").on("click", function(){
  //BLANK CHECK
  var length_username = $("#username").val().length;
  var length_password = $("#password").val().length;
  var data_username   = $("#username").val();
  var data_password   = $.md5($("#password").val());
  var data_level      = $("#type").val();

  if( length_username > 0 && length_password > 0){

    $(".message1").html("");
    $(".message2").html("");
    $.ajax({
      url: '<?= site_url('cas/log/login') ?>',
      method: "post",
      dataType: "json",
      data: {username:data_username, password:data_password, level:data_level},
      beforeSend: function(){
        $("#loading").html("<img src=\"assets/img/loading.gif\" width=\"100%\" />");
        $("#loading").fadeIn(3000);
      },
      error: function(xhr) { // if error
        var message =" unknown ";
        if(xhr.status == "400")
          message = "["+xhr.statusText+"] 404 : Halaman yang direquest tidak ditemukan";
        else if(xhr.status == "200")
          message = "["+xhr.statusText+"] 200 : System tidak merespon balik";
        else
          message = "["+xhr.status+"] "+xhr.statusText;

        swal({
          title: "AJAX Error!",
          text: message,
          icon: "error"
          }).then(function(){
          location.reload();
          });

      },
      success: function(response){
        if(response.status == "0") {
          swal({title : "Kesalahan!", text: response.message, icon: "error"})
          .then(function(){location.reload()});
        }
        else {
          location.replace("?q="+btoa("dashboard"));
        }
      },
      complete: function() {
        $("#loading").fadeOut();
      }
    });
  } else {
    if(length_username == 0)     $(".message1").html("*Username Tidak Boleh Kosong");
    else                         $(".message1").html("");
    if(length_password == 0)     $(".message2").html("*Password Tidak Boleh Kosong");
    else                         $(".message2").html("");
  }

});


if(atob($_GET["q"]) == "dashboard"){

  $(function() {
    var data, options;

    // headline charts
    data = {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      series: [
        [23, 29, 24, 40, 25, 24, 35],
        [14, 25, 18, 34, 29, 38, 44],
      ]
    };

    options = {
      height: 300,
      showArea: true,
      showLine: false,
      showPoint: false,
      fullWidth: true,
      axisX: {
        showGrid: false
      },
      lineSmooth: false,
    };

    new Chartist.Line('#headline-chart', data, options);


    // visits trend charts
    data = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      series: [{
        name: 'series-real',
        data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
      }, {
        name: 'series-projection',
        data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
      }]
    };

    options = {
      fullWidth: true,
      lineSmooth: false,
      height: "270px",
      low: 0,
      high: 'auto',
      series: {
        'series-projection': {
          showArea: true,
          showPoint: false,
          showLine: false
        },
      },
      axisX: {
        showGrid: false,

      },
      axisY: {
        showGrid: false,
        onlyInteger: true,
        offset: 0,
      },
      chartPadding: {
        left: 20,
        right: 20
      }
    };

    new Chartist.Line('#visits-trends-chart', data, options);


    // visits chart
    data = {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      series: [
        [6384, 6342, 5437, 2764, 3958, 5068, 7654]
      ]
    };

    options = {
      height: 300,
      axisX: {
        showGrid: false
      },
    };

    new Chartist.Bar('#visits-chart', data, options);


    // real-time pie chart
    var sysLoad = $('#system-load').easyPieChart({
      size: 130,
      barColor: function(percent) {
        return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
      },
      trackColor: 'rgba(245, 245, 245, 0.8)',
      scaleColor: false,
      lineWidth: 5,
      lineCap: "square",
      animate: 800
    });

    var updateInterval = 3000; // in milliseconds

    setInterval(function() {
      var randomVal;
      randomVal = getRandomInt(0, 100);

      sysLoad.data('easyPieChart').update(randomVal);
      sysLoad.find('.percent').text(randomVal);
    }, updateInterval);

    function getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

  });
}

//Error Detail Tidak ditemukan
  function belum_ada(){

         swal({
           title: "Peringatan!",
           text: "Fitur Belum tersedia",
           icon: "warning"
         });

  }
  if ($('#error_detail').length){
       swal({
         title: "Error!",
         text: "Rincian data tidak dapat ditampilkan",
         icon: "error"
       }).then(function(){
         location.replace("?q="+btoa("master")+"&md="+btoa("siswa"));
       });
   }

   //UPDATE SISWA
   $("#profil_siswa").on("submit", function(){
     $.ajax({
       url: '<?= site_url('main/siswa_update') ?>',
       method: "post",
       dataType: "json",
       data: $(this).serialize(),
       beforeSend: function(){
         $("#update").remove();
         $("#loading").html("<img src=\"assets/img/loading.gif\" width=\"100%\" />");
         $("#loading").fadeIn(3000);
       },
       error: function(xhr) { // if error
         var message =" unknown ";
         if(xhr.status == "400")
           message = "["+xhr.statusText+"] 404 : Halaman yang direquest tidak ditemukan";
         else if(xhr.status == "200")
           message = "["+xhr.statusText+"] 200 : System tidak merespon balik";
         else
           message = "["+xhr.status+"] "+xhr.statusText;

         swal({
           title: "AJAX Error!",
           text: message,
           icon: "error"
           }).then(function(){
           location.reload();
           });

       },
       success: function(response){
         if(response.status == "0") {
           swal({title : "Kesalahan!", text: response.message, icon: "error"})
           .then(function(){location.reload()});
         }
         else {
           swal({title : "Sukses!", text: response.message, icon: "success"})
           .then(function(){location.reload()});
         }
       },
       complete: function() {
         $("#loading").fadeOut();
       }
     });
   });

//SISWA BARU
$("#nis").on("change", function(){
  $.ajax({
    url: '<?= site_url('main/siswa_insert?cek_nis=true') ?>',
    method: "post",
    dataType: "json",
    data: {nis:$("#nis").val()},
    success: function(response){
      if(response.status == "0") {
        $("#nis_error").html(response.message);
        $("#insert").attr("disabled","disabled");
      } else {
        $("#insert").attr("disabled", false);
      }
    }
  });
});

$("#insert").on("click", function(){
  var nis = $("#nis").val();
  var nama = $("#nama").val();
  var pass = $("#pass").val();

  if(nis.length > 0 && nama.length > 0 && pass.length > 0){
    $.ajax({
      url: '<?= site_url('main/siswa_insert') ?>',
      method: "post",
      dataType: "json",
      data: $("#baru_siswa").serialize(),
      beforeSend: function(){
        $("#insert").remove();
        $("#loading").html("<img src=\"assets/img/loading.gif\" width=\"100%\" />");
        $("#loading").fadeIn(3000);
      },
      error: function(xhr) { // if error
        var message =" unknown ";
        if(xhr.status == "404")
        message = "["+xhr.statusText+"] 404 : Halaman yang direquest tidak ditemukan";
        else if(xhr.status == "200")
        message = "["+xhr.statusText+"] 200 : System tidak merespon balik";
        else
        message = "["+xhr.status+"] "+xhr.statusText;

        swal({
          title: "AJAX Error!",
          text: message,
          icon: "error"
        }).then(function(){
          location.reload();
        });

      },
      success: function(response){
        if(response.status == "0") {
          swal({title : "Kesalahan!", text: response.message, icon: "error"})
          .then(function(){location.reload()});
        }
        else {
          swal({title : "Sukses!", text: response.message, icon: "success"})
          .then(function(){location.reload()});
        }
      },
      complete: function() {
        $("#loading").fadeOut();
      }
    });
  } else {
    swal({title : "Kesalahan!", text: "Data NIS / Nama / Password Tidak Boleh Kosong", icon: "error"});
  }

});

$("#delete").on("click", function(){
  swal({
  title: "Kamu Yakin?",
  text: "Data yang sudah dihapus tidak dapat dikembalikan!",
  icon: "warning",
  buttons: ["Oh Tidak!", "Oke, Proses!"],
  dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      var id = $("#id").val();

        $.ajax({
          url: '<?= site_url('main/siswa_delete') ?>',
          method: "post",
          dataType: "json",
          data: {id:id},
          beforeSend: function(){
            $("#update").remove();
            $(".main").remove();
            $("#delete").remove();
            $("#loading").html("<img src=\"assets/img/loading.gif\" width=\"100%\" />");
            $("#loading").fadeIn(3000);
          },
          error: function(xhr) { // if error
            var message =" unknown ";
            if(xhr.status == "404")
            message = "["+xhr.statusText+"] 404 : Halaman yang direquest tidak ditemukan";
            else if(xhr.status == "200")
            message = "["+xhr.statusText+"] 200 : System tidak merespon balik";
            else
            message = "["+xhr.status+"] "+xhr.statusText;

            swal({
              title: "AJAX Error!",
              text: message,
              icon: "error"
            }).then(function(){
              location.reload();
            });

          },
          success: function(response){
            if(response.status == "0") {
              swal({title : "Kesalahan!", text: response.message, icon: "error"})
              .then(function(){location.reload()});
            }
            else {
              swal({title : "Sukses!", text: response.message, icon: "success"})
              .then(function(){location.replace("?q="+btoa("master")+"&md="+btoa("siswa"))});
            }
          },
          complete: function() {
            $("#loading").fadeOut();
          }
        });
    } else {
      swal("Data Batal Dihapus!");
    }
  });


});

</script>
