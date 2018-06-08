<?php require_once 'header.php'; ?>
<head>
<script src="../js/jquery-ui.min.js" type="text/javascript"></script>
</head>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Cum. Bşk. Adayları </h1>   
            <div align="right">
                <a href="aday-ekle.php"><button class="btn btn-success">Yeni Aday Ekle</button></a><br><br>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Başlık Kısmı
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Sıra No</th>
                                <th>Aday Resmi</th>
                                <th>Ad Soyad</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">

                            <?php
                            $adaysor = $db->prepare("SELECT * FROM aday order by aday_sira ASC");
                            $adaysor->execute();
                            $say = 0;
                            while ($adaycek = $adaysor->fetch(PDO::FETCH_ASSOC))
                            {
                                $say++;
                                ?>

                                <tr id="item-<?php echo $adaycek['aday_id']; ?>" class="odd gradeX">
                                    <td width="5"><?php echo $say; ?></td>
                                    <td class="sortable" width="160"><img width="150" height="130" src="../../<?php echo $adaycek['aday_resimyol']; ?>"</td>
                                <td><?php echo $adaycek['aday_adsoyad']; ?></td>
                                <td width="20" class="center"><a href="aday-duzenle.php?aday_id=<?php echo $adaycek['aday_id']; ?>"<button class="btn btn-primary btn-xs">Düzenle</button></a></td>
                                <td width="20" class="center"><a href="../ayarlar/islem.php?adaysil=ok&aday_id=<?php echo $adaycek['aday_id']; ?> "<button class="btn btn-danger btn-xs">Sil</button></a></td>
                                </tr>
                            <?php } ?>         
                            </tbody>
                    </table>

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
<!-- Sortable sıralama -->
<style type="text/css">
    .sortable {cursor:move;}
</style>
<script type="text/javascript">
$(function() {
    $("#sortable").sortable({
        revert:true,
        handle: ".sortable",
        stop: function (event, ui){
            var data = $(this).sortable('serialize');
            
            $.ajax({
                type: "POST",
                dataType:"json",
                data:data,
                url:"ajaxadaysirala.php?p=aday_sira",
                success:function(msg){
                    alert(msg.islemMsj);
                }
            });
        }
    });
            $("#sortable").disableSelection();
    });
    
</script>