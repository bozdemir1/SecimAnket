<?php require_once 'header.php'; 
$ayarsor = $db->prepare("SELECT * FROM ayar WHERE ayar_id=:id");
$ayarsor->execute(array(
    'id' => htmlspecialchars($_GET['ayar_id'])
));

$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Site Ayar Düzenleme</h1>   
            <div align="right">
                <a href="ayarlar.php"><button class="btn btn-danger">Geri Dön</button></a><br><br>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Site Ayar Ekleme
                </div>
                <div class="panel-body">
                    <form id="uploadform">
                        <div class="form-group">
                            <label>Ayar Adı</label>
                            <input type="text" class="form-control" name="ayar_ad"  value="<?php echo $ayarcek['ayar_ad'] ?>">
                                <small id="textHelp" class="form-text text-muted">$_SESSION değişkeniyle çağırılacak ad</small>
                        </div>
                        <div class="form-group">
                            <label>Ayar Türü</label>
                            <input type="text" class="form-control" name="ayar_tur"  value="<?php echo $ayarcek['ayar_tur'] ?>">
                                <small id="textHelp" class="form-text text-muted">$_SESSION değişkeniyle çağırılacak ayar türü</small>
                        </div>
                        <input type="hidden" name="ayarduzenle">
                            <input type="hidden" name="ayar_id" value="<?php echo base64_encode($ayarcek['ayar_id']) ?>">
                            <div align="right">
                                <button class="btn btn-success">Kaydet</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    Bilgilendirme
                </div>
                <div class="panel-body">
                    <p>Dilediğiniz kadar site ayarı ekleyebilirsiniz.</p>
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
    });
</script>