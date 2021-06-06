<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>
<script src="assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script src="assets/scripts/jquery.md5.js"></script>
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
  if(!$_GET["q"]){
    location.replace("?q="+$.md5("dashboard"));
  }
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
          location.replace("?q="+$.md5("dashboard"));
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


if($_GET["q"] == $.md5("dashboard")){

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

</script>
