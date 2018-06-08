<?php require_once 'header.php'; ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Admin paneli </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"> 
                                <?php
                                $oysor = $db->prepare("SELECT * FROM oy");
                                $oysor->execute();
                                echo $oysor->rowCount();
                                ?>
                            </div>
                            <div>Toplam oy sayısı</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                                <?php
                                $adaysor = $db->prepare("SELECT * FROM aday");
                                $adaysor->execute();
                                echo $adaysor->rowCount();
                                ?>
                            </div>
                            <div>Aday sayısı</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                                <?php
                                $kullanicisor = $db->prepare("SELECT * FROM kullanici");
                                $kullanicisor->execute();
                                echo $kullanicisor->rowCount();
                                ?>
                            </div>
                            <div>Yönetici sayısı</div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>    
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Anket Sonuçları</h1>
            <div class="col-md-12">
                <h3>Sırasız Listeleme</h3>
                <?php
                $oysor = $db->prepare("SELECT * FROM oy");
                $oysor->execute();
                $toplamoy = $oysor->rowCount();

                $adaysor = $db->prepare("SELECT * FROM aday  ORDER BY aday_sira ASC");
                $adaysor->execute();
                while ($adaycek = $adaysor->fetch(PDO::FETCH_ASSOC))
                {

                    $oysor = $db->prepare("SELECT * FROM oy WHERE aday_id=:id");
                    $oysor->execute(array(
                        'id' => $adaycek['aday_id']
                    ));
                    $adayoy = $oysor->rowCount();
                    ?>
                    <p><?php echo $adaycek['aday_adsoyad'] ?><small>(Geçerli oy sayısı: <?php echo $adayoy ?>)</small></p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo ($adayoy * 100) / $toplamoy; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo number_format(($adayoy * 100) / $toplamoy, 2, ",", ".") ?>%</div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php require_once 'footer.php'; ?>