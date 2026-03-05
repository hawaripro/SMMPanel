<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">© Copyright <?php echo $data['short_title']; ?>.</span>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!--WA BUTTON-->
<div class="integration-fixed integration-fixed__bottom-left">
    <div class="whatsapp-container">
        <a href="https://api.whatsapp.com/send?phone=<?php echo $data['wa_number']; ?>" target="_blank" class="whatsapp-button">
            <i class="mdi mdi-whatsapp"></i>
        </a>
    </div>
</div>
<!-- container-scroller -->
<link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
<!-- plugins:js -->
<script src="/assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
<!-- Custom js for this page -->
<script src="/assets/js/file-upload.js"></script>
<script src="/assets/js/typeahead.js"></script>
<script src="/assets/js/select2.js"></script>
<!-- Plugin js for this page -->
<script src="/assets/vendors/chart.js/Chart.min.js"></script>
<script src="/assets/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="/assets/js/off-canvas.js"></script>
<script src="/assets/js/hoverable-collapse.js"></script>
<script src="/assets/js/misc.js"></script>
<script src="/assets/js/settings.js"></script>
<script src="/assets/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="/assets/js/chart.js"></script>
<!-- Custom js for this page -->
<script src="/assets/js/dashboard.js"></script>
<!-- End custom js for this page -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#kategori").change(function() {
            var kategori = $("#kategori").val();
            $.ajax({
                url: '/ajax/layanan_sosmed.php',
                data: 'kategori=' + kategori,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#layanan").html(msg);
                }
            });
        });
        $("#layanan").change(function() {
            var layanan = $("#layanan").val();
            $.ajax({
                url: '/ajax/catatan_sosmed.php',
                data: 'layanan=' + layanan,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#catatan").html(msg);
                }
            });
            $.ajax({
                url: '/ajax/rate_sosmed.php',
                data: 'layanan=' + layanan,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#rate").val(msg);
                }
            });
        });
    });
    document.getElementById("show1").style.display = "none";
    $("#layanan").change(function() {
        var selectedCountry = $("#layanan option:selected").text();
        if (selectedCountry.indexOf('Kostum') !== -1 || selectedCountry.indexOf('Costum') !== -1 || selectedCountry.indexOf('custom') !== -1 || selectedCountry.indexOf('Custom') !== -1 || selectedCountry.indexOf('CUSTOM') !== -1) {
            document.getElementById("show1").style.display = "none";
            document.getElementById("show2").style.display = "block";
        } else if (selectedCountry.indexOf('Comment Likes') !== -1 || selectedCountry.indexOf('Tiktok Likes Komentar') !== -1) {
            document.getElementById("show1").style.display = "block";
            document.getElementById("show2").style.display = "none";
        } else {
            document.getElementById("show1").style.display = "block";
            document.getElementById("show2").style.display = "none";
        }
    });
    $(document).ready(function() {
        $("#comments").on("keypress", function(a) {
            if (a.which == 13) {
                var baris = $("#comments").val().split(/\r|\r\n|\n/).length;
                var rates = $("#rate").val();
                var calc = eval(baris) * rates;
                var a1 = calc;
                var b1 = Math.floor(a1)
                console.log(b1)
                $('#totalxx').val(b1);
            }
        });

    });

    function get_total(quantity) {
        var rate = $("#rate").val();
        var result = eval(quantity) * rate;
        var a1 = result;
        var b1 = Math.floor(a1);
        $('#total').val(b1);
    }
</script>
<script type="text/javascript">
    function copy_to_clipboard(element) {
        var copyText = document.getElementById(element);
        copyText.select();
        document.execCommand("copy");
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.view_order').click(function() {
            var id = $(this).attr("id");
            // memulai ajax
            $.ajax({
                url: '/ajax/detail-sosmed.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#data_order').html(data);
                    $('#myDetail').modal("show");
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.view_layanan').click(function() {
            var id = $(this).attr("id");
            // memulai ajax
            $.ajax({
                url: '/ajax/detail-layanan.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#data_layanan').html(data);
                    $('#myLayanan').modal("show");
                }
            });
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#provider").change(function() {
    var provider = $("#provider").val();
            $.ajax({
                url: '/ajax/deposit-manual.php',
                data: 'provider=' + provider,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#catatandepo").html(msg);
                }
            });
        });
    $("#jumlah").change(function(){
    var provider = $("#provider").val();
    var jumlah = $("#jumlah").val();
    $.ajax({
      url : '/ajax/rate_depositmanual.php',
      type  : 'POST',
      dataType: 'html',
      data  : 'provider='+provider+'&jumlah='+jumlah,
      success : function(result){
        $("#ratemanual").val(result);
      }
      });
    });  
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#providerauto").change(function() {
    var providerauto = $("#providerauto").val();
            $.ajax({
                url: '/ajax/deposit-automatis.php',
                data: 'providerauto=' + providerauto,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#catatandepoauto").html(msg);
                }
            });
        });
    $("#jumlah").change(function(){
    var providerauto = $("#providerauto").val();
    var jumlah = $("#jumlah").val();
    $.ajax({
      url : '/ajax/rate_depositauto.php',
      type  : 'POST',
      dataType: 'html',
      data  : 'providerauto='+providerauto+'&jumlah='+jumlah,
      success : function(result){
        $("#rateauto").val(result);
      }
      });
    });  
    });
</script>
</body>

</html