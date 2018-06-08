<?php

ob_start();
session_start();
date_default_timezone_get('Europe/Istanbul');
require_once 'baglan.php';
require_once 'fonksiyon.php';

if (isset($_POST['login']))
{
    if (empty($_POST['kullanici_mail']) || empty($_POST['kullanici_password']))
    {
        $data['status'] = "error";
        $data['message'] = "Mail ya da şifre boş olamaz";
        echo json_encode($data);
        exit;
    }


    $kullanicisor = $db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail and kullanici_password=:password");
    $kullanicisor->execute(array(
        'mail' => $_POST['kullanici_mail'],
        'password' => md5($_POST['kullanici_password'])
    ));
    $say = $kullanicisor->rowCount();

    if ($say > 0)
    {

        $_SESSION['userkullanici_mail'] = $_POST['kullanici_mail'];

        $data['status'] = "success";
        $data['message'] = "Giriş Başarılı";
        echo json_encode($data);
    }
    else
    {
        $data['status'] = "error";
        $data['message'] = "Kullanıcı Bulunamadı";
        echo json_encode($data);
    }
}
if ($_GET['adaysil'] == "ok")
{

    $sil = $db->prepare("DELETE from aday WHERE aday_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['aday_id']
    ));
    if ($kontrol)
    {
        Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarili");
    }
    else
    {
        Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarisiz");
    }
}

if (isset($_POST['adayekle']))
{
    if ($_FILES['file']['size'] > 1000000)
    {

        $data['status'] = "error";
        $data['message'] = "Resim boyutu 1Mb'tan büyük olamaz";
        echo json_encode($data);
        exit;
    }
    $izinli_uzantilar = array('jpg', 'png');
    $ext = strtolower(substr($_FILES['file']['name'], strpos($_FILES['file']['name'], '.') + 1));
    if ((in_array($ext, $izinli_uzantilar) === false))
    {
        $data['status'] = "error";
        $data['message'] = "Sadece JPG ve PNG uzantılı resimler yüklenebilir";
        echo json_encode($data);
    }

    $uploads_dir = '../../img/adayresim';

    @$tmp_name = $_FILES['file']['tmp_name'];
    @$name = $_FILES['file']['name'];
    $uniq = uniqid();
    $refimgyol = substr($uploads_dir, 6) . "/" . $uniq . "." . $ext;
    @move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

    $kaydet = $db->prepare("INSERT INTO aday SET
           aday_adsoyad=:adsoyad,
           aday_resimyol=:resimyol
             ");
    $insert = $kaydet->execute(array(
        'adsoyad' => $_POST['aday_adsoyad'],
        'resimyol' => $refimgyol
    ));

    if ($insert)
    {
        $data['status'] = "success";
        $data['message'] = "Kayıt başarılı";
        echo json_encode($data);
        exit;
    }
    else
    {
        $data['status'] = "error";
        $data['message'] = "Kayıt başarısız";
        echo json_encode($data);
        exit;
    }
}



if (isset($_POST['adayduzenle']))
{
    if ($_FILES['file']['size'] > 1000000)
    {

        $data['status'] = "error";
        $data['message'] = "Resim boyutu 1Mb'tan büyük olamaz";
        echo json_encode($data);
        exit;
    }
    $izinli_uzantilar = array('jpg', 'png');
    $ext = strtolower(substr($_FILES['file']['name'], strpos($_FILES['file']['name'], '.') + 1));
    if ((in_array($ext, $izinli_uzantilar) === false))
    {
        $data['status'] = "error";
        $data['message'] = "Sadece JPG ve PNG uzantılı resimler yüklenebilir";
        echo json_encode($data);
    }

    $uploads_dir = '../../img/adayresim';

    @$tmp_name = $_FILES['file']['tmp_name'];
    @$name = $_FILES['file']['name'];
    $uniq = uniqid();
    $refimgyol = substr($uploads_dir, 6) . "/" . $uniq . "." . $ext;
    @move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

    $kaydet = $db->prepare("UPDATE aday SET
           aday_adsoyad=:adsoyad,
           aday_resimyol=:resimyol
           WHERE aday_id={$_POST['aday_id']};
             ");
    $guncelle = $kaydet->execute(array(
        'adsoyad' => $_POST['aday_adsoyad'],
        'resimyol' => $refimgyol
    ));

    if ($guncelle)
    {
        unlink("../../{$_POST['eski_yol']}");
        $data['status'] = "success";
        $data['message'] = "Güncelleme başarılı";
        echo json_encode($data);
        exit;
    }
    else
    {
        $data['status'] = "error";
        $data['message'] = "Güncelleme başarısız";
        echo json_encode($data);
        exit;
    }
}

if (isset($_POST['ayarekle']))
{
    if (strlen($_POST['ayar_ad']) == 0 || strlen($_POST['ayar_tur']) == 0)
    {
        $data['status'] = "error";
        $data['message'] = "Tüm alanları doldurmalısınız";
        echo json_encode($data);
        exit;
    }
    $kaydet = $db->prepare("INSERT INTO ayar SET
           ayar_ad=:ad,
           ayar_tur=:tur
             ");
    $insert = $kaydet->execute(array(
        'ad' => htmlspecialchars($_POST['ayar_ad']),
        'tur' => htmlspecialchars($_POST['ayar_tur'])
    ));

    if ($insert)
    {
        session_destroy();
        $data['status'] = "success";
        $data['message'] = "Kayıt başarılı";
        echo json_encode($data);
        exit;
    }
    else
    {
        $data['status'] = "error";
        $data['message'] = "Kayıt başarısız";
        echo json_encode($data);
        exit;
    }
}
if ($_GET['ayarsil'] == "ok")
{

    $sil = $db->prepare("DELETE from ayar WHERE ayar_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['ayar_id']
    ));
    if ($kontrol)
    {
        Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarili");
    }
    else
    {
        Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarisiz");
    }
}

if (isset($_POST['ayarduzenle']))
{
    if (strlen($_POST['ayar_ad']) == 0 || strlen($_POST['ayar_tur']) == 0)
    {
        $data['status'] = "error";
        $data['message'] = "Tüm alanları doldurmalısınız";
        echo json_encode($data);
        exit;
    }
    $ayar_id = base64_decode($_POST['ayar_id']);
    $kaydet = $db->prepare("UPDATE ayar SET
           ayar_ad=:ad,
           ayar_tur=:tur
           WHERE ayar_id=$ayar_id");
    $guncelle = $kaydet->execute(array(
        'ad' => htmlspecialchars($_POST['ayar_ad']),
        'tur' => htmlspecialchars($_POST['ayar_tur'])
    ));

    if ($guncelle)
    {
        session_destroy();
        $data['status'] = "success";
        $data['message'] = "Kayıt başarılı";
        echo json_encode($data);
        exit;
    }
    else
    {
        $data['status'] = "error";
        $data['message'] = "Kayıt başarısız";
        echo json_encode($data);
        exit;
    }
}

if (isset($_POST['oymail']))
{
    if (empty($_POST['kullanici_mail']))
    {
        $data['status'] = "error";
        $data['message'] = "Mail adresinizi giriniz";
        echo json_encode($data);
        exit;
    }

    $oysor = $db->prepare("SELECT * FROM oy WHERE oy_araci=:araci");
    $oysor->execute(array(
        'araci' => $_POST['kullanici_mail']
    ));
    $say = $oysor->rowCount();
    if ($say > 0)
    {
        $_SESSION['oydurum'] = 1;

        $data['status'] = "info";
        $data['message'] = "Maalesef daha önce oy kullandınız.Sonuçları görebilirsiniz.";
        $data['oydurum'] = "1";
        echo json_encode($data);
        exit;
    }

    $mailKonu = "Seçim Aday Mail Onay Şifreniz";
    $mesaj = rand(1000, 9999);
    $_SESSION['anketmailonaymesaj'] = $mesaj;
    $_SESSION['kullanici_mail'] = $_POST['kullanici_mail'];
    mailgonder($_POST['kullanici_mail'], $mailKonu, $mesaj);
    $data['status'] = "success";
    $data['message'] = "Onay kodunuz gönderilmiştir.Mail adresinizi kontrol ediniz.Spam klasörüne düşmüş olabilir.";
    $data['islemno'] = "1";
    echo json_encode($data);
    exit;
}
if (isset($_POST['onaykodu']))
{
    if ($_SESSION['anketmailonaymesaj'] == $_POST['kullanici_onaykodu'])
    {
        $kaydet = $db->prepare("INSERT INTO oy SET
           aday_id=:id,
           oy_araci=:araci
             ");
        $insert = $kaydet->execute(array(
            'id' => $_POST['aday_id'],
            'araci' => $_SESSION['kullanici_mail']
        ));

        if ($insert)
        {
            $_SESSION['oydurum'] = 1;
            $data['status'] = "success";
            $data['message'] = "Oyunuz başarıyla kaydedildi";
            $data['islemno'] = "2";
            echo json_encode($data);
            exit;
        }
        else
        {
            $data['status'] = "error";
            $data['message'] = "Oy verme işlemi başarısız";
            echo json_encode($data);
            exit;
        }
    }
    else
    {
        $data['status'] = "error";
        $data['message'] = "Onay kodu hatalı";
        echo json_encode($data);
        exit;
    }
}


if (isset($_POST['sonucsorgula']))
{
    if (empty($_POST['oy_araci']))
    {
        $data['status'] = "error";
        $data['message'] = "Oy kullanmadan sonuçları göremezsiniz.Oy kullandıysanız mail adresinizi ya da cep telefonunuzu girmelisiniz.";
        echo json_encode($data);
        exit;
    }

    $oysor = $db->prepare("SELECT * FROM oy WHERE oy_araci=:araci");
    $oysor->execute(array(
        'araci' => $_POST['oy_araci']
    ));
    $say = $oysor->rowCount();
    if ($say > 0)
    {
        $_SESSION['oydurum'] = 1;

        $data['status'] = "info";
        $data['message'] = "Maalesef daha önce oy kullandınız.Sonuçları görebilirsiniz.";
        $data['oydurum'] = "1";
        $data['oyyok'] = 1;
        echo json_encode($data);
        exit;
    }
    else
    {
        $data['status'] = "info";
        $data['message'] = "Maalesef henüz oy kullanmadınız.Sonuçları sadece oy kullananlar görebilir.";
        $data['oyyok'] = 0;
        echo json_encode($data);
        exit;
    }

    $mailKonu = "Seçim Aday Mail Onay Şifreniz";
    $mesaj = rand(1000, 9999);
    $_SESSION['anketmailonaymesaj'] = $mesaj;
    $_SESSION['kullanici_mail'] = $_POST['kullanici_mail'];
    mailgonder($_POST['kullanici_mail'], $mailKonu, $mesaj);
    $data['status'] = "success";
    $data['message'] = "Onay kodunuz gönderilmiştir.Mail adresinizi kontrol ediniz.Spam klasörüne düşmüş olabilir.";
    $data['islemno'] = "1";
    echo json_encode($data);
    exit;
}
### SMS işlemleri ###
if (isset($_POST['oysms']))
{
    if (empty($_POST['kullanici_gsm']))
    {
        $data['status'] = "error";
        $data['message'] = "Cep telefonu numaranızı giriniz.";
        echo json_encode($data);
        exit;
    }

    $oysor = $db->prepare("SELECT * FROM oy WHERE oy_araci=:araci");
    $oysor->execute(array(
        'araci' => $_POST['kullanici_gsm']
    ));
    $say = $oysor->rowCount();
    if ($say > 0)
    {
        $_SESSION['oydurum'] = 1;

        $data['status'] = "info";
        $data['message'] = "Maalesef daha önce oy kullandınız.Sonuçları görebilirsiniz.";
        $data['oydurum'] = "1";
        echo json_encode($data);
        exit;
    }
    

    
    $onaykodu = rand(1000, 9999);
    $text = "Seçim anketi onay kodunuz:$onaykodu";
    $im  = new IMVerify();
    $gsm = str_replace("-", "", $_POST['kullanici_gsm']);

    $smssonuc= $im->send($gsm);
    $_SESSION['anketsmsonaymesaj']=$onaykodu;
    $_SESSION['kullanici_gsm']=$gsm;

    $data['status'] = "success";
    $data['message'] = "Onay kodunuz gönderilmiştir.";
    $data['islemno'] = "1";
    echo json_encode($data);
    exit;
}

if (isset($_POST['onaykodusms']))
{
    if ($_SESSION['anketsmsonaymesaj'] == $_POST['kullanici_smsonaykodu'])
    {
        $kaydet = $db->prepare("INSERT INTO oy SET
           aday_id=:id,
           oy_araci=:araci
             ");
        $insert = $kaydet->execute(array(
            'id' => $_POST['aday_id'],
            'araci' => $_SESSION['kullanici_gsm']
        ));

        if ($insert)
        {
            $_SESSION['oydurum'] = 1;
            $data['status'] = "success";
            $data['message'] = "Oyunuz başarıyla kaydedildi";
            $data['islemno'] = "2";
            echo json_encode($data);
            exit;
        }
        else
        {
            $data['status'] = "error";
            $data['message'] = "Oy verme işlemi başarısız";
            echo json_encode($data);
            exit;
        }
    }
    else
    {
        $data['status'] = "error";
        $data['message'] = "Onay kodu hatalı";
        echo json_encode($data);
        exit;
    }
}
?>
