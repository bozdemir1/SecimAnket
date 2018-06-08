<?php
require_once 'header.php';
require_once 'admin/ayarlar/islem.php';
?>
<!-- Page Content -->
<div class="container">
    <!-- Introduction Row -->
    <h1 class="my-4">CB
        <small>Seçim Anketi</small>
    </h1>
    <p>Salih Bozdemir tarafından kodlanan bu script kendimi geliştirme amaçlıdır.Test amacıyla oy verip sistemi deneyebilirsiniz.</p>
    <!-- Team Members Row -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="my-4">Adaylar</h2>
        </div>
        <?php
        $adaysor = $db->prepare("SELECT * FROM aday  ORDER BY aday_sira ASC");
        $adaysor->execute();
        while ($adaycek = $adaysor->fetch(PDO::FETCH_ASSOC))
        {
            ?>
            <div class="col-lg-4 col-sm-6 text-center mb-4">
                <img width="250" height="230"  class="rounded-circle " src="<?php echo $adaycek['aday_resimyol'] ?>" alt="">
                    <h3><?php echo $adaycek['aday_adsoyad'] ?></h3>
                    <button class="btn btn-success" data-toggle="modal" data-target="#oykutusu<?php echo $adaycek['aday_id'] ?>">Oy Ver</button>
            </div>
            <?php
            if ($_SESSION['oyturu'] == 1)
            {
                ?>
                <!--Modal --ve Mail ile gönderim işlemleri -->
                <div class = "modal fade" id = "oykutusu<?php echo $adaycek['aday_id'] ?>" tabindex = "-1" role = "dialog" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
                    <div class = "modal-dialog" role = "document">
                        <div class = "modal-content">
                            <div class = "modal-header">
                                <h5 class = "modal-title" id = "exampleModalLabel">Oyunu Kullan</h5>
                                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                    <span aria-hidden = "true">&times;
                                    </span>
                                </button>
                            </div>
                            <div class = "modal-body">
                                <p>Oy verme işleminizin geçerlik sayılabilmesi için 4 haneli bir şifre gönderilecektir.Mail kutunuzun spam klasörünü de kontrol etmeyi unutmayın.</p>
                                <p id = "sonuc<?php echo $adaycek['aday_id'] ?>"></p>
                                <form id = "mailonaykodugonder<?php echo $adaycek['aday_id'] ?>">

                                    <div id = "mailadres<?php echo $adaycek['aday_id'] ?>" class = "form-group">
                                        <label for = "exampleFormControlInput1">Mail Adresiniz</label>
                                        <input type = "email" class = "form-control" name = "kullanici_mail" placeholder = "Geçerli bir mail adresi giriniz">
                                            <input id = "oymails" type = "hidden" name = "oymail">
                                                <input type = "hidden" name = "aday_id" value = "<?php echo $adaycek['aday_id'] ?>">
                                                    </div>
                                                    <div id = "onaykodu<?php echo $adaycek['aday_id'] ?>" class = "form-group">
                                                        <label for = "exampleFormControlInput1">Onay kodunuz</label>
                                                        <input type = "text" class = "form-control" name = "kullanici_onaykodu" placeholder = "Gelen onay kodunu giriniz">
                                                            <input type = "hidden" name = "onaykodu">
                                                                <input type = "hidden" name = "aday_id" value = "<?php echo $adaycek['aday_id'] ?>">
                                                                    </div>

                                                                    </div>
                                                                    <div class = "modal-footer">
                                                                        <button id = "mailgonderbuton<?php echo $adaycek['aday_id'] ?>" type = "submit" class = "btn btn-primary" >Doğrulama Kodu İste</button>
                                                                        <button id = "dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>" type = "submit" class = "btn btn-success">Oyunu Kullan</button>
                                                                        <a href = "anket-sonuclari" id = "sonucbuton<?php echo $adaycek['aday_id'] ?>" class = "btn btn-danger">Sonuçları Gör</a>
                                                                        </form>
                                                                    </div>
                                                                    </div>
                                                                    </div>

                                                                    <script type = "text/javascript">
                                                                        $(document).ready(function () {
                                                                            $("#onaykodu<?php echo $adaycek['aday_id'] ?>").hide();
                                                                            $("#dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                            $("#sonucbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                        });
                                                                        $("#mailonaykodugonder<?php echo $adaycek['aday_id'] ?>").on('submit', (function (e) {
                                                                            $.ajax({
                                                                                url: "admin/ayarlar/islem.php",
                                                                                type: "POST",
                                                                                data: new FormData(this),
                                                                                contentType: false,
                                                                                cache: false,
                                                                                processData: false,
                                                                                success: function (data) {
                                                                                    veri = JSON.parse(data);
                                                                                    swal("İşlem Sonucu", veri.message, veri.status)
                                                                                    if (veri.oydurum == "1") {
                                                                                        $("#mailgonderbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                        $("#sonucbuton<?php echo $adaycek['aday_id'] ?>").show();
                                                                                    }

                                                                                    if (veri.islemno == "1") {
                                                                                        $("#oymails").attr('disabled');
                                                                                        $("#mailadres<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                        $("#mailadres<?php echo $adaycek['aday_id'] ?>").remove();
                                                                                        $("#mailgonderbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                        $("#dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>").show();
                                                                                        $("#onaykodu<?php echo $adaycek['aday_id'] ?>").show();
                                                                                    } else if (veri.islemno == "2") {
                                                                                        $("#onaykodu<?php echo $adaycek['aday_id'] ?>").remove();
                                                                                        $("#dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>").remove();
                                                                                        $("#sonuc<?php echo $adaycek['aday_id'] ?>").text("Oyunuz başarıyla kaydedildi");
                                                                                        $("#sonucbuton<?php echo $adaycek['aday_id'] ?>").show();
                                                                                    }
                                                                                }
                                                                            });
                                                                            return false;
                                                                        }));
                                                                    </script>
                                                                    <!--Modal mail bitiş -->
                                                                    </div>
                                                                    <?php
                                                                }
                                                                else if ($_SESSION['oyturu'] == 0)
                                                                {
                                                                    ?>
                                                                    <!--Modal  ile sms ile gönderim işlemleri -->
                                                                    <div class = "modal fade" id = "oykutusu<?php echo $adaycek['aday_id'] ?>" tabindex = "-1" role = "dialog" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
                                                                        <div class = "modal-dialog" role = "document">
                                                                            <div class = "modal-content">
                                                                                <div class = "modal-header">
                                                                                    <h5 class = "modal-title" id = "exampleModalLabel">Oyunu Kullan</h5>
                                                                                    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                                                                        <span aria-hidden = "true">&times;
                                                                                        </span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class = "modal-body">
                                                                                    <p>Oy verme işleminizin geçerlik sayılabilmesi için cep telefonunuza 4 haneli bir şifre gönderilecektir..</p>
                                                                                    <p id = "sonuc<?php echo $adaycek['aday_id'] ?>"></p>
                                                                                    <form id = "mailonaykodugonder<?php echo $adaycek['aday_id'] ?>">
                                                                                        <div id = "mailadres<?php echo $adaycek['aday_id'] ?>" class = "form-group">
                                                                                            <label for = "exampleFormControlInput1">Cep Telefonu Numaranız</label>
                                                                                            <input type = "text" class = "form-control" name = "kullanici_gsm" id="yourphone2<?php echo $adaycek['aday_id'] ?>"  placeholder = "Geçerli cep telefonu numarası giriniz">
                                                                                                <input id = "oymails" type = "hidden" name = "oysms">
                                                                                                    <input type = "hidden" name = "aday_id" value = "<?php echo $adaycek['aday_id'] ?>">
                                                                                                        </div>
                                                                                                        <script type="text/javascript">
                                                                                                            $(document).ready(function () {
                                                                                                                $("#yourphone2<?php echo $adaycek['aday_id'] ?>").usPhoneFormat();

                                                                                                            });
                                                                                                        </script>

                                                                                                        <div id = "onaykodu<?php echo $adaycek['aday_id'] ?>" class = "form-group">
                                                                                                            <label for = "exampleFormControlInput1">Onay kodunuz</label>
                                                                                                            <input type = "text" class = "form-control" name = "kullanici_smsonaykodu" placeholder = "Gelen onay kodunu giriniz">
                                                                                                                <input type = "hidden" name = "onaykodusms">
                                                                                                                    <input type = "hidden" name = "aday_id" value = "<?php echo $adaycek['aday_id'] ?>">
                                                                                                                        </div>

                                                                                                                        </div>
                                                                                                                        <div class = "modal-footer">
                                                                                                                            <button id = "mailgonderbuton<?php echo $adaycek['aday_id'] ?>" type = "submit" class = "btn btn-primary" >Doğrulama Kodu İste</button>
                                                                                                                            <button id = "dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>" type = "submit" class = "btn btn-success">Oyunu Kullan</button>
                                                                                                                            <a href = "anket-sonuclari" id = "sonucbuton<?php echo $adaycek['aday_id'] ?>" class = "btn btn-danger">Sonuçları Gör</a>
                                                                                                                            </form>
                                                                                                                        </div>
                                                                                                                        </div>
                                                                                                                        </div>

                                                                                                                        <script type = "text/javascript">
                                                                                                                            $(document).ready(function () {
                                                                                                                                $("#onaykodu<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                                                                $("#dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                                                                $("#sonucbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                                                            });
                                                                                                                            $("#mailonaykodugonder<?php echo $adaycek['aday_id'] ?>").on('submit', (function (e) {
                                                                                                                                $.ajax({
                                                                                                                                    url: "admin/ayarlar/islem.php",
                                                                                                                                    type: "POST",
                                                                                                                                    data: new FormData(this),
                                                                                                                                    contentType: false,
                                                                                                                                    cache: false,
                                                                                                                                    processData: false,
                                                                                                                                    success: function (data) {
                                                                                                                                        veri = JSON.parse(data);
                                                                                                                                        swal("İşlem Sonucu", veri.message, veri.status)
                                                                                                                                        if (veri.oydurum == "1") {
                                                                                                                                            $("#mailgonderbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                                                                            $("#sonucbuton<?php echo $adaycek['aday_id'] ?>").show();
                                                                                                                                        }

                                                                                                                                        if (veri.islemno == "1") {
                                                                                                                                            $("#oymails").attr('disabled');
                                                                                                                                            $("#mailadres<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                                                                            $("#mailadres<?php echo $adaycek['aday_id'] ?>").remove();
                                                                                                                                            $("#mailgonderbuton<?php echo $adaycek['aday_id'] ?>").hide();
                                                                                                                                            $("#dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>").show();
                                                                                                                                            $("#onaykodu<?php echo $adaycek['aday_id'] ?>").show();
                                                                                                                                        } else if (veri.islemno == "2") {
                                                                                                                                            $("#onaykodu<?php echo $adaycek['aday_id'] ?>").remove();
                                                                                                                                            $("#dogrulamakodbuton<?php echo $adaycek['aday_id'] ?>").remove();
                                                                                                                                            $("#sonuc<?php echo $adaycek['aday_id'] ?>").text("Oyunuz başarıyla kaydedildi");
                                                                                                                                            $("#sonucbuton<?php echo $adaycek['aday_id'] ?>").show();
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                });
                                                                                                                                return false;
                                                                                                                            }));
                                                                                                                        </script>
                                                                                                                        <!--Modal sms bitiş -->
                                                                                                                        </div>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                <!-- /.container -->

                                                                                                                <?php require_once 'footer.php'; ?>
