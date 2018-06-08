<?php
require_once 'header.php';
require_once 'admin/ayarlar/islem.php';
ob_start();
session_start();

if (!isset($_SESSION['oydurum']))
{
    Header('Location:index.php?durum=oykullan');
    exit;
}
?>
<!-- Page Content -->
<div class="container my-4">
    <!-- Introduction Row -->
    <h1 class="my-4">Seçim Anket Sonuçları<br>
    </h1>
    <p>Anket sonuçları aşağıda bilginize sunulmuştur.</p>
    <h3>Oy Alan Adaylar Sıralı Listeleme</h3
    <p>Sıralı listelemede sadece oy oalan adaylar gözükmektedir.Ada gözükmüyor ise henüz oy almamış demektir.</p>
    <div class="col-md-12">
        <?php
        $oysor = $db->prepare("SELECT * FROM oy");
        $oysor->execute();
        $toplamoy = $oysor->rowCount();

        $adaysor = $db->prepare("SELECT oy.aday_id,aday.aday_adsoyad, COUNT(oy.aday_id) as oytoplam FROM oy INNER JOIN aday ON oy.aday_id=aday.aday_id GROUP BY oy.aday_id ORDER BY oytoplam DESC ");
        $adaysor->execute();
        while ($adaycek = $adaysor->fetch(PDO::FETCH_ASSOC))
        {

            $adayoy = $adaycek['oytoplam'];
            ?>
            <p><?php echo $adaycek['aday_adsoyad'] ?><small>(Geçerli oy sayısı: <?php echo $adayoy ?>)</small></p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?php echo ($adayoy * 100) / $toplamoy; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo number_format(($adayoy * 100) / $toplamoy, 2, ",", ".") ?>%</div>
            </div>
        <?php } ?>
    </div>
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

<?php require_once 'footer.php'; ?>