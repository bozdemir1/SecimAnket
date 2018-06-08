<?php
require_once 'header.php';


$adaysor = $db->prepare("SELECT * FROM aday WHERE aday_id=:id");
$adaysor->execute(array(
    'id' => htmlspecialchars($_GET['aday_id'])
));

$adaycek = $adaysor->fetch(PDO::FETCH_ASSOC);
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Cum. Bşk. Adayı Düzenleme </h1>   
            <div align="right">
                <a href="adaylar.php"><button class="btn btn-danger">Geri Dön</button></a><br><br>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Başlık Kısmı
                </div>
                <div class="panel-body" enctype="multipart/form-data">
                    <div class="form-group">
                        <div>
                            <img id="adayresim" src="../../<?php echo $adaycek['aday_resimyol'] ?>" width="150" height="130"></img>
                        </div>
                    </div>
                    <form id="uploadform">
                        <div class="form-group">
                            <label>Aday Resmi Seçiniz</label>
                            <input id="file" type="file" name="file" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label>Aday Ad Soyad</label>
                            <input type="text" class="form-control" name="aday_adsoyad"  value="<?php echo $adaycek['aday_adsoyad'] ?>">
                                <small id="textHelp" class="form-text text-muted">Adayın oylamada gözükecek ad ve soyadınız yazınız...</small>
                        </div>
                            <input type="hidden" name="adayduzenle">
                            <input type="hidden" name="aday_id" value="<?php echo htmlspecialchars($_GET['aday_id']) ?>">
                                <input type="hidden" name="eski_yol" value="<?php echo $adaycek['aday_resimyol'] ?>">
                                
                                <div align="right">
                                    <button class="btn btn-success">Güncelle</button>
                                </div>
                                </form>

                                </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-red">
                                        <div class="panel-heading">
                                            Bilgilendirme
                                        </div>
                                        <div class="panel-body">
                                            <p>Aday bilgilerini eksiksiz olarak doldurmalısınız</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                                </div>
                                <!-- /#page-wrapper -->

                                </div>
                                <!-- /#wrapper -->

                                <?php require_once 'footer.php'; ?>

                                <script type="text/javascript">
                                    $(document).ready(function (e) {
                                        $("#uploadform").on('submit', (function (e) {
                                            $.ajax({
                                                url: "../ayarlar/islem.php",
                                                type: "POST",
                                                data: new FormData(this),
                                                contentType: false,
                                                cache: false,
                                                processData: false,
                                                success: function (data) {
                                                    veri = JSON.parse(data);
                                                    swal("İşlem Sonucu", veri.message, veri.status)
                                                }
                                            });
                                            return false;
                                        }));
                                        $("#file").change(function () {
                                            var reader = new FileReader();
                                            reader.onload = imageload;
                                            reader.readAsDataURL(this.files[0]);
                                        });
                                        function imageload(e) {
                                            $("#adayresim").attr('src', e.target.result);
                                        }
                                    });
                                </script>