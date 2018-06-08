<!-- Footer -->
<footer class="py-5 bg-dark" >
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Salih Bozdemir 2018</p>
    </div>
    <!-- /.container -->
</footer>
<script type="text/javascript">
    $("#sonucsorgula").on('submit', (function (e) {
        $.ajax({
            url: "admin/ayarlar/islem.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                veri = JSON.parse(data);
                if (veri.oyyok == 0) {
                    swal("İşlem Sonucu", veri.message, veri.status);
                } else if (veri.oyyok == 1) {
                    window.location.href = "anket-sonuclari";
                } else {
                    swal("İşlem Sonucu", veri.message, veri.status);
                }
            }
        });
        return false;
    }));
</script>

</body>
</html>
