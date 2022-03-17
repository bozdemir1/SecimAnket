<?php
require_once 'header.php';
require_once 'admin/ayarlar/islem.php';
?>

<!-- Page Content -->
<div class="container">
    <!-- Introduction Row -->
    <h1 class="my-4">Seçim Anketi</h1>
    <p>Basit bir oy verme ve oy sonuçlarının görüntülenebildiği anket scripti.</p>
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
            <div class="box15">
                <img width="250" height="230" src="<?php echo $adaycek['aday_resimyol'] ?>" alt="">
                <div class="box-content">
                    <h3 class="title"><?php echo $adaycek['aday_adsoyad'] ?></h3>
                    <ul class="icon">
                        <li>
                            <a data-toggle="modal" data-target="#oykutusu<?php echo $adaycek['aday_id'] ?>">Oy ver</a>
                        </li>
                    </ul>
                </div>
            </div>
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


                <style type="text/css">
                    a {
                        color: inherit;
                        text-decoration: none;
                    }

                    a:hover {
                        color: rgba(0, 0, 0, .65);
                    }

                    a:hover {
                        color: rgba(0, 0, 0, .45);
                    }

                    .window,
                    .box,
                    ul,
                    li {
                        margin: 0;
                        overflow: hidden;
                        padding: 0;
                        position: relative;
                    }

                    ul {
                        font-family: 'Fjalla One', sans-serif;
                        list-style-type: none;
                        text-transform: uppercase;
                    }

                    li {
                        display: inline-block;
                    }

                    img {
                        display: block;
                        width: 100%;
                    }

                    .btn {
                        background: rgba(255,255,255,0.8);
                        border: 1px solid rgba(255,255,255,0.5);
                        border-radius: 40px;
                        color: rgba(0,0,0,0.75);
                        display: block;
                        font-size: 1em;
                        font-weight: 400;
                        height: 44px;
                        letter-spacing: 5px;
                        line-height: 42px;
                        margin: 10px auto;
                        padding: 0;
                        position: relative;
                        text-align: center;
                        text-transform: uppercase;
                        -webkit-transition: all .5s ease;
                        transition: all .5s ease;
                        vertical-align: middle;
                        width: 60%;
                    }

                    .btn:hover {
                        background: rgba(0,0,0,0.1);
                        border: 1px solid rgba(0,0,0,0.15);
                    }

                    .overlay {
                        background: #158 url(http://images.ticiz.com/2603690_w0_h120_hnn1i...bv9ettdv9dsbugw0py.png) center no-repeat;
                        background-size: cover;
                        height: calc(100% + 40px);
                        margin: -20px;
                        position: relative;
                        width: calc(100% + 40px);
                        -webkit-filter: blur(10px);
                        -moz-filter: blur(10px);
                        filter: blur(10px);
                    }

                    .window {
                        box-shadow: 0 0 100px  rgba(0,0,0,0.25);
                        height: 560px;
                        margin: 2em auto 0;
                        width: 320px;
                    }

                    .header {
                        background: rgba(0, 97, 145, 0.45);
                        color: #FFF;
                        height: 380px;
                        left: 0;
                        position: absolute;
                        text-align: center;
                        top: 0;
                        width: inherit;
                    }

                    .header:before {
                        border: 2px solid rgba(161, 220, 255, 0.34);
                        border-radius: 100%;
                        content: "";
                        height: 140px;
                        left: 0;
                        margin: 67px auto;
                        padding: 0;
                        position: absolute;
                        right: 0;
                        top: 0;
                        width: 140px;
                        z-index: 2;
                        -webkit-transform: scale(1.24, 1.24);
                        -moz-transform: scale(1.24, 1.24);
                        transform: scale(1.24, 1.24);
                    }

                    .header img {
                        border: 5px solid #A1DCFF;
                        border-radius: 100%;
                        height: 140px;
                        margin: 4em auto 2.5em;
                        object-fit: cover;
                        width: 140px;
                    }

                    .header h2 {
                        display: inline-block;
                        font-family: 'Quicksand', sans-serif;
                        font-size: 28px;
                        font-weight: 400;
                        letter-spacing: -2px;
                        margin: 0 auto;
                        padding: 0;
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
                    }

                    .header h4 {
                        color: rgba(255, 255, 255, 0.75);
                        display: block;
                        font-size: 15px;
                        margin: 0 auto;
                        padding: 5px 0 0;
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
                        text-transform: uppercase;
                    }

                    .footer {
                        background: rgba(0, 97, 145, 0.75);
                        bottom: 0;
                        color: #FFF;
                        left: 0;
                        position: absolute;
                        text-align: center;
                        top: 380px;
                        width: inherit;
                    }

                    .footer ul {
                        display: flex;
                        font-size: 16px;
                        font-weight: 400;
                        height: 40px;
                        line-height: 40px;
                        padding: 20px 20px;
                    }

                    .footer li:first-child {
                        border: 0;
                    }

                    .footer li {
                        border-left: 2px solid rgba(255, 255, 255, .15);
                        font-family: 'Quicksand', sans-serif;
                        padding: 0 4px 0 6px;
                        width: 100%;
                    }

                    .footer a span {
                        color: #9CDFF5;
                        display: inline-block;
                        font-size: 26px;
                        padding: 0 4px 0 0;
                        vertical-align: middle;
                    }
                </style>
                <div class="window">
                    <div class="overlay"></div>
                    <div class="box header">
                        <img src="http://www.doyoubuzz.com/var/users/_/2016/11/15/18/1300826/avatar/1253797/avatar_cp_630.jpg?t=1505286021" alt="" />
                        <h2>HARUN PEHLİVAN</h2>
                        <h4> FOUNDER,CEO BLOGGER</h4>
                    </div>
                    <div class="box footer">
                        <ul>
                            <li><a href="http://harunpehlivantebimtebitagem.business.site"><span class="ion-ios-camera-outline"></span>HP</a></li>
                            <li><a href="http://harunpehlivantebimtebitagem.ml"><span class="ion-ios-heart-outline"></span> WEP</a></li>
                            <li><a href="https://harunpehlivantebimtebitagem.carrd.co"><span class="ion-ios-person-outline"></span>E-CV</a></li>
                        </ul>
                        <a href="http://www.doyoubuzz.com/harun-pehlivan" class="btn">Follow</a>
                    </div>
                </div>




                <!--Modal  ile sms ile gönderim işlemleri -->
                <div class = "modal fade" id = "oykutusu<?php echo $adaycek['aday_id'] ?>" tabindex = "-1" role = "dialog" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
                    <div class = "modal-dialog" role = "document">
                        <div class = "modal-content">
                            <div class = "modal-header">
                                <h5 class = "modal-title" id = "exampleModalLabel">Oyunu Kullan</h5>
                                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                    <span aria-hidden = "true">&times;</span>
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
