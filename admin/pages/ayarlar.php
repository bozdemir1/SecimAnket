<?php require_once 'header.php'; ?>
<head>
<script src="../js/jquery-ui.min.js" type="text/javascript"></script>
</head>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Ayarlar </h1>   
            <div align="right">
                <a href="ayar-ekle.php"><button class="btn btn-success">Yeni Ayar Ekle</button></a><br><br>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Site Ayarları
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Sıra No</th>
                                <th>Ayar Ad</th>
                                <th>Ayar Tür</th>
                                <th>Ayar Açıklama</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $ayarsor = $db->prepare("SELECT * FROM ayar order by ayar_id ASC");
                            $ayarsor->execute();
                            $say = 0;
                            while ($ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC))
                            {
                                $say++;
                                ?>

                                <tr class="odd gradeX">
                                    <td width="5"><?php echo $say; ?></td>
                                    <td><?php echo $ayarcek['ayar_ad'] ?></td>
                                <td><?php echo $ayarcek['ayar_tur']; ?></td>
                                <td><?php echo $ayarcek['ayar_aciklama']; ?></td>
                                <td width="20" class="center"><a href="ayar-duzenle.php?ayar_id=<?php echo $ayarcek['ayar_id']; ?>"<button class="btn btn-primary btn-xs">Düzenle</button></a></td>
                                <td width="20" class="center"><a href="../ayarlar/islem.php?ayarsil=ok&ayar_id=<?php echo $ayarcek['ayar_id']; ?> "<button class="btn btn-danger btn-xs">Sil</button></a></td>
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
